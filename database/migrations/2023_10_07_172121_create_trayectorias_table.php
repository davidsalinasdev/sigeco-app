<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('trayectorias', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_proceso');
            $table->unsignedBigInteger('id_eanterior');
            $table->unsignedBigInteger('id_eactual');
            $table->unsignedBigInteger('id_esgte');
            $table->unsignedBigInteger('id_uorigen');
            $table->unsignedBigInteger('id_uactual');
            $table->unsignedBigInteger('id_udestino')->nullable();
            $table->date('fecha_ing');
            $table->date('fecha_env')->nullable();
            $table->string('estado');
            $table->string('observacion')->nullable();
            $table->integer('atendido');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trayectorias');
    }
};
