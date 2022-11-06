<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diarista;
use App\Models\Visitante;

class SolicitationController extends Controller
{

    public function enviarSolicitacao(Request $request, $id_diarista)
    {

        $visitante_id = Auth::id();
        $diarista = Diarista::find($id_diarista);
        $visitante = Visitante::find($visitante_id);

        $validacao = $request->validate([
            'mensagem' => 'max: 500',
        ]);

        $mensagem = $request->mensagem;
        $diarista->visitantes()->attach($visitante, ['mensagem' => $validacao['mensagem']]);


        return response()->json([
            'status' => 'success',
            'mensagem' => $mensagem,
            'visitante' => $visitante,
            'diarista' => $diarista,
        ], 200);
    }

}
