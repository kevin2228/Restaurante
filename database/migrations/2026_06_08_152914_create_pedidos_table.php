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
        Schema::create('pedidos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('mesa_id')
                ->constrained('mesas')
                ->cascadeOnDelete();

            $table->string('numero_pedido', 30)
                ->unique();

            $table->enum('estado', [
                'pendiente',
                'aceptado',
                'preparando',
                'listo',
                'entregado',
                'cancelado'
            ])->default('pendiente');

            $table->decimal('subtotal', 10, 2)->default(0);

            $table->decimal('impuestos', 10, 2)->default(0);

            $table->decimal('total', 10, 2)->default(0);

            $table->timestamp('editable_hasta');

            $table->text('observaciones')->nullable();

            $table->timestamps();

            $table->index('estado');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
