<?php

namespace App\Models;

use App\Models\Country;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class State extends Model
{
    use HasFactory,SoftDeletes;

    public $fillable = [
        'country_id',
        'name',
        'status'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class,'country_id');
    }
}
