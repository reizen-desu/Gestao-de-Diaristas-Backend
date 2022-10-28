<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diarista;
use Illuminate\Support\Facades\Hash;

class DiaristaController extends Controller
{
    public function getDiarista()
    {
        $diaristas = Diarista::where('is_disabled', false)->latest()->paginate(10);
        return response()->json([
            'status' => 'success',
            'data' => $diaristas
        ], 200);
    }


    public function getDiaristaById($id)
    {
        $diarista = Diarista::where('is_disabled', false)->find($id);

        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao encontrado'], 404);
        }
        return response()->json($diarista, 200);
    }

    public function addDiarista(Request $request)
    {

        $request->validate([
            'nome' => 'required',
            'apelido' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:6',
            'data_nascimento' => 'required|date',
            'sexo' => 'required|in:M,F',
            'telefone' => 'required|numeric',
            'foto_usuario' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
            'descricao' => 'nullable',
            'morada' => 'nullable',
        ]);

        $diarista = Diarista::create([
            'nome' => $request->nome,
            'apelido' => $request->apelido,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'data_nascimento' => $request->data_nascimento,
            'sexo' => $request->sexo,
            'telefone' => $request->telefone,
            'foto_usuario' => $request->foto_usuario,
            'descricao' => $request->descricao,
            'morada' => $request->morada,
        ]);


        return response()->json([
            "status" => "success",
            "data" => $diarista
        ], 201);
    }

    public function updateDiarista(Request $request, $id)
    {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }
        $diarista->update($request->all());
        return response($diarista, 200);
    }

    public function deleteDiarista(Request $request, $id)
    {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }

        $diarista->is_disabled = true;

        return response()->json([
            "status" => "success",
            "message" => "Diarista com id $id desactivado com sucesso"
        ], 204);
    }

    public function searchDiarista($nome)
    {
        $diarista = Diarista::where('nome', 'like', '%' . $nome . '%')->where('is_disabled', false)->get();
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao encontrado'], 404);
        }
        return response()->json($diarista, 200);
    }

    public function loginDiarista(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:6',
        ]);

        $diarista = Diarista::where('email', $request->email)->first();

        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao encontrado'], 404);
        }

        if (Hash::check($request->senha, $diarista->senha)) {
            $token = $diarista->createToken('auth_token')->plainTextToken;
            return response()->json([
                "status" => "success",
                "token" => $token,
                "data" => $diarista,
            ], 200);
        } else {
            return response()->json(['message' => 'Senha incorreta'], 404);
        }
    }

    public function updateDiaristaPassword(Request $request, $id)
    {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }

        $request->validate([
            'senha' => 'required|min:6',
        ]);

        $diarista->senha = bcrypt($request->senha);
        $diarista->save();

        return response()->json([
            "status" => "success",
            "message" => "Senha do diarista com id $id actualizada com sucesso"
        ], 204);
    }

    public function updateDiaristaPhoto(Request $request, $id)
    {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }

        $request->validate([
            'foto_usuario' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|nullable',
        ]);

        $diarista->foto_usuario = $request->foto_usuario;
        $diarista->save();

        return response()->json([
            "status" => "success",
            "message" => "Foto do diarista com id $id actualizada com sucesso"
        ], 204);
    }
}
