<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EquipmentType;
use App\Http\Resources\EquipmentTypeResource;

class EquipmentTypeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //if () Настройка страниц
        $data = EquipmentType::paginate($request->limit);
        if ($data) {
            return response()->json([
                "success" => true, 
                "list" => EquipmentTypeResource::collection($data),
            ], 200);    
        }
        return response()->json(["success" => false], 200);
    }
}
