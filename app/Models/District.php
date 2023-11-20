<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory,SoftDeletes;
        protected $perPage = 10;


    public $fillable = [
        'name',
        'status',
        'state_id'
    ];
}
