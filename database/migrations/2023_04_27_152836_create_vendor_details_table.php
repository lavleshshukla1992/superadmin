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
        Schema::create('vendor_details', function (Blueprint $table) {
            $table->id();
            $table->uuid('uid')->nullable();
            $table->string('vendor_first_name')->nullable();
            $table->string('vendor_last_name')->nullable();
            $table->string('parent_first_name')->nullable();
            $table->string('parent_last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender',20)->nullable();
            $table->tinyInteger('marital_status')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('social_category')->nullable();
            $table->text('current_address')->nullable();
            $table->string('current_state')->nullable();
            $table->string('current_district')->nullable();
            $table->string('current_pincode')->nullable();
            $table->string('mobile_no')->nullable();

            $table->string('municipality_panchayat_birth')->nullable();
            $table->string('municipality_panchayat_current')->nullable();

            $table->string('police_station')->nullable();

            $table->tinyInteger('is_current_add_and_birth_add_is_same')->nullable();
            
            $table->text('birth_address')->nullable();
            $table->string('birth_state')->nullable();
            $table->string('birth_district')->nullable();
            $table->string('birth_pincode')->nullable();

            $table->integer('type_of_marketplace')->nullable();
            $table->integer('type_of_vending')->nullable();

            $table->string('total_years_of_business')->nullable();
            $table->text('current_location_of_business')->nullable();

            $table->string('referral_code',20)->nullable();
            $table->text('profile_image_name',500)->nullable();
            $table->text('identity_image_name',500)->nullable();
            $table->text('membership_image',500)->nullable();
            $table->text('cov_image',500)->nullable();
            $table->text('lor_image',500)->nullable();
            $table->text('shop_image',500)->nullable();
            $table->text('password',500)->nullable();
            $table->bigInteger('status',5)->nullable();
            $table->bigInteger('user_role')->nullable();
            $table->tinyInteger('mobile_no_verification_status')->nullable();
            
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
        Schema::dropIfExists('vendor_details');
    }
};
