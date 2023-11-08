<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;

class VideoGenerationController extends Controller
{
    public function createClip(Request $request)
    {
        try {
            // Obtener la API Key desde la configuración
            $apiKey = config('services.d_id.api_key');

            // Obtener la URL de la API desde la configuración
            $apiUrl = config('services.d_id.api_url');

            // Definir la URL base para el entorno local (localhost)
            $localBaseUrl = 'http://127.0.0.1:8000';

            // Definir la ruta del webhook en tu aplicación Laravel
            $webhookRoute = '/webhook/d-id-clip';

            // Combinar la URL base y la ruta del webhook
            $webhookUrl = $localBaseUrl . $webhookRoute;

            // Datos que deseas enviar en el cuerpo de la solicitud para crear el clip
            $data = [
                'script' => [
                    'type' => 'text',
                    'input' => 'Hello world!',
                ],
                'presenter_id' => 'amy-jcwCkr1grs',
                'driver_id' => 'uM00QMwJ9x',
                'webhook' => $webhookUrl, // Utiliza la URL completa del webhook
            ];

            // Crear una instancia de Guzzle Client
            $client = new Client();

            // Realizar la solicitud POST para crear el clip utilizando las variables de configuración
            $response = $client->request('POST', $apiUrl . '/clips', [
                'json' => $data,
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($apiKey),
                    'Content-Type' => 'application/json',
                ],
            ]);

            // Obtener la respuesta de la API de D-ID y decodificarla como JSON
            $responseData = json_decode($response->getBody(), true);

            // Puedes realizar acciones adicionales según tus necesidades
            // ...

            return view('tablero', ['responseData' => $responseData]);
        } catch (\Exception $e) {
            // Registra el error en el registro de Laravel
            \Log::error('Error al crear el clip: ' . $e->getMessage());

            // Puedes personalizar el mensaje de error que deseas mostrar al usuario
            return response()->json(['message' => 'Error interno del servidor'], 500);
        }
    }


    public function handleWebhook(Request $request)
    {
        // Obtener los datos del webhook como JSON
        $webhookData = json_decode($request->getContent(), true);

        // Verificar el estado del clip
        if ($webhookData['status'] === 'done') {
            // Descargar el video localmente (ejemplo: en la carpeta de almacenamiento 'storage/app/videos')
            $videoUrl = $webhookData['result_url'];
            $localPath = storage_path('app/videos/') . 'video.mp4';

            // Descargar el archivo
            $fileContents = file_get_contents($videoUrl);
            file_put_contents($localPath, $fileContents);

            // Realizar acciones adicionales si es necesario
        }

        // Devolver una respuesta exitosa al webhook
        return response()->json(['message' => 'Webhook received and processed successfully']);
    }

    public function createClipSWH(Request $request)
    {
        // Obtener la API Key desde la configuración
        $apiKey = config('services.d_id.api_key');

        // Obtener la URL de la API desde la configuración
        $apiUrl = config('services.d_id.api_url');

        // Datos que deseas enviar en el cuerpo de la solicitud para crear la conversación
        $data = [
            'script' => [
                'type' => 'text',
                'input' => 'Hello world!',
            ],
            'presenter_id' => 'amy-jcwCkr1grs',
            'driver_id' => 'uM00QMwJ9x',
        ];

        // Crear una instancia de Guzzle Client
        $client = new Client();

        // Realizar la solicitud POST para crear la conversación
        $response = $client->request('POST', $apiUrl . '/clips', [
            'json' => $data,
            'headers' => [
                'Authorization' => 'Basic ' . base64_encode($apiKey),
                'Content-Type' => 'application/json',
            ],
        ]);

        // Obtener la respuesta de la API de D-ID y decodificarla como JSON
        $responseData = json_decode($response->getBody(), true);

        // Extraer el ID de la conversación de la respuesta
        $conversationId = $responseData['id'];
        $videoUrl='';
        // Esperar hasta que el estado de la conversación sea "done"
        while (true) {
            $statusResponse = $client->request('GET', "https://api.d-id.com/clips/{$conversationId}", [
                'headers' => [
                    'Authorization' => 'Basic ' . base64_encode($apiKey),
                    'Content-Type' => 'application/json',
                ],
            ]);

            $statusData = json_decode($statusResponse->getBody(), true);

            // Verificar si el estado de la conversación es "done"
            if ($statusData['status'] === 'done') {
                // La conversación está lista, obtén la URL del video generado
                $videoUrl = $statusData['result_url'];
                break;
            }

            // Esperar un tiempo antes de verificar nuevamente (puedes ajustar este tiempo según tus necesidades)
            sleep(5); // Espera 5 segundos antes de verificar de nuevo
        }
        $localPath = storage_path('app/public/videos/') . 'video.mp4';

        // Descargar el archivo
        $fileContents = file_get_contents($videoUrl);
        file_put_contents($localPath, $fileContents);

        // Realiza acciones adicionales según tus necesidades, como guardar la URL del video o mostrarla en tu vista
        // ...

        return view('tablero', ['responseData' => $statusData]);
    }
}
