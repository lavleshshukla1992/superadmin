<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Memebership extends Model
{
    use HasFactory;

    public $fillable = [
        'name',
        'current_subscription',
        'validity_from',
        'validity_to',
        'extend_your_subcription'
    ];
}
