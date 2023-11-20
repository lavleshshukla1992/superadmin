<?php

namespace App\Models;

use App\Models\State;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Country extends Model
{
    use HasFactory,SoftDeletes;

    protected $perPage = 10;

    public $fillable = [
        'sortname',
        'name',
        'phonecode',
        'status',
    ];

    public function states()
    {
        return $this->hasMany(State::class);
    }
}
