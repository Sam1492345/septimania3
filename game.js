document.addEventListener('DOMContentLoaded', function() {
    const gameContainer = document.getElementById('game-container');
    const startButton = document.getElementById('start-game');

    // Crear y configurar el elemento audio
    const audio = document.createElement('audio');
    audio.controls = true;
    document.body.appendChild(audio);

    // Cargar la lista de canciones
    fetch('list_songs.php')
        .then(response => response.json())
        .then(songs => {
            const select = document.createElement('select');
            songs.forEach(song => {
                const option = document.createElement('option');
                option.value = song;
                option.textContent = song;
                select.appendChild(option);
            });
            document.body.insertBefore(select, startButton); // Asegúrate de insertar el selector antes del botón

            select.addEventListener('change', () => {
                const source = document.createElement('source');
                source.src = `uploads/${select.value}`;
                source.type = 'audio/mpeg';
                audio.appendChild(source);
                audio.load();  // Cargar la nueva fuente de audio
            });
        })
        .catch(error => console.error('Error fetching song list:', error));

    // Iniciar el juego al hacer clic en el botón
    startButton.addEventListener('click', () => {
        audio.play().then(() => {
            console.log('Juego iniciado con éxito');
            // Agrega aquí la lógica para comenzar a mostrar y ocultar símbolos
        }).catch(error => {
            console.error('Error al intentar reproducir el audio:', error);
        });
    });
});
