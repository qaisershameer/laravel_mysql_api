<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Vouchers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class TrialController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $uId = $request->uId;
        $areaId = $request->areaId;
        $accTypeId = $request->accTypeId;

        $dateFrom = $request->dateFrom;
        $dateTo = $request->dateTo;
    
        $formatFrom = Carbon::parse($dateFrom)->format('Y-m-d');
        $formatTo = Carbon::parse($dateTo)->format('Y-m-d');
    
        // Query for debit sums
        $debits = Vouchers::select(
                'drAcId AS acId', 
                'accounts.acTitle',
                'accType.accTypeTitle',
                DB::raw('SUM(debit) AS debit'),
                DB::raw('SUM(debitSR) AS debitSR'),
                DB::raw('0 AS credit'),
                DB::raw('0 AS creditSR')
            )
                ->leftJoin('accounts', 'vouchers.drAcId', '=', 'accounts.acId')
                ->leftJoin('accType AS accType', 'accounts.accTypeId', '=', 'accType.accTypeId')
                ->where('vouchers.uId', $uId)
                ->where('accounts.areaId', $areaId)
                ->where('accounts.accTypeId', $accTypeId)
                ->whereBetween('vouchers.voucherDate', [$formatFrom, $formatTo])
                ->groupBy('drAcId', 'accounts.acTitle', 'accType.accTypeTitle');

        // Query for credit sums
        $credits = Vouchers::select(
                'crAcId AS acId', 
                'accounts.acTitle',
                'accType.accTypeTitle',
                DB::raw('0 AS debit'),
                DB::raw('0 AS debitSR'),
                DB::raw('SUM(credit) AS credit'),
                DB::raw('SUM(creditSR) AS creditSR')
            )
                ->leftJoin('accounts', 'vouchers.crAcId', '=', 'accounts.acId')
                ->leftJoin('accType', 'accounts.accTypeId', '=', 'accType.accTypeId')
                ->where('vouchers.uId', $uId)
                ->where('accounts.areaId', $areaId)
                ->where('accounts.accTypeId', $accTypeId)
                ->whereBetween('vouchers.voucherDate', [$formatFrom, $formatTo])
                ->groupBy('crAcId', 'accounts.acTitle', 'accType.accTypeTitle');

            // Combine both queries using union
            $debitResults = $debits->get();  // Get results for debits
            $creditResults = $credits->get(); // Get results for credits

            // Merge the results
            $mergedResults = $debitResults->merge($creditResults);

            // Group by the necessary fields
            $groupedResults = $mergedResults->groupBy(function ($item) {
                return $item->acId; // Group by acId
            });

            // Prepare final data
            $data['vouchers'] = $groupedResults->map(function ($items, $key) {
                return [
                    'acId' => $key,
                    'acTitle' => $items->first()->acTitle,
                    'accTypeTitle' => $items->first()->accTypeTitle,
                    'debit' => $items->sum('debit'),
                    'credit' => $items->sum('credit'),
                    'debitSR' => $items->sum('debitSR'),
                    'creditSR' => $items->sum('creditSR'),
                ];
            })->values(); // Get the final indexed array

            return $this->sendResponse($data, 'Trial Balance Data');
    }
}
