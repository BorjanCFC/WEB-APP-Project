<?php
define('BASE_PATH', dirname(__DIR__));
define('APP_URL', 'http://localhost/OnlineStore');

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once BASE_PATH . '/config/config.php';

spl_autoload_register(function($className) {
    $file = BASE_PATH . '/app/core/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
    
    $file = BASE_PATH . '/app/controllers/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }

    $file = BASE_PATH . '/app/models/' . $className . '.php';
    if (file_exists($file)) {
        require_once $file;
        return;
    }
});

$app = new App();