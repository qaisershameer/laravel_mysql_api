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
    public function index()
    {
        $data['currency'] = Post::all();        
        return $this->sendResponse($data, 'All Currency Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateCurrency = Validator::make(
            $request->all(),
            [
                'CurrencyTitle' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateCurrency->fails()) {
            return $this->sendError('Validation Error', $validateCurrency->errors()->all());
        }

        $post = Currency::create([
            'CurrencyTitle' => $request->title,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($post, 'Currency Created Successfully');
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
                'CurrencyTitle' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateCurrency->fails()) {
            return $this->sendError('Validation Error', $validateCurrency->errors()->all());
        }

        $post = Curency::where(['currencyId' => $id])->update([
            'currencyTitle' => $request->title,
            'uId' => $request->description,            
        ]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = Currency::where('currencyId', $id)->delete();

        return $this->sendResponse($post, 'Currency Deleted Successfully');
    }
}
