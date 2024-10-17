<?php
// Ruta al archivo JSON donde se almacenarán las canciones
$jsonFilePath = 'songs_data.json';

// Verifica si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recoger datos del formulario
    $title = $_POST['title'];
    $artist = $_POST['artist'];
    $gameData = $_POST['gameData'];

    // Para manejar los archivos subidos
    $musicFile = $_FILES['musicFile'];
    $coverFile = $_FILES['coverFile'];

    // Validaciones básicas
    if (!empty($title) && !empty($artist) && !empty($musicFile['tmp_name']) && !empty($coverFile['tmp_name'])) {

        // Mover archivos subidos a una carpeta 'uploads' (crearla si no existe)
        $uploadDir = 'uploads/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $musicFilePath = $uploadDir . basename($musicFile['name']);
        $coverFilePath = $uploadDir . basename($coverFile['name']);

        move_uploaded_file($musicFile['tmp_name'], $musicFilePath);
        move_uploaded_file($coverFile['tmp_name'], $coverFilePath);

        // Crear un array con los datos
        $newSong = [
            'title' => $title,
            'artist' => $artist,
            'musicFile' => $musicFilePath,
            'coverFile' => $coverFilePath,
            'gameData' => $gameData
        ];

        // Leer el archivo JSON existente (o crearlo si no existe)
        if (file_exists($jsonFilePath)) {
            $songsData = json_decode(file_get_contents($jsonFilePath), true);
        } else {
            $songsData = [];
        }

        // Añadir la nueva canción
        $songsData[] = $newSong;

        // Guardar la nueva lista de canciones en el archivo JSON
        file_put_contents($jsonFilePath, json_encode($songsData, JSON_PRETTY_PRINT));

        // Redireccionar o mostrar un mensaje de éxito
        echo "La canción ha sido añadida correctamente.";
    } else {
        echo "Error: Faltan campos por completar o archivos por subir.";
    }
} else {
    echo "Error: El formulario no fue enviado correctamente.";
}
?>
