<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Scheme extends Model
{
    use HasFactory,SoftDeletes;

    protected $perPage = 10;

    public $fillable = [
        'name',
        'description',
        'state_id',
        'district_id',
        'municipality_id',
        'start_at',
        'end_at',
        'apply_link',
        'created_by',
        'updated_by',
        'scheme_image',
        'status',
        'gender',
        'social_category',
        'educational_qualification',
        'type_of_vending',
        'type_of_marketplace',
        "select_demography"
    ];
}
