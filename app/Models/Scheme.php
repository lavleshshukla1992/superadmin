<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheme extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'name',
        'description',
        'state_id',
        'district_id',
        'municipality_id',
        'start_at',
        'end_at',
        'created_by',
        'updated_by',
        'media',
        'status'
    ];
}
