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
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['index'])) {
            $index = $_POST['index'];

            // Eliminar la canción basada en el índice
            if (isset($songs[$index])) {
                unset($songs[$index]);

                // Guardar el archivo JSON actualizado
                file_put_contents($json_file, json_encode(array_values($songs), JSON_PRETTY_PRINT));

                // Redireccionar de vuelta a la lista de canciones
                header("Location: listarcanso.php");
                exit;
            } else {
                echo "Canción no encontrada.";
            }
        }
    }
?>
