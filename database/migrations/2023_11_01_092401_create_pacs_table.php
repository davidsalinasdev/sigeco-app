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
        Schema::create('pacs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_unid');
            $table->unsignedBigInteger('id_mod');
            $table->string('tipo_cont')->nullable();
            $table->string('cuce')->nullable();
            $table->string('objeto');
            $table->float('precio_ref',8,2);
            $table->string('forma_pago')->nullable();
            $table->string('org_finan');
            $table->string('gestion');
            $table->string('mes_ini');
            $table->string('mes_pub');
            $table->date('fecha_reg');
            $table->integer('estado');
            $table->string('observacion')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacs');
    }
};
