<?php

namespace App\Http\Controllers;

use App\Services\GoogleDriveService;
use Google\Service\Drive;
use Illuminate\Http\Request;
use RuntimeException;
use Throwable;

class GoogleDriveController extends Controller
{
    public function index(Request $request)
    {
        $rootFolderId = GoogleDriveService::rootFolderId();

        if (!$rootFolderId) {
            return view('drive.index', [
                'error' => 'No está configurado GOOGLE_DRIVE_FOLDER_ID en el archivo .env.',
                'items' => [],
                'breadcrumbs' => [],
                'currentFolderId' => null,
                'externalUrl' => config('filesystems.disks.google.folderUrl'),
            ]);
        }

        $folderId = $request->query('folder', $rootFolderId);

        try {
            $service = GoogleDriveService::getService();

            $currentFolder = $service->files->get($folderId, [
                'fields' => 'id, name, parents',
            ]);

            $response = $service->files->listFiles([
                'q' => sprintf("'%s' in parents and trashed = false", $folderId),
                'fields' => 'files(id, name, mimeType, modifiedTime, size, webViewLink)',
                'orderBy' => 'folder,name',
                'pageSize' => 200,
            ]);

            $items = collect($response->getFiles() ?? [])
                ->map(function ($file) {
                    return [
                        'id' => $file->getId(),
                        'name' => $file->getName(),
                        'mimeType' => $file->getMimeType(),
                        'modifiedTime' => $file->getModifiedTime(),
                        'size' => $file->getSize(),
                        'webViewLink' => $file->getWebViewLink(),
                        'isFolder' => $file->getMimeType() === 'application/vnd.google-apps.folder',
                    ];
                })
                ->sortBy([
                    ['isFolder', 'desc'],
                    ['name', 'asc'],
                ])
                ->values()
                ->all();

            return view('drive.index', [
                'error' => null,
                'items' => $items,
                'breadcrumbs' => $this->buildBreadcrumbs($service, $folderId, $rootFolderId),
                'currentFolderId' => $folderId,
                'currentFolderName' => $currentFolder->getName(),
                'externalUrl' => config('filesystems.disks.google.folderUrl'),
            ]);
        } catch (Throwable $e) {
            return view('drive.index', [
                'error' => 'No se pudo conectar con Google Drive: ' . $e->getMessage(),
                'items' => [],
                'breadcrumbs' => [],
                'currentFolderId' => $folderId,
                'externalUrl' => config('filesystems.disks.google.folderUrl'),
            ]);
        }
    }

    public function open(string $fileId)
    {
        try {
            $service = GoogleDriveService::getService();
            $file = $service->files->get($fileId, [
                'fields' => 'id, name, mimeType',
            ]);

            if ($file->getMimeType() === 'application/vnd.google-apps.folder') {
                return redirect()->route('drive.index', ['folder' => $fileId]);
            }

            if (str_starts_with($file->getMimeType(), 'application/vnd.google-apps.')) {
                $exported = $this->exportGoogleFile($service, $fileId, $file->getMimeType());

                return response($exported['content'])
                    ->header('Content-Type', $exported['mimeType'])
                    ->header('Content-Disposition', 'inline; filename="' . $exported['filename'] . '"');
            }

            $content = $service->files->get($fileId, ['alt' => 'media']);

            return response($content->getBody()->getContents())
                ->header('Content-Type', $file->getMimeType())
                ->header('Content-Disposition', 'inline; filename="' . $file->getName() . '"');
        } catch (Throwable $e) {
            return redirect()
                ->route('drive.index')
                ->with('error', 'No se pudo abrir el archivo: ' . $e->getMessage());
        }
    }

    public function download(string $fileId)
    {
        try {
            $service = GoogleDriveService::getService();
            $file = $service->files->get($fileId, [
                'fields' => 'id, name, mimeType',
            ]);

            if ($file->getMimeType() === 'application/vnd.google-apps.folder') {
                return redirect()->route('drive.index', ['folder' => $fileId]);
            }

            if (str_starts_with($file->getMimeType(), 'application/vnd.google-apps.')) {
                $exported = $this->exportGoogleFile($service, $fileId, $file->getMimeType());

                return response($exported['content'])
                    ->header('Content-Type', $exported['mimeType'])
                    ->header('Content-Disposition', 'attachment; filename="' . $exported['filename'] . '"');
            }

            $content = $service->files->get($fileId, ['alt' => 'media']);

            return response($content->getBody()->getContents())
                ->header('Content-Type', $file->getMimeType())
                ->header('Content-Disposition', 'attachment; filename="' . $file->getName() . '"');
        } catch (Throwable $e) {
            return redirect()
                ->route('drive.index')
                ->with('error', 'No se pudo descargar el archivo: ' . $e->getMessage());
        }
    }

    private function buildBreadcrumbs(Drive $service, string $folderId, string $rootFolderId): array
    {
        $breadcrumbs = [];
        $currentId = $folderId;

        while ($currentId) {
            $folder = $service->files->get($currentId, [
                'fields' => 'id, name, parents',
            ]);

            array_unshift($breadcrumbs, [
                'id' => $folder->getId(),
                'name' => $folder->getId() === $rootFolderId ? 'Carpeta principal' : $folder->getName(),
            ]);

            if ($currentId === $rootFolderId) {
                break;
            }

            $parents = $folder->getParents();
            $currentId = ($parents && isset($parents[0])) ? $parents[0] : null;
        }

        return $breadcrumbs;
    }

    private function exportGoogleFile(Drive $service, string $fileId, string $mimeType): array
    {
        $exportMap = [
            'application/vnd.google-apps.document' => ['mime' => 'application/pdf', 'ext' => 'pdf'],
            'application/vnd.google-apps.spreadsheet' => ['mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'ext' => 'xlsx'],
            'application/vnd.google-apps.presentation' => ['mime' => 'application/pdf', 'ext' => 'pdf'],
        ];

        if (!isset($exportMap[$mimeType])) {
            throw new RuntimeException('Este tipo de archivo de Google no se puede abrir desde la aplicación.');
        }

        $file = $service->files->get($fileId, ['fields' => 'name']);
        $export = $exportMap[$mimeType];
        $content = $service->files->export($fileId, $export['mime'], ['alt' => 'media']);

        return [
            'content' => $content->getBody()->getContents(),
            'mimeType' => $export['mime'],
            'filename' => $file->getName() . '.' . $export['ext'],
        ];
    }
}
