<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EquipmentType;

class EquipmentTypeSeeder extends Seeder
{
    static $types = [
        [1, 'TP-Link TL-WR74', 'XXAAAAAXAA'],
        [2, 'D-Link DIR-300', 'NXXAAXZXaa'],
        [3, 'D-Link DIR-300 S', 'NXXAAXZXXX'],
    ];

    public function run()
    {
        foreach (self::$types as $t) {
            EquipmentType::create([
                'id' => $t[0],
                'caption' => $t[1],
                'mask' => $t[2],
            ]);
        }
    }
}
