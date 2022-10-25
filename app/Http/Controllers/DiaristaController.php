<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diarista;

class DiaristaController extends Controller
{
    public function getDiarista() {
        $diaristas = Diarista::latest()->paginate(10);
        return response()->json($diaristas, 200);
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

    public function updateDiarista(Request $request, $id) {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }
        $diarista->update($request->all());
        return response($diarista, 200);
    }

    public function deleteDiarista(Request $request, $id) {
        $diarista = Diarista::find($id);
        if (is_null($diarista)) {
            return response()->json(['message' => 'Diarista nao existe'], 404);
        }
        $diarista->delete();
        return response()->json(null, 204);
    }
}