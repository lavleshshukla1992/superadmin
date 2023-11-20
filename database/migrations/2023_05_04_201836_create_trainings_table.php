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
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('cover_image')->nullable();

            $table->bigInteger('user_id')->nullable();
            $table->dateTime('training_start_at')->nullable();
            $table->dateTime('training_end_at')->nullable();

            $table->string('video_type')->nullable();
            $table->text('video_link')->nullable();
            $table->text('live_link')->nullable();

            $table->tinyInteger('all_state')->nullable();
            $table->bigInteger('state_id')->nullable();
            $table->bigInteger('district_id')->nullable();
            $table->bigInteger('municipality_id')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('trainings');
    }
};
