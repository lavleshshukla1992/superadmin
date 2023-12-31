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
        Schema::create('memeberships', function (Blueprint $table) {
            $table->id();
            $table->date('validity_from')->nullable();
            $table->date('validity_to')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('user_name');
            $table->string('membership_id')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('memeberships');
    }
};
