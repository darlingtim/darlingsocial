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
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->date('date_of_birth')->nullable();
            $table->string('profile_photo_url')->nullable();
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
