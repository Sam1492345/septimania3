<?php
    // Leer el archivo JSON
    $json_file = "songs_data.json";
    $songs = array();

    if (file_exists($json_file)) {
        $songs = json_decode(file_get_contents($json_file), true);

        // Comprobación de errores de decodificación
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error al decodificar el archivo JSON: ' . json_last_error_msg();
            exit;
        }
    } else {
        echo "Archivo JSON no encontrado.";
        exit;
    }

    // Verificar si se ha recibido el índice en el parámetro GET
    if (isset($_GET['index'])) {
        $index = $_GET['index'];

        // Verificar si el índice es válido
        if (isset($songs[$index])) {
            $song = $songs[$index];
            $title = $song['title'];
            $artist = $song['artist'];
            $coverFile = $song['coverFile'];
            $musicFile = $song['musicFile'];
        } else {
            echo "No se ha encontrado la canción a editar.";
            exit;
        }
    } else {
        echo "No se ha proporcionado ningún índice.";
        exit;
    }

    // Verificar si se ha enviado el formulario
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $title = $_POST['title'];
        $artist = $_POST['artist'];
        $coverFile = $_POST['coverFile'];  // Ahora viene de un campo oculto
        $musicFile = $_POST['musicFile'];

        // Actualizar los datos de la canción
        $songs[$index]['title'] = $title;
        $songs[$index]['artist'] = $artist;
        $songs[$index]['coverFile'] = $coverFile;
        $songs[$index]['musicFile'] = $musicFile;

        // Guardar el archivo JSON actualizado
        file_put_contents($json_file, json_encode($songs, JSON_PRETTY_PRINT));

        // Redireccionar de vuelta a la lista de canciones
        header("Location: listarcanso.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Canción</title>
    <style>
 body, html {
    margin: 0;
    padding: 0;
    height: 100%;
    font-family: 'Poppins', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f0f0f0;
}

#bg-video {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: -1;
}

.container {
    text-align: center;
    background: rgba(255, 255, 255, 0.9);
    padding: 20px; /* Reducimos el padding */
    border-radius: 10px;
    width: 80%;
    max-width: 400px;
    max-height: 90vh; /* Hacemos el contenedor más corto en relación con la pantalla */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    display: flex;
    flex-direction: column;
    justify-content: space-between; /* Asegura que el contenido esté distribuido */
    overflow-y: auto; /* Añade scroll si el contenido excede la altura */
}

h1 {
    font-size: 1.8em; /* Ajustamos ligeramente el tamaño */
    margin-bottom: 10px; /* Reducimos el margen */
    color: #333;
}

form {
    display: flex;
    flex-direction: column;
    align-items: center;
}

label {
    font-size: 1.1em;
    margin: 5px 0 5px; /* Reducimos los márgenes */
    color: #333;
}

input[type="text"] {
    padding: 8px; /* Reducimos el padding */
    width: 100%;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-bottom: 15px; /* Reducimos el margen inferior */
}

button {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 8px 15px; /* Reducimos el tamaño de los botones */
    border-radius: 5px;
    cursor: pointer;
    margin: 8px;
    font-size: 1em;
}

button:hover {
    background-color: #45a049;
}

audio {
    margin-top: 15px;
    width: 100%;
    max-width: 300px;
}

h3 {
    margin-top: 15px;
    color: #333;
}

button:focus {
    outline: none;
}

img {
    width: 120px; /* Hacemos la imagen más pequeña */
    height: auto;
    margin-bottom: 15px;
}

button#back {
    background-color: #f44336;
}

button#back:hover {
    background-color: #d32f2f;
}

    </style>
</head>
<body>

    <!-- Video de fondo -->
    <video autoplay muted loop id="bg-video">
        <source src="wavevideo.mp4" type="video/mp4">
        Tu navegador no soporta la reproducción de videos.
    </video>

    <div class="container">
        <h1>Editar Cançó</h1>

        <form method="POST" action="editar.php?index=<?php echo $index; ?>">
            <label for="title">Títol:</label>
            <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($title); ?>" required><br>

            <label for="artist">Autor:</label>
            <input type="text" name="artist" id="artist" value="<?php echo htmlspecialchars($artist); ?>" required><br>

            <h3>Portada de la cançó:</h3>
            <img src="<?php echo htmlspecialchars($coverFile); ?>" alt="Portada"><br>

            <!-- Campo oculto para enviar la URL de la portada -->
            <input type="hidden" name="coverFile" value="<?php echo htmlspecialchars($coverFile); ?>">

            <label for="musicFile">Ruta del arxiu MP3:</label>
            <input type="text" name="musicFile" id="musicFile" value="<?php echo htmlspecialchars($musicFile); ?>" required><br>

            <h3>Escoltar la cançó actual:</h3>
            <audio controls>
                <source src="<?php echo htmlspecialchars($musicFile); ?>" type="audio/mpeg">
                Tu navegador no soporta la reproducción de audio.
            </audio><br>

            <button type="submit">Guardar Canvis</button>
        </form>

        <button id="back" onclick="window.location.href='listarcanso.php'">Tornar</button>
    </div>

</body>
</html>
