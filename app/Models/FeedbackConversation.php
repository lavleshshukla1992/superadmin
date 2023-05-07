<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedbackConversation extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'uid',
        'membership_id',
        'media',
        'message',
    ];
}
