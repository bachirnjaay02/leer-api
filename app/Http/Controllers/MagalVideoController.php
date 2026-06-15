<?php

namespace App\Http\Controllers;

use App\Models\MagalVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

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
            'file'  => 'required|file|mimetypes:video/mp4,video/quicktime,video/webm|max:102400',
            'ordre' => 'nullable|integer',
        ]);

        $file = $request->file('file');

        // Upload vers Cloudinary si configuré, sinon stockage local
        if (config('cloudinary.cloud_url') || env('CLOUDINARY_URL')) {
            $result   = Cloudinary::uploadFile($file->getRealPath(), [
                'folder'        => 'magal',
                'resource_type' => 'video',
            ]);
            $url      = $result->getSecurePath();
            $filePath = $result->getPublicId();
        } else {
            $filename = uniqid('magal_') . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('public/magal', $filename);
            $url      = Storage::url($filePath);
        }

        $video = MagalVideo::create([
            'titre'     => $request->titre,
            'file_path' => $filePath,
            'url'       => $url,
            'ordre'     => $request->ordre ?? 0,
        ]);

        return response()->json($video, 201);
    }

    public function destroy($id)
    {
        $video = MagalVideo::findOrFail($id);

        // Supprimer de Cloudinary si c'est une URL Cloudinary
        if (str_contains($video->url, 'cloudinary.com')) {
            try {
                Cloudinary::destroy($video->file_path, ['resource_type' => 'video']);
            } catch (\Exception $e) {
                // ignore
            }
        } else {
            Storage::delete($video->file_path);
        }

        $video->delete();
        return response()->json(['success' => true]);
    }
}
