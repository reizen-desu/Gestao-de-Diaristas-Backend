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
        Schema::create('diaristas', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 100);
            $table->string('apelido', 40);
            $table->string('email', 100);
            $table->date('data_nascimento');
            $table->char('sexo', 1);
            $table->string('telefone', 11);
            $table->string('foto_usuario', 100);
            // $table->integer('nr_acessos', 2);
            $table->boolean('is_public');
            $table->string('descricao', 1000);
            $table->string('Morada', 100);



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
        Schema::dropIfExists('diaristas');
    }
};