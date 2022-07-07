<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\EquipmentType;

class EquipmentResource extends JsonResource
{
    public static $wrap = 'equipments';
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        //return parent::toArray($request);
        return [
            'equipment'=>EquipmentTypeResource::make(EquipmentType::where('id', $this->equipment_type_id)->limit(1)->first()),
            'serial'=>$this->serial_number,
            'note'=>$this->note,
        ];
    }
}
