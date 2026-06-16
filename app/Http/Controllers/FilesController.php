<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FilesController extends Controller
{
    public function index()
    {
        $files = File::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('files.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,csv,xlsx|max:10240',
        ]);

        $uploaded = $request->file('file');
        $path = $uploaded->store('uploads/'.Auth::id(), 'public');

        File::create([
            'user_id' => Auth::id(),
            'filename' => basename($path),
            'original_name' => $uploaded->getClientOriginalName(),
            'file_path' => $path,
            'mime_type' => $uploaded->getMimeType(),
            'size' => $uploaded->getSize(),
        ]);

        return redirect()->route('files')->with('success', 'Archivo subido correctamente.');
    }

    public function download(File $file): StreamedResponse
    {
        abort_unless($file->user_id === Auth::id(), 403);

        return Storage::disk('public')->download($file->file_path, $file->original_name);
    }

    public function destroy(File $file)
    {
        abort_unless($file->user_id === Auth::id(), 403);

        Storage::disk('public')->delete($file->file_path);
        $file->delete();

        return redirect()->route('files')->with('success', 'Archivo eliminado correctamente.');
    }
}
