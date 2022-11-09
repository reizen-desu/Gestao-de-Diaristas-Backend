<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Diarista;
use App\Models\Visitante;
use Illuminate\Support\Facades\DB;

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

    // A diariasta aceita a solicitação
    public function aceitarSolicitacao(Request $request, $id_solicitacao)
    {

        // Grab reply from request
        $resposta = $request->resposta;

        // Update na tabela diarista_visitante apenas para o id da solicitação
        $solicitacao = DB::table('diarista_visitante')
            ->where('id', $id_solicitacao)
            ->update(['status' => 'A'], ['resposta' => $resposta]);


        return response()->json([
            'status' => 'success',
            'mensagem' => 'A solicitação com o id ' . $id_solicitacao . ' foi aceite',
            'resposta' => $resposta,
            'solicitacao' => $solicitacao,
        ], 200);
    }

    public function rejeitarSolicitacao(Request $request, $id_solicitacao)
    {

        // Grab reply from request
        $resposta = $request->resposta;

        // Update na tabela diarista_visitante apenas para o id da solicitação
        DB::table('diarista_visitante')
            ->where('id', $id_solicitacao)
            ->update(['status' => 'R'], ['resposta' => $resposta]);


        return response()->json([
            'status' => 'success',
            'data' => 'A solicitação com o id ' . $id_solicitacao . ' foi rejeitada',
            'resposta' => $resposta,
        ], 200);
    }

    public function cancelarSolicitacao(Request $request)
    {
        $visitante = Visitante::find($request->visitante_id);
        $diarista = Diarista::find($request->diarista_id);

        $visitante->diaristas()->detach($diarista);

        return response()->json([
            'status' => 'success',
            'data' => 'Solicitação cancelada com sucesso'
        ], 200);
    }

    // Esta função irá retornar as solicitações que o visitante fez 
    public function listarSolicitacoes()
    {

        $diarista = Diarista::find(Auth::id());

        $solicitacao = DB::table('diarista_visitante')
            ->where('diarista_id', Auth::id())
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $solicitacao,
            // 'diarista' => $diarista
        ], 200);
    }


}
