<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SchemeApply extends Model
{
    use HasFactory,SoftDeletes;

    protected $perPage = 10;

    public $fillable = [
        'user_id',
        'scheme_id',
        'user_type',
        'apply_date'
    ];
}
