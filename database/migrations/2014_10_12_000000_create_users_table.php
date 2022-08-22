<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->string('phone_number')->unique();
            $table->timestamp('phone_number_verified_at')->nullable();
            // $table->foreignId('circle_id')->nullable()->constrained('circles')->nullOnDelete();
            // To BIO
            $table->text('about')->nullable();
            $table->string('image_url')->nullable();
            $table->string('full_name')->nullable();
            $table->date('birthday')->nullable();
            $table->enum('marital_status', ['أعزب', 'متزوج'])->nullable();
            $table->enum('type', [1,2,3])->default(1);
            // 1=> عضو فعال
            // 2=> عضو مجلس
            // 3=> أدمن
            $table->string('email')->nullable()->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
