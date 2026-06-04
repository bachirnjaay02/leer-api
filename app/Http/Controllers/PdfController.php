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
            'file'   => 'required|file|mimes:pdf|max:204800', // 200MB max
            'pdf_id' => 'required|string',
        ]);

        $pdfId = $request->input('pdf_id');
        $file  = $request->file('file');
        $name  = $file->getClientOriginalName();

        // Stocke sous storage/app/public/pdfs/{pdfId}.pdf
        $path = $file->storeAs('pdfs', $pdfId . '.pdf', 'public');

        $url = asset('storage/' . $path);

        return response()->json([
            'id'   => $pdfId,
            'name' => $name,
            'url'  => $url,
        ], 201);
    }

    // DELETE /api/pdfs/{id}
    public function destroy(string $id)
    {
        Storage::disk('public')->delete('pdfs/' . $id . '.pdf');
        return response()->json(['success' => true]);
    }
}
