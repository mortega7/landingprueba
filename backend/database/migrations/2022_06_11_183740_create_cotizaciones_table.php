<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ciudad_id')->constrained()->onDelete('cascade')->on('ciudades');
            $table->string('modelo');
            $table->string('nombre_cliente');
            $table->string('email');
            $table->unsignedBigInteger('celular');
            $table->date('fecha_solicitud')->default(Carbon::now());
            $table->unique(['modelo', 'email', 'celular', 'fecha_solicitud']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizaciones');
    }
};
