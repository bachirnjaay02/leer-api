<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PdfController extends Controller
{
    // POST /api/pdfs
    public function upload(Request $request)
    {
        $request->validate([
            'file'   => 'required|file|mimes:pdf|max:204800',
            'pdf_id' => 'required|string',
        ]);

        $pdfId = $request->input('pdf_id');
        $file  = $request->file('file');
        $name  = $file->getClientOriginalName();
        $path  = 'pdfs/' . $pdfId . '.pdf';

        Storage::disk('r2')->put($path, file_get_contents($file->getRealPath()), 'public');

        $url = rtrim(env('R2_PUBLIC_URL'), '/') . '/' . $path;

        return response()->json([
            'id'   => $pdfId,
            'name' => $name,
            'url'  => $url,
        ], 201);
    }

    // DELETE /api/pdfs/{id}
    public function destroy(string $id)
    {
        Storage::disk('r2')->delete('pdfs/' . $id . '.pdf');
        return response()->json(['success' => true]);
    }
}
