<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pincode extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'pincode',
        'district_id',
        'state_id',
        'status',
    ];
}
