<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diarista_visitante', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('diarista_id');
            $table->unsignedInteger('visitante_id');
            $table->string('mensagem', 500)->nullable();
            $table->string('resposta', 500)->nullable();
            $table->char('status', 1)->default('U');
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
        Schema::dropIfExists('diarista_visitante');
    }
};
