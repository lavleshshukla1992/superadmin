<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdsHistory extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'ads';

    public $fillable = [
        'ad_sr_no',
        'ad_type',
        'ad_status',
        'google_script',
        'ad_name',
        'ad_media',
        'google_script',
        'ad_link',
        'ad_from_dt',
        'ad_to_dt',
    ];
}
