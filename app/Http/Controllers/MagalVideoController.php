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
            'file'  => 'required|file|mimetypes:video/mp4,video/quicktime,video/webm|max:102400', // 100 MB max
            'ordre' => 'nullable|integer',
        ]);

        $file     = $request->file('file');
        $filename = uniqid('magal_') . '.' . $file->getClientOriginalExtension();
        $path     = $file->storeAs('public/magal', $filename);
        $url      = Storage::url($path); // /storage/magal/filename

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
