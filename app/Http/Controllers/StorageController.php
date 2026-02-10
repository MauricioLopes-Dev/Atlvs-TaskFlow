<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageController extends Controller
{
    /**
     * Serve files from the public storage disk
     */
    public function serve($path)
    {
        // Validar o caminho para evitar path traversal
        $path = str_replace('..', '', $path);
        
        // Verificar se o arquivo existe
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'Arquivo não encontrado');
        }

        // Obter o tipo MIME
        $mimeType = Storage::disk('public')->mimeType($path);

        // Retornar o arquivo
        return response()->file(
            Storage::disk('public')->path($path),
            ['Content-Type' => $mimeType]
        );
    }
}
