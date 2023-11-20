<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notice extends Model
{
    use HasFactory, SoftDeletes;
    protected $perPage = 10;

    public $fillable = [
        'name',
        'description',
        'notice_image',
        'created_by',
        'updated_by',
        'end_date',
        'select_demography',
        'gender',
        'social_category',
        'educational_qualification',
        'type_of_vending',
        'type_of_marketplace',
        'state_id',
        'district_id',
        'municipality_id',
        'status',
    ];

    protected function noticeImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
}
