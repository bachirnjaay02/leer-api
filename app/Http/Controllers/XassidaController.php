<?php

namespace App\Http\Controllers;

use App\Models\Xassida;
use Illuminate\Http\Request;

class XassidaController extends Controller
{
    // GET /api/xassidas
    public function index()
    {
        $xassidas = Xassida::orderBy('created_at', 'desc')->get();
        return response()->json($xassidas);
    }

    // POST /api/xassidas
    public function store(Request $request)
    {
        $data = $request->validate([
            'id'          => 'required|string',
            'titre'       => 'required|string',
            'titre_arabe' => 'required|string',
            'auteur'      => 'nullable|string',
            'description' => 'nullable|string',
            'categorie'   => 'nullable|string',
            'poeme'       => 'nullable|string',
            'versets'     => 'nullable|array',
            'pdfs'        => 'nullable|array',
        ]);

        $xassida = Xassida::create([
            'id'          => $data['id'],
            'titre'       => $data['titre'],
            'titre_arabe' => $data['titre_arabe'],
            'auteur'      => $data['auteur'] ?? '',
            'description' => $data['description'] ?? '',
            'categorie'   => $data['categorie'] ?? 'Druuss',
            'poeme'       => $data['poeme'] ?? '',
            'versets'     => $data['versets'] ?? [],
            'pdfs'        => $data['pdfs'] ?? [],
        ]);

        return response()->json($xassida, 201);
    }

    // PUT /api/xassidas/{id}
    public function update(Request $request, string $id)
    {
        $xassida = Xassida::findOrFail($id);

        $data = $request->only([
            'titre', 'titre_arabe', 'auteur', 'description',
            'categorie', 'poeme', 'versets', 'pdfs',
        ]);

        $xassida->update($data);

        return response()->json($xassida);
    }

    // DELETE /api/xassidas/{id}
    public function destroy(string $id)
    {
        $xassida = Xassida::findOrFail($id);
        $xassida->delete();
        return response()->json(['success' => true]);
    }
}
