<?php

namespace App\Http\Controllers\API;

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
    public function index()
    {
        $data['vouchers'] = Vouchers::all();        
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

        $data = Vouchers::create([
            'voucherDate' => $request->voucherDate,
            'voucherPrefix' => $request->voucherPrefix,
            'remarksMaster' => $request->remarksMaster,
            'sumDebit' => $request->sumDebit,
            'sumCredit' => $request->sumCredit,
            'sumDebitSR' => $request->sumDebitSR,
            'sumCreditSR' => $request->sumCreditSR,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($data, 'Vouchers Created Successfully');
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

        return $this->sendResponse($data, 'Your Single Vouchers');
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
