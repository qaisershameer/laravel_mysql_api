<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Vouchers;                        
use App\Models\VouchersDetail;                 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class VouchersController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $uId = $request->uId;
        $voucherPrefix = $request->voucherPrefix;

        $data['vouchers'] = Vouchers::select('vouchers.voucherId',
                                            'vouchers.voucherDate',
                                            'vouchers.voucherPrefix',
                                            'vouchers.remarks',
                                            'vouchers.drAcId',
                                            'vouchers.crAcId',
                                            'vouchers.debit',
                                            'vouchers.credit',
                                            'vouchers.debitSR',
                                            'vouchers.creditSR',
                                            'vouchers.uId',
                                            'accounts_dr.acTitle as drAcTitle',
                                            'accType_dr.accTypeTitle as drAcTypeTitle',
                                            'accounts_cr.acTitle as crAcTitle',
                                            'accType_cr.accTypeTitle as crAcTypeTitle')
                                            ->leftJoin('vouchersdetail', 'vouchers.voucherId', '=', 'vouchersdetail.voucherId')
                                            ->leftJoin('accounts as accounts_dr', 'vouchers.drAcId', '=', 'accounts_dr.acId')
                                            ->leftJoin('accType as accType_dr', 'accounts_dr.accTypeId', '=', 'accType_dr.accTypeId')
                                            ->leftJoin('accounts as accounts_cr', 'vouchers.crAcId', '=', 'accounts_cr.acId')
                                            ->leftJoin('accType as accType_cr', 'accounts_cr.accTypeId', '=', 'accType_cr.accTypeId')
                                        ->where('vouchers.uId', $uId)
                                        ->where('vouchers.voucherPrefix', $voucherPrefix)
                                        ->orderBy('vouchers.voucherDate')
                                        ->orderBy('vouchers.updated_at')
                                        ->get();
            
        return $this->sendResponse($data, 'All Vouchers Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateVouchers = Validator::make(
            $request->all(),
            [
                'voucherDate' => 'required',
                'voucherPrefix' => 'required',
                'uId' => 'required',
                // 'drAcId' => 'nullable|numeric',
                // 'crAcId' => 'nullable|numeric',
            ]
        );

        if ($validateVouchers->fails()) {
            return $this->sendError('Validation Error', $validateVouchers->errors()->all());
        }

        $voucherDate = $request->voucherDate;        
        // $formattedDate = Carbon::createFromFormat('d-m-Y', $voucherDate)->format('Y-m-d');
        $formattedDate = Carbon::parse($request->voucherDate)->format('Y-m-d');
        
       DB::beginTransaction();
        try {
            $voucher = Vouchers::create([
                'voucherDate' => $formattedDate,
                'voucherPrefix' => $request->voucherPrefix,
                'remarks' => $request->remarks,
                'drAcId' => $request->drAcId,
                'crAcId' => $request->crAcId,
                'debit' => $request->debit,
                'credit' => $request->credit,
                'debitSR' => $request->debitSR,
                'creditSR' => $request->creditSR,
                'uId' => $request->uId,
            ]);

            // // Check if the voucher was created successfully and has a valid ID
            // if (!$voucher || !$voucher->voucherId) {
            //     DB::rollBack();
            //     return $this->sendError('Voucher not created or ID is null.');
            // }

            // // Call the function to save voucher details
            // if($request->drAcId != 0){
            //     $this->saveVoucherDetails($voucher->voucherId, $request->drAcId, $request, true);   // true for debit entry
            // }

            // if($request->crAcId != 0){
            //     $this->saveVoucherDetails($voucher->voucherId, $request->crAcId, $request, false);  // false for credit entry
            // }
            
            // // Retrieve the saved details
            // $voucherDetails = VouchersDetail::where('voucherId', $voucher->voucherId)->get();

            DB::commit(); // Only commit if both succeed

            // return $this->sendResponse([$voucher, $voucherDetails], 'Voucher Created Successfully');
            return $this->sendResponse([$voucher], 'Voucher Created Successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Database Error', $e->getMessage());
        }
    }

    protected function saveVoucherDetails($voucherId, $acId, Request $request, bool $debit)
    {
        // Save detail record
        VouchersDetail::create([
            'voucherId' => $voucherId,
            'uId' => $request->uId,
            'acId' => $acId,
            'remarksDetail' => $request->remarks,
            'debit' => $debit ? $request->debit : 0,            // If it's a debit, set debit value, else 0
            'credit' => !$debit ? $request->credit : 0,         // If it's not a debit, set credit value, else 0
            'debitSR' => $debit ? $request->debitSR : 0,
            'creditSR' => !$debit ? $request->creditSR : 0,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Vouchers::select('voucherId', 'voucherDate', 'voucherPrefix', 'remarks',
        'drAcId', 'crAcId','debit', 'credit', 'debitSR', 'creditSR', 'uId')->where('voucherId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Voucher not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Voucher Master Table');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateVouchers = Validator::make(
            $request->all(),
            [
                'voucherDate' => 'required',
                'voucherPrefix' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateVouchers->fails()) {
            return $this->sendError('Validation Error', $validateVouchers->errors()->all());
        }

        // $dataDetail = VouchersDetail::where('voucherId', $id)->delete();    // delete all details entry on update on behalf of voucherId        

        $voucherDate = $request->voucherDate;        
        // $formattedDate = Carbon::createFromFormat('d-m-Y', $voucherDate)->format('Y-m-d');
        $formattedDate = Carbon::parse($request->voucherDate)->format('Y-m-d');

        DB::beginTransaction();
        try {

            $voucher = Vouchers::where(['voucherId' => $id])->update([
                'voucherDate' => $formattedDate,
                'voucherPrefix' => $request->voucherPrefix,
                'remarks' => $request->remarks,
                'drAcId' => $request->drAcId,
                'crAcId' => $request->crAcId,                                
                'debit' => $request->debit,
                'credit' => $request->credit,
                'debitSR' => $request->debitSR,
                'creditSR' => $request->creditSR,
                'uId' => $request->uId,
            ]);
                    
            // // Call the function to save voucher details
            // if($request->drAcId != 0){
            //     $this->saveVoucherDetails($id, $request->drAcId, $request, true);   // true for debit entry
            // }

            // if($request->crAcId != 0){
            //     $this->saveVoucherDetails($id, $request->crAcId, $request, false);  // false for credit entry
            // }
            
            // // Retrieve the saved details
            // $voucherDetails = VouchersDetail::where('voucherId', $id)->get();

            DB::commit(); // Only commit if both succeed

            // return $this->sendResponse([$voucher, $voucherDetails], 'Voucher Updated Successfully');            
            return $this->sendResponse([$voucher], 'Voucher Updated Successfully');            
            
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Database Error', $e->getMessage());
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
        // $dataDetail = VouchersDetail::where('voucherId', $id)->delete();
        $data = Vouchers::where('voucherId', $id)->delete();
        return $this->sendResponse($data, 'Vouchers Deleted Successfully');

    }
}
