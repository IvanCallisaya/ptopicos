<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class AudiusMusicController extends Controller
{
    public function searchAndDownloadMusic(Request $request)
    {
        try {
            // Definir la URL base de la API de Audius
            $apiUrl = config('services.audius.api_url');

            // Parámetros de la solicitud GET para buscar la música
            $queryParams = [
                'query' => 'baauer b2b',
                'only_downloadable' => 'true',
                'app_name' => 'EXAMPLEAPP',
            ];

            // Realizar la solicitud GET para buscar la música
            $response = Http::withHeaders(['Accept' => 'application/json'])
                ->get($apiUrl . '/v1/tracks/search', $queryParams);

            $musicData = $response->json();

            // Verificar si se encontraron resultados de música
            if (!empty($musicData['data'])) {
                // Tomar la primera canción encontrada
                $firstTrack = $musicData['data'][0];

                // Obtener el ID de la pista
                $trackId = $firstTrack['id'];

                // URL para descargar la música por ID
                $downloadUrl = 'https://dn1.nodeoperator.io/v1/tracks/' . $trackId . '/stream';

                // Configurar el cliente Guzzle
                $client = new Client();

                // Realizar la solicitud GET para descargar la música
                $downloadResponse = $client->request('GET', $downloadUrl);

                // Obtener el contenido de la respuesta
                $musicContent = $downloadResponse->getBody()->getContents();

                // Directorio local donde deseas guardar la música (puedes personalizarlo según tus necesidades)
                $localDirectory = storage_path('app/public/music');

                // Crear el directorio si no existe
                if (!file_exists($localDirectory)) {
                    mkdir($localDirectory, 0755, true);
                }

                // Ruta completa del archivo de destino local
                $localFilePath = $localDirectory . '/music.mp3';

                // Guardar el archivo de música localmente
                file_put_contents($localFilePath, $musicContent);

                // La música se ha descargado exitosamente
                Log::error('Música descargada exitosamente: ' . $localFilePath);
                return response()->json(['message' => 'Música descargada exitosamente']);
            }

            // Si no se encontraron resultados de música descargable, mostrar un mensaje de error
            return response()->json(['message' => 'No se encontraron resultados de música descargable'], 404);
        } catch (\Exception $e) {
            // Registra el error en el registro de Laravel
            Log::error('Error al buscar y descargar la música: ' . $e->getMessage());

            // Puedes personalizar el mensaje de error que deseas mostrar al usuario
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }
}
