<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackConversation extends Model
{
    use HasFactory;

    public $fillable = [
        'uid',
        'membership_id',
        'media',
        'message',
    ];
}
