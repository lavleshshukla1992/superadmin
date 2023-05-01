<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Memebership extends Model
{
    use HasFactory;

    public $fillable = [
        'user_id',
        'membership_id',
        'validity_from',
        'validity_to',
        'status',
    ];
}
