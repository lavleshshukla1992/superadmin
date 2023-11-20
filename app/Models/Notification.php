<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory,SoftDeletes;

    protected $perPage = 10;

    public $fillable = [
        'title',
        'status',
        'user_id',
        'type',
        'type_id',
        'sent_at',
        'is_read'
    ];
}
