<?php

namespace App\Http\Controllers\API;

use App\Models\Currency;                        // change this and below all lines

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;

class CuurencyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $uId = $request->uId;
        $data['currency'] = Currency::where('uId', $uId)
                                ->orderBy('currencyTitle')
                                ->get();
        return $this->sendResponse($data, 'All Currency Data'); 

        // $data['currency'] = Currency::all();        
        // return $this->sendResponse($data, 'All Currency Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateCurrency = Validator::make(
            $request->all(),
            [
                'currencyTitle' => 'required',
                'uId' => 'required',
            ]
        );
        // return $validateCurrency;

        if ($validateCurrency->fails()) {
            return $this->sendError('Validation Error', $validateCurrency->errors()->all());
        }

     
        $data = Currency::create([
            'currencyTitle' => $request->currencyTitle,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($data, 'Currency Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Currency::select('currencyId', 'currencyTitle', 'uId')->where('currencyId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Currency not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Currency');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateCurrency = Validator::make(
            $request->all(),
            [
                'currencyTitle' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateCurrency->fails()) {
            return $this->sendError('Validation Error', $validateCurrency->errors()->all());
        }

        $data = Currency::where(['currencyId' => $id])->update([
            'currencyTitle' => $request->currencyTitle,
            'uId' => $request->uId,            
        ]);
        return $this->sendResponse($data, 'Currency Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Currency::where('currencyId', $id)->delete();

        return $this->sendResponse($data, 'Currency Deleted Successfully');
    }
}
