<?php

namespace App\Http\Controllers\API;

use App\Models\AccType;                        // change this and below all lines
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class AccTypeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['accType'] = AccType::all();        
        return $this->sendResponse($data, 'All Account Type Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateAccType = Validator::make(
            $request->all(),
            [
                'accTypeTitle' => 'required',
                'uId' => 'required',
            ]
        );
        // return $validateAccType;

        if ($validateAccType->fails()) {
            return $this->sendError('Validation Error', $validateAccType->errors()->all());
        }

     
        $data = AccType::create([
            'accTypeTitle' => $request->accTypeTitle,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($data, 'Account Type Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = AccType::select('accTypeId', 'accTypeTitle', 'uId')->where('accTypeId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Account Type not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Account Type');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateAccType = Validator::make(
            $request->all(),
            [
                'accTypeTitle' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateAccType->fails()) {
            return $this->sendError('Validation Error', $validateAccType->errors()->all());
        }

        $data = AccType::where(['accTypeId' => $id])->update([
            'accTypeTitle' => $request->accTypeTitle,
            'uId' => $request->uId,            
        ]);
        return $this->sendResponse($data, 'AccType Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = AccType::where('accTypeId', $id)->delete();

        return $this->sendResponse($data, 'Account Type Deleted Successfully');
    }
}
