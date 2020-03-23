<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTodoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
      /*  Schema::create('user_todos', function (Blueprint $table) {
        
            $table->increments('id');
            $table->string('user_nickname')->index();
            $table->bigInteger('todo_id')->index();
            $table->timestamps();

            $table->foreign('todo_id')
                ->references('id')->on('todos')
                ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('user_nickname')
                ->references('username')->on('users')
                ->onUpdate('cascade')
            ->onDelete('cascade');
        });
        */
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
