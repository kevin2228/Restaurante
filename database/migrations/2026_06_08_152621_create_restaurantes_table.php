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
        Schema::create('restaurantes', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 150);
            $table->string('logo')->nullable();

            $table->string('color_primario', 20)->default('#0d6efd');
            $table->string('color_secundario', 20)->default('#ffffff');

            $table->string('telefono', 30)->nullable();
            $table->text('direccion')->nullable();

            $table->boolean('activo')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurantes');
    }
};
