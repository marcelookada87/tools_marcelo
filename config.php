<?php
/**
 * Configurações Gerais da Aplicação
 * UPLOAD PARA: app/config/config.php
 */

// Configurações de Sessão (apenas se não for CLI)
if (PHP_SAPI !== 'cli') {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.use_only_cookies', 1);
    ini_set('session.cookie_secure', 0); // Defina como 1 em produção com HTTPS

    // Iniciar sessão
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
}

// Configurações do Banco de Dados
define('DB_HOST', 'localhost');
define('DB_NAME', 'mar02514_dashboard_db');
define('DB_USER', 'mar02514_admin');
define('DB_PASS', 'Marina@@@');
define('DB_CHARSET', 'utf8mb4');

// Versão do Banco de Dados (alterado manualmente)
define('DB_VERSION', 1);

// Configurações da Aplicação
define('APP_NAME', 'Dashboard System');
define('APP_URL', 'http://toolsmarcelo.mcmsoftwares.com.br');
define('APP_ENV', 'production'); // development ou production

// Timezone
date_default_timezone_set('America/Sao_Paulo');

// Error Reporting
if (APP_ENV === 'development') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

// Autoload Classes
spl_autoload_register(function ($class) {
    $paths = [
        __DIR__ . '/../models/' . $class . '.php',
        __DIR__ . '/../controllers/' . $class . '.php',
        __DIR__ . '/' . $class . '.php',
    ];
    
    foreach ($paths as $path) {
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

