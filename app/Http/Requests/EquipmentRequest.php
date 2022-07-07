<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'equipment_type_id' => 'Вид оборудования',
            'serial_number' => 'Серийный номер оборудования',
            'note' => 'Комментарий',
        ];
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            /*'equipment_type_id' => 'required|exists:App\Models\EquipmentType,id',
            'serial_number' => 'required',
            'note' => 'min:3',*/
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'equipment_type_id.required' => 'Поле оборудование обязательное',
            'equipment_type_id.exists' => 'Оборудование должно быть существующим',
            'serial_number.required' => 'Серийный номер обязательный',
            'note.min' => 'Комментарий должен быть более 3 символов',
        ];
    }
}
