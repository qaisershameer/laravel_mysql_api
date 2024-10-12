<?php

namespace App\Http\Controllers\API;

use App\Models\AccParent;                        // change this and below all lines
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class AccParentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $uId = $request->uId;
        $data['accParent'] = AccParent::where('uId', $uId)
                                ->orderBy('accParentTitle')
                                ->get();        
        return $this->sendResponse($data, 'All Parent Account Data');  
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateaccParent = Validator::make(
            $request->all(),
            [
                'accParentTitle' => 'required',
                'accTypeId' => 'required',
                'uId' => 'required',
            ]
        );
        // return $validateaccParent;

        if ($validateaccParent->fails()) {
            return $this->sendError('Validation Error', $validateaccParent->errors()->all());
        }

        $data = AccParent::create([
            'accParentTitle' => $request->accParentTitle,
            'accTypeId' => $request->accTypeId,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($data, 'Parent Account Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = AccParent::select('parentId', 'accParentTitle', 'accTypeId', 'uId')->where('parentId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'accParent not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Parent Account');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateaccParent = Validator::make(
            $request->all(),
            [
                'accParentTitle' => 'required',
                'accTypeId' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateaccParent->fails()) {
            return $this->sendError('Validation Error', $validateaccParent->errors()->all());
        }

        $data = accParent::where(['parentId' => $id])->update([
            'accParentTitle' => $request->accParentTitle,
            'accTypeId' => $request->accTypeId,            
            'uId' => $request->uId,            
        ]);
        return $this->sendResponse($data, 'Parent Account Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = accParent::where('parentId', $id)->delete();

        return $this->sendResponse($data, 'Parent Account Deleted Successfully');
    }
}
