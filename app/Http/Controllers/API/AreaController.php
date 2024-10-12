<?php

namespace App\Http\Controllers\API;

use App\Models\Area;                        // change this and below all lines
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Http\Controllers\API\BaseController as BaseController;


class AreaController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $uId = $request->uId;
        $data['area'] = Area::where('uId', $uId)
                                ->orderBy('areaTitle')
                                ->get();
        return $this->sendResponse($data, 'All Area Data');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateArea = Validator::make(
            $request->all(),
            [
                'areaTitle' => 'required',
                'uId' => 'required',
            ]
        );
        // return $validateArea;

        if ($validateArea->fails()) {
            return $this->sendError('Validation Error', $validateArea->errors()->all());
        }

     
        $data = Area::create([
            'areaTitle' => $request->areaTitle,
            'uId' => $request->uId,            
        ]);

        return $this->sendResponse($data, 'Area Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data['post'] = Area::select('areaId', 'areaTitle', 'uId')->where('areaId', $id)->first();

        if (!$data['post']) {
            return response()->json([
                'status' => false,
                'message' => 'Area not found',
            ], 404);
        }

        return $this->sendResponse($data, 'Your Single Area');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        $validateArea = Validator::make(
            $request->all(),
            [
                'areaTitle' => 'required',
                'uId' => 'required',
            ]
        );

        if ($validateArea->fails()) {
            return $this->sendError('Validation Error', $validateArea->errors()->all());
        }

        $data = Area::where(['AreaId' => $id])->update([
            'areaTitle' => $request->areaTitle,
            'uId' => $request->uId,            
        ]);
        return $this->sendResponse($data, 'Area Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $data = Area::where('AreaId', $id)->delete();

        return $this->sendResponse($data, 'Area Deleted Successfully');
    }
}
