<?php

namespace App\Http\Controllers\API;

use App\Models\Accounts;                        // change this and below all lines
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class AccountsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $uId = $request->uId;
        $data['accounts'] = Accounts::where('uId', $uId)
                                ->orderBy('acTitle')
                                ->get();        
    return $this->sendResponse($data, 'All Accounts Data');       
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateAccounts = Validator::make(
            $request->all(),
            [
                'acTitle' => 'required',
                'uId' => 'required',
                'currencyId' => 'required',
                'accTypeId' => 'required',
                'parentId' => 'required',                
            ]
        );
        // return $validateAccounts;

        if ($validateAccounts->fails()) {
            return $this->sendError('Validation Error', $validateAccounts->errors()->all());
        }

        $data = Accounts::create([
            'acTitle' => $request->acTitle,
            'uId' => $request->uId, 
            'currencyId' => $request->currencyId,
            'accTypeId' => $request->accTypeId,
            'parentId' => $request->parentId,
            'areaId' => $request->areaId,                       
        ]);

        return $this->sendResponse($data, 'Account Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Accounts::select('acId', 'acTitle', 'uId', 'currencyId', 'accTypeId', 'parentId', 'areaId')->where('acId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Account not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Account');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateAccounts = Validator::make(
            $request->all(),
            [
                'acTitle' => 'required',
                'uId' => 'required',
                'currencyId' => 'required',
                'accTypeId' => 'required',
                'parentId' => 'required',                                
            ]
        );

        if ($validateAccounts->fails()) {
            return $this->sendError('Validation Error', $validateAccounts->errors()->all());
        }

        $data = Accounts::where(['acId' => $id])->update([
            'acTitle' => $request->acTitle,
            'uId' => $request->uId,
            'currencyId' => $request->currencyId,
            'accTypeId' => $request->accTypeId,
            'parentId' => $request->parentId,
            'areaId' => $request->areaId,                       
        ]);
        return $this->sendResponse($data, 'Account Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Accounts::where('acId', $id)->delete();

        return $this->sendResponse($data, 'Account Deleted Successfully');
    }
}
