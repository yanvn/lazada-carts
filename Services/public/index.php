<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

function test($o) {
    print_r($o);
    exit;
}

require __DIR__ . '/../vendor/autoload.php';

session_start();

$dotenv = new \Dotenv\Dotenv(__DIR__ . '/..');
$dotenv->load();

// Instantiate the app
$settings = require __DIR__ . '/../src/settings.php';
$app = new \Slim\App($settings);

$app->add(new \Slim\Middleware\JwtAuthentication([
    "secure" => false,
    "path" => ["/api"],
    "passthrough" => ["/api/login", "/api/ping"],
    "secret" => getenv('SECRET_KEY')
]));

// Set up dependencies
require __DIR__ . '/../src/dependencies.php';

// Register middleware
require __DIR__ . '/../src/middleware.php';

// Register routes
require __DIR__ . '/../src/routes.php';

// Run app
$app->run();
