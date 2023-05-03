<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pincode extends Model
{
    use HasFactory;

    public $fillable = [
        'pincode',
        'district_id',
        'state_id',
        'status',
    ];
}
