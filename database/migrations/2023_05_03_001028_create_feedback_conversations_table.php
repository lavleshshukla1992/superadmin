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
        Schema::create('feedback_conversations', function (Blueprint $table) {
            $table->id();
            $table->text('media')->nullable();
            $table->text('message')->nullable();
            $table->bigInteger('uid')->nullable();
            $table->bigInteger('membership_id')->nullable();
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
        Schema::dropIfExists('feedback_conversations');
    }
};
