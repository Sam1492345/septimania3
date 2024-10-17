<?php
    // Leer el archivo JSON y decodificarlo
    $json_file = "songs_data.json";
    $songs = array();
    if (file_exists($json_file)) {
        $songs = json_decode(file_get_contents($json_file), true);
        // Comprobación de errores de decodificación
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo 'Error al decodificar el archivo JSON: ' . json_last_error_msg();
            exit; // Detiene la ejecución si hay un error en el JSON
        }
    }
?>
<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Llistar Cançons</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
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
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        img {
            width: 50px;
            height: auto;
        }

        .actions button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        footer {
            display: flex;
            justify-content: flex-start;
            margin-top: 20px;
        }

        footer button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
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
        <header>
            <h1>Llistar Cançons</h1>
        </header>
        <main>
            <table>
                <thead>
                    <tr>
                        <th>Portada</th>
                        <th>Nom</th>
                        <th>Autor</th>
                        <th>Accions</th>
                    </tr>
                </thead>
                <tbody>
    <?php if (!empty($songs)): ?>
        <?php foreach ($songs as $index => $song): ?>
            <tr>
                <td><img src="<?php echo isset($song['coverFile']) && !empty($song['coverFile']) ? $song['coverFile'] : 'default_image.jpg'; ?>" alt="Portada"></td>
                <td><?php echo isset($song['title']) && !is_null($song['title']) ? htmlspecialchars($song['title']) : 'Desconocido'; ?></td>
                <td><?php echo isset($song['artist']) && !is_null($song['artist']) ? htmlspecialchars($song['artist']) : 'Desconocido'; ?></td>
                <td class="actions">
                    <form action="editar.php" method="GET">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit">Editar</button>
                    </form>
                    <form action="eliminar.php" method="POST">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="4">No hi ha cançons disponibles.</td>
        </tr>
    <?php endif; ?>
</tbody>
            </table>
        </main>
        <footer>
            <button onclick="window.location.href='home1.html'">Home</button>
        </footer>
    </div>
</body>
</html>
