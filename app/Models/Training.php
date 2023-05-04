<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'state_id',
        'district_id',
        'municipality_id',
        'status',
        'all_state'
    ];
}
