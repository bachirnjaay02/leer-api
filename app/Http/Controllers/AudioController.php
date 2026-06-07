<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudioController extends Controller
{
    // POST /api/audios
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:mp3,mpeg,ogg,wav,m4a|max:204800', // max 200MB
        ]);

        $file = $request->file('file');
        $id   = Str::uuid();
        $ext  = $file->getClientOriginalExtension();
        $name = $file->getClientOriginalName();
        $path = 'audios/' . $id . '.' . $ext;

        Storage::disk('r2')->put($path, file_get_contents($file->getRealPath()), 'public');

        $url = rtrim(env('R2_PUBLIC_URL'), '/') . '/' . $path;

        return response()->json([
            'id'   => $id,
            'name' => $name,
            'url'  => $url,
        ], 201);
    }

    // DELETE /api/audios/{id}
    public function destroy(string $id)
    {
        // Cherche et supprime l'audio (mp3, ogg, wav, m4a)
        foreach (['mp3', 'mpeg', 'ogg', 'wav', 'm4a'] as $ext) {
            $path = 'audios/' . $id . '.' . $ext;
            if (Storage::disk('r2')->exists($path)) {
                Storage::disk('r2')->delete($path);
                break;
            }
        }
        return response()->json(['success' => true]);
    }
}
