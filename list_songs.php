<?php
$directory = 'uploads/';
$files = array_diff(scandir($directory), array('..', '.'));
$mp3Files = array_filter($files, function ($file) use ($directory) {
    return is_file($directory . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'mp3';
});
echo json_encode(array_values($mp3Files));
?>
