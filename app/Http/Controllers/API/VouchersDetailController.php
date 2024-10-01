<?php

namespace App\Http\Controllers\API;

use App\Models\VouchersDetail;                        // change this and below all lines
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class VouchersDetailController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['vouchers'] = VouchersDetail::all();        
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
                'voucherId' => 'required',
                'acId' => 'required',
                'uId' => 'required',
            ]
        );
        // return $validateVouchers;

        if ($validateVouchers->fails()) {
            return $this->sendError('Validation Error', $validateVouchers->errors()->all());
        }

        $data = VouchersDetail::create([
            'voucherId' => $request->voucherId,
            'uId' => $request->uId,
            'acId' => $request->acId,
            'remarksDetail' => $request->remarksDetail,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'debitSR' => $request->debitSR,
            'creditSR' => $request->creditSR,
        ]);

        return $this->sendResponse($data, 'Voucher Detail Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = VouchersDetail::select('voucherId', 'uId', 'acId', 'remarksDetail',
        'debit', 'credit', 'debitSR', 'creditSR', 'uId')->where('voucherDtid', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Voucher Detail not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Voucher Detail');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateVouchers = Validator::make(
            $request->all(),
            [
                'voucherId' => 'required',
                'uId' => 'required',
                'acId' => 'required',
                'remarksDetail' => 'required',
                'debit' => 'required',
                'credit' => 'required',
                'debitSR' => 'required',
                'creditSR' => 'required',
            ]
        );

        if ($validateVouchers->fails()) {
            return $this->sendError('Validation Error', $validateVouchers->errors()->all());
        }

        $data = VouchersDetail::where(['voucherDtid' => $id])->update([
            'voucherId' => $request->voucherId,
            'uId' => $request->uId,
            'acId' => $request->acId,
            'remarksDetail' => $request->remarksDetail,
            'debit' => $request->debit,
            'credit' => $request->credit,
            'debitSR' => $request->debitSR,
            'creditSR' => $request->creditSR,                        
        ]);
        return $this->sendResponse($data, 'Voucher Detail Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = VouchersDetail::where('voucherId', $id)->delete();  // single voucher all detail Entries Delete
        // $data = VouchersDetail::where('voucherDtid', $id)->delete();  // single Detail Entry Delete

        return $this->sendResponse($data, 'Voucher Detail Deleted Successfully');
    }
}
