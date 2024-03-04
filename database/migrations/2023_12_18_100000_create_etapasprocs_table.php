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
        Schema::create('etapasprocs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_mod');
            $table->integer('nro_etapa');
            $table->integer('sig_etapa');
            $table->string('nom_etapa');
            $table->string('observacion')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('etapasprocs');
    }
};
