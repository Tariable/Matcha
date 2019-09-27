<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chat_id')->unsigned();
            $table->bigInteger('profile_id')->unsigned();
            $table->foreign('chat_id')->references('id')->on('chats')
                ->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')
                ->onDelete('cascade');
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
        Schema::dropIfExists('chat_profile');
    }
}
