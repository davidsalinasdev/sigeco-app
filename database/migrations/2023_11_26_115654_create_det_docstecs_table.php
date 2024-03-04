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
        Schema::create('det_docstecs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_docstec');
            $table->string('item')->nullable();
            $table->string('descripcion')->nullable();
            $table->string('unidad')->nullable();
            $table->integer('cantidad')->nullable();
            $table->float('precio',8,2)->nullable();
            $table->float('subtotal',8,2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('det_docstecs');
    }
};
