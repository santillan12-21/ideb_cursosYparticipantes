<?php

namespace App\Services;

use Google\Client;
use Google\Service\Drive;
use RuntimeException;

class GoogleDriveService
{
    public static function getService(): Drive
    {
        $config = config('filesystems.disks.google');
        $clientId = trim((string) ($config['clientId'] ?? ''));
        $clientSecret = trim((string) ($config['clientSecret'] ?? ''));
        $refreshToken = trim((string) ($config['refreshToken'] ?? ''));

        if ($clientId === '' || $clientSecret === '' || $refreshToken === '') {
            throw new RuntimeException('Faltan credenciales de Google Drive en el archivo .env.');
        }

        $client = new Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->setScopes([Drive::DRIVE_READONLY]);

        $token = $client->fetchAccessTokenWithRefreshToken($refreshToken);

        if (isset($token['error'])) {
            $details = trim(($token['error_description'] ?? '') . ' ' . ($token['error'] ?? ''));
            throw new RuntimeException(
                'Error de autenticación con Google Drive: ' . $details .
                '. Verifica GOOGLE_DRIVE_CLIENT_ID, GOOGLE_DRIVE_CLIENT_SECRET y GOOGLE_DRIVE_REFRESH_TOKEN en el .env.'
            );
        }

        $client->setAccessToken($token);

        return new Drive($client);
    }

    public static function rootFolderId(): ?string
    {
        return config('filesystems.disks.google.folderId');
    }
}
