<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'name',
        'state_id',
        'district_id',
        'municipality_id',
        'status',
        'all_state'
    ];
}
