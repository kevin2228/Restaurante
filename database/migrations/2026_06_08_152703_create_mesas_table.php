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
        Schema::create('mesas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('restaurante_id')
                ->constrained('restaurantes')
                ->cascadeOnDelete();

            $table->string('codigo_qr', 50)->unique();

            $table->integer('numero');

            $table->integer('capacidad')->default(4);

            $table->enum('estado', [
                'libre',
                'ocupada',
                'reservada'
            ])->default('libre');

            $table->timestamps();

            $table->index('estado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mesas');
    }
};
