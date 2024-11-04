<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Vouchers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class CashBookController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        {
            $uId = $request->uId;
            $voucherPrefix = $request->voucherPrefix;
            $dateFrom = $request->dateFrom;
            $dateTo = $request->dateTo;

            $formatFrom = Carbon::parse($request->dateFrom)->format('Y-m-d');
            $formatTo = Carbon::parse($request->dateTo)->format('Y-m-d');

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
                                            ->whereIn('vouchers.voucherPrefix', ['CR', 'CP'])
                                            ->whereBetween('vouchers.voucherDate', [$formatFrom, $formatTo])
                                            // ->where('vouchers.voucherPrefix', $voucherPrefix)
                                            ->orderBy('vouchers.voucherDate', 'desc')
                                            ->orderBy('vouchers.updated_at', 'desc')
                                            ->get();
                
            return $this->sendResponse($data, 'Cash Book Vouchers Data');
        }
    }

}
