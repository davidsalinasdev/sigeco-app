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
        Schema::create('clntes', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('password'); 
            $table->string('ci');
            $table->string('nombres');
            $table->string('paterno');
            $table->string('materno');
            $table->string('cargo');
            $table->string('dependencia');
            $table->string('estado');
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
        Schema::dropIfExists('clntes');
    }
};
