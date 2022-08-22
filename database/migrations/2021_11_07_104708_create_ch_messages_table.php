<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ch_messages', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->foreignId('from_id')->constrained('users');
            $table->foreignId('to_id')->constrained('users');
            $table->string('body',5000)->nullable();
            $table->string('attachment')->nullable();
            $table->string('chat_number')->nullable();
            $table->enum('seen' , ['0', '1']);
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
        Schema::dropIfExists('ch_messages');
    }
}
