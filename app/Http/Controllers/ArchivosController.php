<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class ArchivosController extends Controller
{
    // Método para mostrar los archivos
    public function index()
    {
        $carpeta = 'mi_carpeta';

        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
        }

        $archivos = Storage::files($carpeta);
        $carpetas = Storage::directories($carpeta);
        
        // Obtener rutas locales físicas configuradas
        $rutasLocales = \App\Models\RutaLocal::orderBy('created_at', 'desc')->get();

        return view('archivos.index', compact('archivos', 'carpetas', 'carpeta', 'rutasLocales'));
    }

    // Método para subir archivos
    public function upload(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file',
        ]);

        try {
            $carpeta = 'mi_carpeta';
            $archivo = $request->file('archivo');
            $archivo->storeAs($carpeta, $archivo->getClientOriginalName());

            return redirect()->route('ruta.archivos')->with('success', 'Archivo subido correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('ruta.archivos')->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }

    // Método para descargar archivos
    public function download($archivo)
    {
        $archivoInfo = $this->obtenerArchivo(null, $archivo);

        if ($archivoInfo) {
            return Storage::disk($archivoInfo['disk'])->download($archivoInfo['path']);
        }

        return redirect()->route('ruta.archivos')->with('error', 'El archivo no existe.');
    }

    public function stream($archivo)
    {
        $archivoInfo = $this->obtenerArchivo(null, $archivo);

        if (!$archivoInfo) {
            abort(404);
        }

        return $this->respuestaStream($archivoInfo);
    }

    public function view($archivo)
    {
        return $this->responderVisualizacion(null, $archivo);
    }

    // Método para eliminar archivos
    public function delete($archivo)
    {
        $carpeta = 'mi_carpeta';
        $ruta = $carpeta . '/' . $archivo;

        if (Storage::exists($ruta)) {
            Storage::delete($ruta);
            return redirect()->route('ruta.archivos')->with('success', 'Archivo eliminado correctamente.');
        }

        return redirect()->route('ruta.archivos')->with('error', 'El archivo no existe.');
    }

    // Método para crear carpetas
    public function createFolder(Request $request)
    {
        $request->validate([
            'nombre_carpeta' => 'required|string',
        ]);

        $carpeta = 'mi_carpeta/' . $request->nombre_carpeta;

        if (!Storage::exists($carpeta)) {
            Storage::makeDirectory($carpeta);
            return redirect()->route('ruta.archivos')->with('success', 'Carpeta creada correctamente.');
        }

        return redirect()->route('ruta.archivos')->with('error', 'La carpeta ya existe.');
    }

    // Método para eliminar carpetas
    public function deleteFolder($carpeta)
    {
        $ruta = 'mi_carpeta/' . $carpeta;

        if (Storage::exists($ruta)) {
            Storage::deleteDirectory($ruta);
            return redirect()->route('ruta.archivos')->with('success', 'Carpeta eliminada correctamente.');
        }

        return redirect()->route('ruta.archivos')->with('error', 'La carpeta no existe.');
    }

    // Método para abrir una carpeta y ver su contenido
    public function openFolder($carpeta = null)
    {
        // Decodifica la ruta completa
        $carpeta = $carpeta ? urldecode($carpeta) : null;

        // Construye la ruta completa
        $ruta = 'mi_carpeta/' . ($carpeta ?? '');

        // Limpia la ruta de caracteres especiales adicionales
        $ruta = rtrim($ruta, '/');

        if (!Storage::exists($ruta)) {
            return redirect()->route('ruta.archivos')->with('error', 'La carpeta no existe.');
        }

        $archivos = Storage::files($ruta);
        $subcarpetas = Storage::directories($ruta);

        return view('archivos.folder', compact('archivos', 'subcarpetas', 'carpeta', 'ruta'));
    }

    // Método para subir archivos a una carpeta específica
    public function uploadToFolder(Request $request, $carpeta)
    {
        $request->validate([
            'archivo' => 'required|file',
        ]);

        try {
            $carpeta = urldecode($carpeta);
            $ruta = 'mi_carpeta/' . $carpeta;
            $archivo = $request->file('archivo');
            $archivo->storeAs($ruta, $archivo->getClientOriginalName(), 'public'); // Usa el disco 'public'

            return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])
                ->with('success', 'Archivo subido correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])
                ->with('error', 'Error al subir el archivo: ' . $e->getMessage());
        }
    }
    // Método para descargar archivos de una carpeta específica
    public function downloadFromFolder($carpeta, $archivo)
    {
        $carpeta = urldecode($carpeta);
        $archivoInfo = $this->obtenerArchivo($carpeta, $archivo);

        if ($archivoInfo) {
            return Storage::disk($archivoInfo['disk'])->download($archivoInfo['path']);
        }

        return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])->with('error', 'El archivo no existe.');
    }

    public function streamFromFolder($carpeta, $archivo)
    {
        $carpeta = urldecode($carpeta);
        $archivoInfo = $this->obtenerArchivo($carpeta, $archivo);

        if (!$archivoInfo) {
            abort(404);
        }

        return $this->respuestaStream($archivoInfo);
    }

    public function viewFromFolder($carpeta, $archivo)
    {
        $carpeta = urldecode($carpeta);

        return $this->responderVisualizacion($carpeta, $archivo);
    }

    // Método para eliminar archivos de una carpeta específica
    public function deleteFromFolder($carpeta, $archivo)
    {
        $ruta = 'mi_carpeta/' . $carpeta . '/' . $archivo;

        if (Storage::exists($ruta)) {
            Storage::delete($ruta);
            return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])->with('success', 'Archivo eliminado correctamente.');
        }

        return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])->with('error', 'El archivo no existe.');
    }

    private function obtenerArchivo(?string $carpeta, string $archivo): ?array
    {
        $archivo = basename($archivo);
        $base = 'mi_carpeta';

        if ($carpeta) {
            $carpeta = trim(str_replace('\\', '/', $carpeta), '/');
            $ruta = $base . '/' . $carpeta . '/' . $archivo;
        } else {
            $ruta = $base . '/' . $archivo;
        }

        foreach (['local', 'public'] as $disk) {
            if (Storage::disk($disk)->exists($ruta)) {
                return ['disk' => $disk, 'path' => $ruta];
            }
        }

        return null;
    }

    private function responderVisualizacion(?string $carpeta, string $archivo)
    {
        $archivoInfo = $this->obtenerArchivo($carpeta, $archivo);

        if (!$archivoInfo) {
            if ($carpeta) {
                return redirect()->route('archivos.open-folder', ['carpeta' => $carpeta])
                    ->with('error', 'El archivo no existe.');
            }

            return redirect()->route('ruta.archivos')->with('error', 'El archivo no existe.');
        }

        $nombre = basename($archivo);
        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        if ($this->esArchivoOfficePrevisualizable($extension)) {
            return view('archivos.preview', [
                'nombre' => $nombre,
                'extension' => $extension,
                'streamUrl' => $carpeta
                    ? route('archivos.stream-from-folder', ['carpeta' => $carpeta, 'archivo' => $nombre])
                    : route('archivos.stream', ['archivo' => $nombre]),
                'downloadUrl' => $carpeta
                    ? route('archivos.download-from-folder', ['carpeta' => $carpeta, 'archivo' => $nombre])
                    : route('archivos.download', ['archivo' => $nombre]),
                'volverUrl' => $carpeta
                    ? route('archivos.open-folder', ['carpeta' => $carpeta])
                    : route('ruta.archivos'),
            ]);
        }

        if ($this->esArchivoInlineEnNavegador($extension)) {
            return $this->mostrarArchivoEnLinea($archivoInfo);
        }

        return view('archivos.preview', [
            'nombre' => $nombre,
            'extension' => $extension,
            'sinPreview' => true,
            'downloadUrl' => $carpeta
                ? route('archivos.download-from-folder', ['carpeta' => $carpeta, 'archivo' => $nombre])
                : route('archivos.download', ['archivo' => $nombre]),
            'volverUrl' => $carpeta
                ? route('archivos.open-folder', ['carpeta' => $carpeta])
                : route('ruta.archivos'),
        ]);
    }

    private function respuestaStream(array $archivoInfo)
    {
        $disk = Storage::disk($archivoInfo['disk']);
        $nombre = basename($archivoInfo['path']);

        return response($disk->get($archivoInfo['path']), 200, [
            'Content-Type' => $this->mimeTypeParaVisualizacion(
                $archivoInfo['disk'],
                $archivoInfo['path'],
                $nombre
            ),
            'Content-Disposition' => 'inline; filename="' . $nombre . '"',
        ]);
    }

    private function esArchivoOfficePrevisualizable(string $extension): bool
    {
        return in_array($extension, ['docx', 'xls', 'xlsx'], true);
    }

    private function esArchivoInlineEnNavegador(string $extension): bool
    {
        return in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'txt', 'html', 'htm'], true);
    }

    private function mostrarArchivoEnLinea(array $archivoInfo)
    {
        $disk = Storage::disk($archivoInfo['disk']);
        $nombre = basename($archivoInfo['path']);
        $mime = $this->mimeTypeParaVisualizacion($archivoInfo['disk'], $archivoInfo['path'], $nombre);

        return $disk->response($archivoInfo['path'], $nombre, [
            'Content-Type' => $mime,
        ], 'inline')->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $nombre
        );
    }

    private function mimeTypeParaVisualizacion(string $disk, string $ruta, string $nombre): string
    {
        $mime = Storage::disk($disk)->mimeType($ruta);
        if ($mime && $mime !== 'application/octet-stream') {
            return $mime;
        }

        $map = [
            'pdf' => 'application/pdf',
            'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'xls' => 'application/vnd.ms-excel',
            'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            'svg' => 'image/svg+xml',
            'txt' => 'text/plain; charset=UTF-8',
            'html' => 'text/html; charset=UTF-8',
            'htm' => 'text/html; charset=UTF-8',
        ];

        $extension = strtolower(pathinfo($nombre, PATHINFO_EXTENSION));

        return $map[$extension] ?? 'application/octet-stream';
    }
}
