<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diarista;

class DiaristaController extends Controller
{
    public function getDiarista() {
        return Diarista::all();
    }

    public function getDiaristaById($id) {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao encontrado'], 404);
        }
        return response()->json($diarista::find($id), 200);
    }

    public function addDiarista(Request $request) {
        $diarista = Diarista::create($request->all());
        return response($diarista, 201);
    }
}