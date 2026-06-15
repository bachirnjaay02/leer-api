<?php

namespace App\Http\Controllers;

use App\Models\MagalVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MagalVideoController extends Controller
{
    public function index()
    {
        return response()->json(MagalVideo::orderBy('ordre')->orderByDesc('created_at')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'file'  => 'nullable|file|mimetypes:video/mp4,video/webm|max:102400',
            'url'   => 'nullable|string|max:500',
            'ordre' => 'nullable|integer',
        ]);

        if ($request->hasFile('file')) {
            $file     = $request->file('file');
            $filename = uniqid('magal_') . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->putFileAs('magal', $file, $filename);
            $path = 'public/magal/' . $filename;
            $url  = '/storage/magal/' . $filename;
        } elseif ($request->url) {
            $path = $request->url;
            $url  = $request->url;
        } else {
            return response()->json(['error' => 'Fichier ou URL requis'], 422);
        }

        $video = MagalVideo::create([
            'titre'     => $request->titre,
            'file_path' => $path,
            'url'       => $url,
            'ordre'     => $request->ordre ?? 0,
        ]);

        return response()->json($video, 201);
    }

    public function destroy($id)
    {
        $video = MagalVideo::findOrFail($id);
        Storage::delete($video->file_path);
        $video->delete();
        return response()->json(['success' => true]);
    }
}
