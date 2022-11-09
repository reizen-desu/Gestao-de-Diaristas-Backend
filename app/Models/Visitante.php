<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Visitante extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function diaristas()
    {
        // return $this->belongsToMany(Diarista::class, 'diarista_visitante', 'visitante_id', 'diarista_id');
        return $this->belongsToMany(Diarista::class);
    }


    use HasApiTokens, HasFactory, Notifiable;

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
