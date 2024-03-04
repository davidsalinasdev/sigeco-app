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
        Schema::create('procesosconts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_unid');
            $table->unsignedBigInteger('id_mod');
            $table->unsignedBigInteger('id_pac')->nullable();
            $table->string('codigo')->nullable();
            $table->string('tipo_cont')->nullable();
            //$table->string('cuce')->nullable();//eliminar
            $table->string('objeto');
            $table->float('precio_ref',8,2);
            //$table->string('forma_pago')->nullable();//eliminar
            //$table->string('org_finan')->nullable();//eliminar
            $table->string('gestion');
            //$table->string('mes_ini')->nullable();//eliminar
            //$table->string('mes_pub')->nullable();//eliminar
            $table->date('fecha_reg');
            $table->integer('estado');
            $table->string('observacion')->nullable();
            $table->integer('autorizado')->nullable();
            $table->string('benef')->nullable();
            $table->string('docref')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procesosconts');
    }
};
