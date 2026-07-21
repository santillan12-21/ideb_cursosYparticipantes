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

        if (empty($config['clientId']) || empty($config['clientSecret']) || empty($config['refreshToken'])) {
            throw new RuntimeException('Faltan credenciales de Google Drive en el archivo .env.');
        }

        $client = new Client();
        $client->setClientId($config['clientId']);
        $client->setClientSecret($config['clientSecret']);

        $token = $client->fetchAccessTokenWithRefreshToken($config['refreshToken']);

        if (isset($token['error'])) {
            throw new RuntimeException('Error de autenticación con Google Drive: ' . ($token['error_description'] ?? $token['error']));
        }

        $client->setAccessToken($token);

        return new Drive($client);
    }

    public static function rootFolderId(): ?string
    {
        return config('filesystems.disks.google.folderId');
    }
}
