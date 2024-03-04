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
        Schema::create('docstecs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_proc');
            $table->string('nom_doc');
            $table->date('fecha_crea');
            $table->string('plazo_ent');
            $table->string('garantia');
            $table->string('lugmed_ent');
            $table->string('otro1')->nullable();
            $table->string('otro2')->nullable();
            $table->string('observacion')->nullable();
            $table->float('total',8,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('docstecs');
    }
};
