<?php

namespace App;

spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/src/';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$uri = $_SERVER['REQUEST_URI'];
$uri = explode('/', $uri);
$uri = array_filter($uri);
$uri = array_values($uri);

if (empty($uri)) {
    $controller = 'App\\Controllers\\Home';
    $action = 'index';
}
else {
    $controller = 'App\\Controllers\\' . ucfirst($uri[0]) . 'Controller';
    $action = $uri[1] ?? 'index';
}