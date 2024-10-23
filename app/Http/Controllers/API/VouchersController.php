<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Vouchers;                        // change this and below all lines
use Illuminate\Http\Request;
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
                                            'vouchers.remarksMaster',
                                            'vouchers.sumDebit',
                                            'vouchers.sumCredit',
                                            'vouchers.sumDebitSR',
                                            'vouchers.sumCreditSR',
                                            'vouchers.uId',
                                            'vouchersdetail.remarksDetail',
                                            'vouchersdetail.debit', 
                                            'vouchersdetail.credit',
                                            'vouchersdetail.debitSR',
                                            'vouchersdetail.creditSR',
                                            'vouchersdetail.acId',
                                            'accounts.acTitle')
                                        ->leftJoin('vouchersdetail', 'vouchers.voucherId', '=', 'vouchersdetail.voucherId')
                                        ->leftJoin('accounts', 'vouchersdetail.acId', '=', 'accounts.acId')
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
            ]
        );
        // return $validateVouchers;

        if ($validateVouchers->fails()) {
            return $this->sendError('Validation Error', $validateVouchers->errors()->all());
        }

        $voucherDate = $request->voucherDate; // Assuming you get this from the request        
        $formattedDate = Carbon::createFromFormat('d-m-Y', $voucherDate)->format('Y-m-d'); // Convert to correct format
        
        $acId = ($request->voucherPrefix == 'CR') ? $request->crAcId : (($request->voucherPrefix == 'CP') ? $request->drAcId : null);

        try {
            $voucher = Vouchers::create([
                'voucherDate' => $formattedDate,
                'voucherPrefix' => $request->voucherPrefix,
                'remarksMaster' => $request->remarksMaster,
                'sumDebit' => $request->sumDebit,
                'sumCredit' => $request->sumCredit,
                'sumDebitSR' => $request->sumDebitSR,
                'sumCreditSR' => $request->sumCreditSR,
                'uId' => $request->uId,
            ]);
        } catch (\Exception $e) {
            return $this->sendError('Database Error', $e->getMessage());
        }
    
        if (!$voucher) {
            return $this->sendError('Voucher not created.');
        }

        // Validate the detail data
        $validateDetail = Validator::make(
            $request->all(),
            [
                'uId' => 'required',
                'drAcId' => 'nullable|numeric',
                'crAcId' => 'nullable|numeric',                
                'debit' => 'nullable|numeric',
                'debitSR' => 'nullable|numeric',
                'credit' => 'nullable|numeric',
                'creditSR' => 'nullable|numeric',
            ]
        );        

        if ($validateDetail->fails()) {
            return $this->sendError('Validation Error', $validateDetail->errors()->all());
        }


         // Save the detail data
            $detailData = VouchersDetail::create([
            'voucherId' => $voucher->id, // Use the master ID
            'uId' => $request->uId,
            'acId' => $request->crAcId,
            'remarksDetail' => $request->remarks,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'debitSR' => $request->debitSR,
            'creditSR' => $request->creditSR,
        ]);

        // return $this->sendResponse($data, 'Vouchers Created Successfully');
        return $this->sendResponse([$voucher, $detailData], 'Vouchers Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Vouchers::select('voucherId', 'voucherDate', 'voucherPrefix', 'remarksMaster',
        'sumDebit', 'sumCredit', 'sumDebitSR', 'sumCreditSR', 'uId')->where('voucherId', $id)->first();

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

        $data = Vouchers::where(['voucherId' => $id])->update([
            'voucherDate' => $request->voucherDate,
            'voucherPrefix' => $request->voucherPrefix,
            'remarksMaster' => $request->remarksMaster,
            'sumDebit' => $request->sumDebit,
            'sumCredit' => $request->sumCredit,
            'sumDebitSR' => $request->sumDebitSR,
            'sumCreditSR' => $request->sumCreditSR,            
            'uId' => $request->uId,            
        ]);
        return $this->sendResponse($data, 'Vouchers Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Vouchers::where('voucherId', $id)->delete();

        return $this->sendResponse($data, 'Vouchers Deleted Successfully');
    }
}
