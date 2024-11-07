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
                // ->where('accounts.areaId', $areaId)
                //  ->where('accounts.accTypeId', $accTypeId)
                ->whereBetween('vouchers.voucherDate', [$formatFrom, $formatTo])
                ->groupBy('drAcId', 'accounts.acTitle', 'accType.accTypeTitle')
                ->orderBy('accounts.acTitle', 'desc');

                // Conditionally add the accTypeId filter if it's not 'ALL'
                if ($accTypeId !== 'ALL') {
                    $debits = $debits->where('accounts.accTypeId', $accTypeId);
                }

                // Conditionally add the areaId filter if it's not 'ALL'
                if ($areaId !== 'ALL') {
                    $debits = $debits->where('accounts.areaId', $areaId);
                }

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
                // ->where('accounts.areaId', $areaId)
                // ->where('accounts.accTypeId', $accTypeId)
                ->whereBetween('vouchers.voucherDate', [$formatFrom, $formatTo])
                ->groupBy('crAcId', 'accounts.acTitle', 'accType.accTypeTitle')
                ->orderBy('accounts.acTitle', 'desc');

                // Conditionally add the accTypeId filter if it's not 'ALL'
                if ($accTypeId !== 'ALL') {
                    $credits = $credits->where('accounts.accTypeId', $accTypeId);
                }

                // Conditionally add the areaId filter if it's not 'ALL'
                if ($areaId !== 'ALL') {
                    $credits = $credits->where('accounts.areaId', $areaId);
                }                


                                // // Print the SQL query for the debit query
                                // \Log::info($debits->toSql()); // Logs only the SQL query without bindings
                                // \Log::info($debits->getBindings()); // Logs the bindings used in the query

                                // // Or simply output the complete query including bindings for debug purposes
                                // $query = $debits->toSql();
                                // $bindings = $debits->getBindings();
                                // $fullQuery = vsprintf(str_replace("?", "'%s'", $query), $bindings);
                                // \Log::info($fullQuery); // Logs the full query with bindings

                                // // For the credits query
                                // \Log::info($credits->toSql()); // Logs only the SQL query without bindings
                                // \Log::info($credits->getBindings()); // Logs the bindings

                                // // Combine query and bindings for credits
                                // $query = $credits->toSql();
                                // $bindings = $credits->getBindings();
                                // $fullQuery = vsprintf(str_replace("?", "'%s'", $query), $bindings);
                                // \Log::info($fullQuery); // Logs the full query with bindings



            // Combine both queries using union
            $debitResults = $debits->get();  // Get results for debits
            $creditResults = $credits->get(); // Get results for credits

            // Merge the results
            $mergedResults = $debitResults->merge($creditResults);

            // Group by the necessary fields
            $groupedResults = $mergedResults->groupBy(function ($item) {
                return $item->acId; // Group by acId
            });

            // Sort the results by acTitle (after grouping)
            $sortedResults = $groupedResults->sortBy(function ($item) {
                return $item->first()->acTitle; // Sort by acTitle of the first item in each group
            });

            // Prepare final data
            $data['vouchers'] = $sortedResults->map(function ($items, $key) {
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
