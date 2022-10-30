<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Sanctum\HasApiTokens;

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
            $table->string('email', 100)->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('senha');
            $table->rememberToken();
            $table->date('data_nascimento')->nullable();
            $table->char('sexo', 1)->comment('M - Masculino, F - Feminino')->default('F');
            $table->string('telefone', 11);
            $table->string('foto_usuario', 100)->default('diarista.png')->nullable();
            $table->integer('nr_acessos')->default(0);
            $table->boolean('is_public')->default(true);
            $table->boolean('is_disabled')->default(false);
            $table->string('descricao', 1000)->nullable();
            $table->string('morada', 100)->nullable();



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
