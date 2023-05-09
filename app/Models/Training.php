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
        'cover_image',
        'user_id',
        'training_start_at',
        'training_end_at',
        'video_type',
        'video_link',
        'live_link',
        'all_state',
        'state_id',
        'district_id',
        'municipality_id',
        'status',
    ];
}
