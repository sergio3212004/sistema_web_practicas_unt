<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Support\Facades\Session;

class GoogleDriveController extends Controller
{
    //
    protected function getClient()
    {
        $client = new GoogleClient();
        $client->setClientId(config('services.google.client_id'));
        $client->setClientSecret(config('services.google.client_secret'));
        $client->setRedirectUri(config('services.google.redirect'));
        $client->setScopes([
            GoogleDrive::DRIVE_READONLY,
            GoogleDrive::DRIVE_METADATA_READONLY
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('consent');

        return $client;
    }

    public function redirectToGoogle()
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();

        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            return redirect()->route('profile.edit')
                ->with('error', 'No se recibió autorización de Google Drive');
        }

        $client = $this->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            return redirect()->route('profile.edit')
                ->with('error', 'Error al conectar con Google Drive');
        }

        // Guardar el token en la sesión
        Session::put('google_drive_token', $token);
        Session::put('google_picker_ready', true);

        return redirect()->route('profile.edit')
            ->with('status', 'google-connected');
    }
}
