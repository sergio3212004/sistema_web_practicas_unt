<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Google\Client as GoogleClient;
use Google\Service\Drive as GoogleDrive;
use Illuminate\Support\Facades\Session;

class GoogleDriveController extends Controller
{
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

    public function redirectToGoogle(Request $request)
    {
        $client = $this->getClient();
        $authUrl = $client->createAuthUrl();

        // Guardar la URL de retorno en la sesión
        $returnUrl = $request->input('return_url', route('profile.edit'));
        Session::put('google_drive_return_url', $returnUrl);

        return redirect($authUrl);
    }

    public function handleGoogleCallback(Request $request)
    {
        if (!$request->has('code')) {
            $returnUrl = Session::get('google_drive_return_url', route('profile.edit'));
            return redirect($returnUrl)
                ->with('error', 'No se recibió autorización de Google Drive');
        }

        $client = $this->getClient();
        $token = $client->fetchAccessTokenWithAuthCode($request->code);

        if (isset($token['error'])) {
            $returnUrl = Session::get('google_drive_return_url', route('profile.edit'));
            return redirect($returnUrl)
                ->with('error', 'Error al conectar con Google Drive');
        }

        // Guardar el token en la sesión
        Session::put('google_drive_token', $token);
        Session::put('google_picker_ready', true);

        // Obtener la URL de retorno y limpiarla de la sesión
        $returnUrl = Session::get('google_drive_return_url', route('profile.edit'));
        Session::forget('google_drive_return_url');

        return redirect($returnUrl)
            ->with('status', 'google-connected');
    }
}
