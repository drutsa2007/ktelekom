<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Http\Requests\EquipmentRequest;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\EquipmentCollection;
use App\Http\Resources\EquipmentTypeResource;
use Illuminate\Support\Facades\Validator;

class EquipmentController extends Controller
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
        $data = Equipment::paginate($request->limit);
        if ($data) {
            return response()->json([
                "success" => true, 
                "list" => EquipmentResource::collection($data),
                //"list2" => $data,
            ], 200);    
        }
        return response()->json(["success" => false], 200);
    }

    /**
     * make mask for request
     */
    private function makeMask($text) {
        $array = str_split($text);
        $last_letter = $array[0];
        $count_letter = 1;
        $a_l = [];
        $a_n = [];
        for($i=1; $i<strlen($text); $i++) {
            if ($array[$i] == $last_letter) {
                $count_letter++;
                if ($i == strlen($text)-1) {
                    array_push($a_l, $last_letter);
                    array_push($a_n, $count_letter);
                };
            }
            else {
                array_push($a_l, $last_letter);
                array_push($a_n, $count_letter);
                $last_letter = $array[$i];
                $count_letter = 1;
            };
        };
        $p = '';
        for($i=0; $i<count($a_l); $i++){
            switch($a_l[$i]) {
                case "N": $p .= "[0-9]{".$a_n[$i]."}"; break;
                case "X": $p .= "[A-Z0-9]{".$a_n[$i]."}"; break;
                case "A": $p .= "[A-Z]{".$a_n[$i]."}"; break;
                case "a": $p .= "[a-z]{".$a_n[$i]."}"; break;
                case "Z": $p .= "[-|_|@]{".$a_n[$i]."}"; break;
            }
        }
        $mask = "regex:/^$p$/";
        return $mask;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->equipments) {
            $records = [];
            $k = 0;
            foreach($request->equipments as $e) {
                $k++;
                if(!empty($e)) {
                    /*return response()->json([
                        "success" => false,
                        "message" => $e,
                    ], 200);*/
                    $type = EquipmentType::find($e['equipment_type_id']);
                    if ($type) {
                        $mask = $type->mask;
                        $messages = [
                            'regex' => "Поле серийный номер в записи $k не совпадает с маской.",
                            'required' => "Поле :attribute обязательное",
                            'min' => "Поле :attribute должно быть более :min",
                            'unique' => "Поле :attribute не уникальное",
                        ];
                        $validator = Validator::make($e, [
                            'equipment_type_id' => ['required'],
                            'serial_number' => ['required', 'unique:equipment,serial_number', $this->makeMask($mask)],
                            'note' => ['min:3']
                        ], $messages);
                        if ($validator->validated()) {
                            $records[] = [
                                "equipment_type_id" => $e['equipment_type_id'],
                                "serial_number" => $e['serial_number'],
                                "note" => $e['note']
                            ];
                        }
                        else {
                            return response()->json([
                                "success" => false,
                                "message" => "Проверьте данные, есть ошибки в записи $k",
                            ], 200);
                        }
                    }
                    else {
                        return response()->json([
                            "success" => false,
                            "message" => "Данного оборудования нет в БД: Запись $k ",
                        ], 200);
                    }
                }
            }
            Equipment::insert($records);
            return response()->json([
                "success" => true,
                "message" => "Записи успешно добавлены",
            ], 200);
        }
        else {
            $type = EquipmentType::find($request->equipment_type_id);
            if ($type) {
                $mask = $type->mask;
                //$validated = $request->validated();
                $messages = [
                    'regex' => "Поле серийный номер в записи $k не совпадает с маской.",
                    'required' => "Поле :attribute обязательное",
                    'min' => "Поле :attribute должно быть более :min",
                    'unique' => "Поле :attribute не уникальное",
                ];
                $validator = Validator::make($request->all(), [
                    'equipment_type_id' => ['required'],
                    'serial_number' => ['required', 'unique:equipment,serial_number', $this->makeMask($mask)],
                    'note' => ['min:3']
                ], $messages);
                if ($validator->validated()) {
                    $record = new Equipment;
                    $record->equipment_type_id = $request->equipment_type_id;
                    $record->serial_number = $request->serial_number;
                    $record->note = $request->note;
                    $record->save();
                    return response()->json([
                        "success" => true,
                        "message" => "Новая запись успешно создана",
                        /*"regex" => $this->makeMask($mask),
                        "mask" => $mask,
                        "serial" => $request->serial_number,
                        "set" => preg_match($this->makeMask($mask), $request->serial_number),
                        "valid" => $validator->validated(),*/
                    ], 200);
                }
                else {
                    return response()->json([
                        "success" => false,
                        "message" => "Серийный номер не подходит по маске",
                    ], 200);
                }
                
            }
            return response()->json([
                "success" => false,
                "message" => "Данного оборудования нет в БД",
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Equipment::find($id);
        if ($data) {
            return response()->json([
                "success" => true, 
                "subject" => EquipmentResource::make($data),
            ], 200);    
        }
        return response()->json(["success" => false], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $record = Equipment::find($id);
        if ($record) {
            $type = EquipmentType::find($request->equipment_type_id);
            if ($type) {
                $mask = $type->mask;
                $messages = [
                    'regex' => "Поле серийный номер не совпадает с маской.",
                    'required' => "Поле :attribute обязательное",
                    'min' => "Поле :attribute должно быть более :min",
                    'unique' => "Поле :attribute не уникальное",
                ];
                $rules = [
                    'equipment_type_id' => ['required'],
                    'serial_number' => ['required', 'unique:equipment,serial_number', $this->makeMask($mask)],
                    'note' => ['min:3']
                ];
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->validated()) {
                    $record->equipment_type_id = $request->equipment_type_id;
                    $record->serial_number = $request->serial_number;
                    $record->note = $request->note;
                    $record->save();
                    return response()->json([
                        "success" => true, 
                        "subject" => "Record is update",
                    ], 201);    
                }
            }
            else {
                return response()->json([
                    "success" => false, 
                    "subject" => "Нет такого оборудования",
                ], 200);
            }
        }
        return response()->json(["success" => false, "message" => "Такой записи нет"], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $record = Equipment::find($id);
        if ($record) {
            Equipment::find($id)->delete($id);
            return response()->json(["success" => true, "message" => "Запись удалена"], 200);
        }
        return response()->json(["success" => false, "message" => "Такой записи нет"], 200);
    }
}
