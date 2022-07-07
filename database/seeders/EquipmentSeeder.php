<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Equipment;

class EquipmentSeeder extends Seeder
{
    /*
    [1, 'XXAAAAAXAA'],
    [2, 'NXXAAXZXaa'],
    [3, 'NXXAAXZXXX'],
    */
    static $equipments = [
        [1, 'D4ACVBR4AA', 'Примечание 1'],
        [1, '54DRCFVREE', 'Примечание 2'],
        [1, '3EDFRTG8DD', 'Примечание 3'],
        [1, '99QQQQQ9QQ', 'Примечание 4'],
        [1, 'DDQWERT7UU', 'Примечание 5'],
        [2, '5D4QW8-9kz', 'Примечание 6'],
        [2, '99GTVR@Yqm', 'Примечание 7'],
        [3, '3EREE5-DE4', 'Примечание 8'],
        [3, '4R4ADG_34F', 'Примечание 9'],
        [3, '3ERFF5-F8C', 'Примечание 10'],
        [3, '8G3ASG-JH7', 'Примечание 11'],
        [3, '69JNBD-653', 'Примечание 12'],
        [3, '1HWKK8-G6T', 'Примечание 13'],
        [3, '737AAJ_66F', 'Примечание 14'],
        [3, '54HTP9-111', 'Примечание 15'],
    ];

    public function run()
    {
        foreach (self::$equipments as $e) {
            Equipment::create([
                'equipment_type_id' => $e[0],
                'serial_number' => $e[1],
                'note' => $e[2],
            ]);
        }
    }
}
