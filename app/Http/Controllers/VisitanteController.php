<?php

namespace App\Http\Controllers;

use App\Models\Visitante;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VisitanteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Retornava todos os visitantes
        // $visitantes = Visitante::latest()->paginate(10);

        // Retorna apenas os visitantes que não estão desativados
        $visitantes = Visitante::where('is_disabled', false)->latest()->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $visitantes
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $visitante = Visitante::create($request->all());

        $request->validate([
            'nome' => 'required',
            'apelido' => 'required',
            'email' => 'required|email',
            'senha' => 'required|min:6',
            'telefone' => 'required|numeric',
            'morada' => 'nullable',
        ]);

        $visitante = Visitante::create([
            'nome' => $request->nome,
            'apelido' => $request->apelido,
            'email' => $request->email,
            'senha' => bcrypt($request->senha),
            'telefone' => $request->telefone,
            'morada' => $request->morada,
        ]);

        return response()->json([
            "status" => "success",
            "data" => $visitante
        ], 201);


        // return response($visitante, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitante = Visitante::where('is_disabled', false)->find($id);
        if (is_null($visitante)) {
            return response()->json(['message' => 'Visitante nao encontrado'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $visitante::find($id)
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitante $visitante)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitante  $visitante
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitante $visitante)
    {
        $visitante->update($request->all());
        return response($visitante, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitante  $visitante
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitante $visitante)
    {
        // $visitante->delete();

        $visitante->is_disabled = true;

        return response()->json([
            'status' => 'success',
            'data' => 'Visitante desativado com sucesso'
        ], 204);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'senha' => 'required|min:6',
        ]);

        $visitante = Visitante::where('email', $request->email)->first();

        if (is_null($visitante)) {
            return response()->json(['message' => 'Visitante nao encontrado'], 404);
        }

        if (Hash::check($request->senha, $visitante->senha)) {
            $authToken = $visitante->createToken('authToken')->plainTextToken;
            return response()->json([
                'status' => 'success',
                'token' => $authToken,
                'data' => $visitante
            ], 200);
        } else {
            return response()->json(['message' => 'Senha incorreta'], 404);
        }
    }

    public function userProfile(Request $request)
    {
        return $request->user();
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return response()->json([
            'status' => 'success',
            'data' => 'Visitante deslogado com sucesso'
        ], 200);
    }

    public function updatePassword(Request $request, Visitante $visitante)
    {
        $request->validate([
            'senha' => 'required|min:6',
        ]);

        $visitante->senha = bcrypt($request->senha);
        $visitante->save();

        return response()->json([
            'status' => 'success',
            'data' => 'Senha alterada com sucesso'
        ], 200);
    }



    public function updatePhoto(Request $request, Visitante $visitante)
    {
        $request->validate([
            'foto' => 'required',
        ]);

        $visitante->foto = $request->foto;
        $visitante->save();

        return response()->json([
            'status' => 'success',
            'data' => 'Foto alterada com sucesso'
        ], 200);
    }

    public function updateBirthdate(Request $request, Visitante $visitante)
    {
        $request->validate([
            'data_nascimento' => 'required',
        ]);

        $visitante->data_nascimento = $request->data_nascimento;
        $visitante->save();

        return response()->json([
            'status' => 'success',
            'data' => 'Data de nascimento alterada com sucesso'
        ], 200);
    }


    public function searchVisitante(Request $request)
    {
        $request->validate([
            'nome' => 'required',
        ]);

        $visitante = Visitante::where('nome', 'like', '%' . $request->nome . '%')->get();

        if (is_null($visitante)) {
            return response()->json(['message' => 'Visitante nao encontrado'], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $visitante
        ], 200);
    }

    public function listarVisitantes()
    {
        $total = Visitante::count();
        $visitantes_activas = Visitante::where('is_disabled', false)->get();
        $visitantes_desactivadas = Visitante::where('is_disabled', true)->get();


        return response()->json([
            'Total de visitantes: ' => $total,
            'Contas activas: ' => count($visitantes_activas),
            'Contas desactivadas: ' => count($visitantes_desactivadas),
        ], 200);
    }
}
