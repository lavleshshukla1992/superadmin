<?php

namespace App\Models;

use App\Models\FeedbackConversation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Feedback extends Model
{
    use HasFactory,SoftDeletes;
    protected $perPage = 10;


    public $fillable = [
        'name',
        'member_id',
        'user_id',
        'user_type',
        'state_id',
        'district_id',
        'municipality_id',
        'subject',
        'media',
        'message',
        'type',
        'complaint_type',
        'mobile_number',
        'status'
    ];

    function conversation() 
    {
        return $this->hasMany(FeedbackConversation::class);
    }
}
