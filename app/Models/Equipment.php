<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipment';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function etype()
    {
        return $this->belongsTo(EquipmentType::class);
    }
}
