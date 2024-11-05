<?php
spl_autoload_register(function ($class_name) {
    $paths = [
        __DIR__ . '/../controllers/',
        __DIR__ . '/../models/',
    ];

    foreach ($paths as $path) {
        $file = $path . $class_name . '.php';
        if (file_exists($file)) {
            require_once $file;
            break;
        }
    }
});
?>
