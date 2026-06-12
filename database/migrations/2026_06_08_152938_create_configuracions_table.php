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
        Schema::create('configuraciones', function (Blueprint $table) {

            $table->id();

            $table->foreignId('restaurante_id')
                ->constrained('restaurantes')
                ->cascadeOnDelete();

            $table->integer('minutos_edicion')
                ->default(5);

            $table->boolean('permitir_edicion')
                ->default(true);

            $table->boolean('mostrar_stock')
                ->default(false);

            $table->boolean('acepta_pedidos')
                ->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('configuracions');
    }
};
