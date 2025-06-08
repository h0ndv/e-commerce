<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Categoria productos
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Productos
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->integer('stock')->default(0);
            $table->decimal('precio', 10, 2);
            $table->text('descripcion')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
        });

        // Servicios
        Schema::create('servicios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->decimal('precio', 10, 2);
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Clientes
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('correo')->nullable();
            $table->timestamps();
        });

        // Ordenes de trabajo
        Schema::create('orden_trabajos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
            $table->string('titulo');
            $table->text('descripcion')->nullable();
            $table->string('estado')->default('pendiente');
            $table->timestamps();
        });

        // Tabla servicios de ordenes de trabajo
        Schema::create('detalle_servicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->constrained('orden_trabajos')->onDelete('cascade');
            $table->foreignId('servicio_id')->constrained('servicios')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });

        // Tabla detalle productos en la orden de trabajo
        Schema::create('detalle_productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_trabajo_id')->constrained('orden_trabajos')->onDelete('cascade');
            $table->foreignId('producto_id')->constrained('productos')->onDelete('cascade');
            $table->integer('cantidad')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('detalle_productos');
        Schema::dropIfExists('detalle_servicios');
        Schema::dropIfExists('ordenes_trabajo');
        Schema::dropIfExists('clientes');
        Schema::dropIfExists('servicios');
        Schema::dropIfExists('productos');
        Schema::dropIfExists('categorias');
    }
};
