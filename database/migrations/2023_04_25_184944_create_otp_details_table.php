<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otp_details', function (Blueprint $table) {
            $table->id();
            $table->string('mobile_no');
            $table->string('otp',7);
            $table->tinyInteger('verify_status')->default(0);
            $table->string('otp_type',25);
            $table->dateTime('verified_at')->nullable();
            $table->dateTime('expired_at');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otp_details');
    }
};
