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
        Schema::create('benefs', function (Blueprint $table) {
            $table->id();
            
            $table->string('razonsocial');
            $table->string('cinit');
            $table->string('domicilio_fiscal');
            $table->string('tipo_nit')->nullable();
            $table->string('observacion')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('benefs');
    }
};
