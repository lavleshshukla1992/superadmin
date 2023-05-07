<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'title',
        'status',
        'type',
        'sent_at'
    ];
}
