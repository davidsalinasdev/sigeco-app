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
        Schema::table('procesosconts', function (Blueprint $table) {
            $table->softDeletes(); // Agrega el soporte de borrado lógico
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('procesosconts', function (Blueprint $table) {
            $table->dropSoftDeletes(); // Elimina el soporte de borrado lógico
        });
    }
};