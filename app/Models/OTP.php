<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTP extends Model
{
    use HasFactory;
    protected $table = 'otp_details';

    public $fillable = [
        'mobile_no',
        'otp',
        'verify_status',
        'otp_type',
        'verified_at',
        'expired_at',
    ];
}
