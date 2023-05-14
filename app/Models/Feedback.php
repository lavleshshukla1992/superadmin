<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'name',
        'membership_id',
        'subject',
        'media',
        'message',
        'type',
        'mobile_number',
        'status'
    ];
}
