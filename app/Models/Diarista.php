<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Diarista extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function visitantes()
    {
        // return $this->belongsToMany(Visitante::class, 'diarista_visitante', 'diarista_id', 'visitante_id');
        return $this->belongsToMany(Visitante::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nome',
        'apelido',
        'email',
        'senha',
        'data_nascimento',
        'sexo',
        'telefone',
        'foto_usuario',
        'nr_acessos',
        'is_public',
        'is_disabled',
        'descricao',
        'morada',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
