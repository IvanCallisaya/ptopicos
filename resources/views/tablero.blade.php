<!DOCTYPE html>
<html>
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8">
    <title>Mi Tablero</title>
    <!-- Agrega tus enlaces CSS aquí -->
    <link rel="stylesheet" href="ruta/a/tu/hoja/de/estilos.css">
    <style>
        /* Estilos para la Barra de Herramientas en la Parte Inferior */
        .toolbar {
            background-color: #000;
            color: #000;
            padding: 10px;
            width: 100%;
            position: fixed;
            bottom: 0;
            left: 0;
            z-index: 3; /* Capa superior */
            display: flex; /* Cambia la disposición a horizontal */
            justify-content: center; /* Centra los botones horizontalmente */
            align-items: center; /* Centra los botones verticalmente */
        }

        /* Estilos para los Botones de Herramientas */
        .tool-button {
            background-color: #555;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin-right: 10px;
            cursor: pointer;
        }

        .tool-button:hover {
            background-color: #777;
        }

        /* Estilos para el Panel a la Derecha */
        .panel {
            background-color: #f0f0f0;
            width: 250px; /* Ancho del panel derecho */
            position: fixed;
            right: 0;
            top: 0; /* Alinea el panel desde el inicio de la página */
            height: 100%; /* Ocupa todo el espacio vertical */
            z-index: 2; /* Capa superior */
        }

        /* Estilos para el Contenido Principal */
        .content {
            margin-right: 250px; /* Deja espacio para el panel a la derecha */
            margin-bottom: 40px; /* Deja espacio para la barra de herramientas en la parte inferior */
        }

        /* Estilos para el Contenedor Central */
        .main-container {
            display: flex;
            flex-direction: column;
            height: calc(100vh - 40px); /* Altura del viewport menos la altura de la barra de herramientas */
        }
        /* Estilos para los Mensajes de Respuesta */
        .message-section {
            margin: 20px; /* Espacio alrededor de los mensajes */
        }

        .alert {
            padding: 10px;
            margin-bottom: 10px;
        }

        .alert-success {
            background-color: #4CAF50;
            color: white;
        }

        .alert-danger {
            background-color: #f44336;
            color: white;
        }
    </style>
</head>
<body>
<!-- Contenedor Principal (Tablero) -->
<div class="main-container">
    <!-- Barra de Herramientas en la Parte Inferior -->
    <div class="toolbar">
        <div class="tool">
            <button class="tool-button" id="createClipButton">Crear Clip</button>
        </div>
        <div class="tool">
            <button class="tool-button" id="createClipButtonSWH">Crear Clip SWH</button>
        </div>
        <div class="tool">
            <button class="tool-button"id="createMusicButtonSWH">Crear Música</button>
        </div>
        <div class="tool">
            <button class="tool-button">Video</button>
        </div>
    </div>

    <!-- Reproductor de Multimedia (Espacio central) -->
    <div class="content">
        <!-- Aquí puedes incluir un reproductor multimedia -->
        <!-- Por ejemplo, puedes usar un reproductor de video de HTML5 o una biblioteca de terceros -->
    </div>
    <div class="message-section">
        @if (isset($responseData))
            @if (isset($responseData['status']))
                <div class="alert alert-success">
                    La solicitud fue exitosa.
                </div>
            @else
                <div class="alert alert-danger">
                    La solicitud no fue exitosa. Mensaje de error: {{ $responseData['error_message'] ?? 'Sin mensaje de error' }}
                </div>
            @endif
        @endif
    </div>
</div>

<!-- Panel a la Derecha para Partes del Programa de TV -->
<div class="panel">
    <!-- Aquí se añaden las partes del programa de televisión -->
    <!-- Puedes usar JavaScript para gestionar esta área -->
</div>

<!-- Agrega tus enlaces JavaScript aquí -->
<script src="ruta/a/tu/script.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // Espera a que el documento HTML esté completamente cargado
    $(document).ready(function () {
        // Escucha el clic en el botón "Crear Clip" por su ID
        $('#createClipButton').click(function () {
            // Realiza una solicitud AJAX POST al servidor para ejecutar la función createClip
            $.ajax({
                url: '{{ route("createClip") }}', // Utiliza el nombre de la ruta
                method: 'POST', // Utiliza el método HTTP correcto (POST en este caso)
                data: {
                    // Puedes incluir datos adicionales si es necesario
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Incluye el token CSRF en la cabecera
                },
                success: function (response) {
                    // Maneja la respuesta del servidor aquí si es necesario
                    console.log('Clip creado con éxito', response);
                },
                error: function (xhr, status, error) {
                    // Maneja los errores aquí si es necesario
                    console.error('Error al crear el clip', error);
                },
            });
        });
        $('#createClipButtonSWH').click(function () {
            // Realiza una solicitud AJAX POST al servidor para ejecutar la función createClip
            $.ajax({
                url: '{{ route("createClipSWH") }}', // Utiliza el nombre de la ruta
                method: 'POST', // Utiliza el método HTTP correcto (POST en este caso)
                data: {
                    // Puedes incluir datos adicionales si es necesario
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Incluye el token CSRF en la cabecera
                },
                success: function (response) {
                    // Maneja la respuesta del servidor aquí si es necesario
                    console.log('Clip creado con éxito', response);
                },
                error: function (xhr, status, error) {
                    // Maneja los errores aquí si es necesario
                    console.error('Error al crear el clip', error);
                },
            });
        });
        $('#createMusicButtonSWH').click(function () {
            // Realiza una solicitud AJAX POST al servidor para ejecutar la función createClip
            $.ajax({
                url: '{{ route("createMusicSWH") }}', // Utiliza el nombre de la ruta
                method: 'POST', // Utiliza el método HTTP correcto (POST en este caso)
                data: {
                    // Puedes incluir datos adicionales si es necesario
                },
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Incluye el token CSRF en la cabecera
                },
                success: function (response) {
                    // Maneja la respuesta del servidor aquí si es necesario
                    console.log('Clip creado con éxito', response);
                },
                error: function (xhr, status, error) {
                    // Maneja los errores aquí si es necesario
                    console.error('Error al crear el clip', error);
                },
            });
        });
    });
</script>
</body>
</html>
