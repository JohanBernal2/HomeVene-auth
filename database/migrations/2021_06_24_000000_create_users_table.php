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
            //$table->bigInteger('rol_id')->unsigned();
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id')->references('id')->on('rol');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('documento_identificacion');
            $table->string('email',30)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('direccion');
            $table->rememberToken();
            $table->timestamps();

        }

    );
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
