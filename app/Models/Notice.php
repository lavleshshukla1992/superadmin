<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name',
        'description',
        'media',
        'state_id',
        'district_id',
        'municipality_id',
        'created_by',
        'updated_by',
        'status'
    ];
}
