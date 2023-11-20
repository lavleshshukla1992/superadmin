<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory,SoftDeletes;

    protected $perPage = 10;

    public $fillable = [
        'training_type',
        'name',
        'description',
        'cover_image',
        'training_video',
        'user_id',
        'live_link',
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

        // 'all_state',
        // 'video_type',
        // 'video_link',
        'training_start_at',
        'training_end_at',
    ];

    protected function coverImage(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }

    protected function trainingVideo(): Attribute
    {
        return new Attribute(
            get: fn ($value) =>  [
                'url' =>  !is_null($value) ? URL::to('/').'/uploads/'.$value : null,
                'name' => $value
            ]
        );
    }
}
