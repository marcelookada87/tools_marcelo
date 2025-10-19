<?php
/**
 * Index Principal
 * Gerencia o roteamento da aplicação
 */

require_once __DIR__ . '/app/config/config.php';
require_once __DIR__ . '/app/config/database.php';

$page = $_GET['page'] ?? 'login';

if (!AuthController::isAuthenticated() && $page !== 'login') {
    $page = 'login';
}

if (AuthController::isAuthenticated() && $page === 'login') {
    header('Location: index.php?page=dashboard');
    exit();
}

switch ($page) {
    case 'login':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');
            $auth = new AuthController();
            $result = $auth->login();
            echo json_encode($result);
            exit();
        }
        require_once __DIR__ . '/app/views/auth/login.php';
        break;
        
    case 'logout':
        $auth = new AuthController();
        $auth->logout();
        break;
        
    case 'dashboard':
        require_once __DIR__ . '/app/views/dashboard/index.php';
        break;
        
    case 'users':
        require_once __DIR__ . '/app/views/pages/users.php';
        break;
        
    case 'branch-name':
        require_once __DIR__ . '/app/views/pages/branch-name.php';
        break;
        
    case 'settings':
        require_once __DIR__ . '/app/views/pages/settings.php';
        break;
        
    case 'reports':
        require_once __DIR__ . '/app/views/pages/reports.php';
        break;
        
    case 'utils':
        if (isset($_GET['action'])) {
            header('Content-Type: application/json');
            
            switch ($_GET['action']) {
                case 'generate_hash':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $password = $_POST['password'] ?? '';
                        if ($password) {
                            $hash = password_hash($password, PASSWORD_BCRYPT);
                            echo json_encode(['success' => true, 'hash' => $hash]);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Senha não fornecida']);
                        }
                    }
                    exit();
                    
                case 'verify_password':
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $password = $_POST['password'] ?? '';
                        $hash = $_POST['hash'] ?? '';
                        
                        if ($password && $hash) {
                            $valid = password_verify($password, $hash);
                            echo json_encode(['valid' => $valid]);
                        } else {
                            echo json_encode(['valid' => false]);
                        }
                    }
                    exit();
            }
        }
        
        require_once __DIR__ . '/app/views/pages/utils.php';
        break;
    
    case 'profile':
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>' . APP_NAME . '</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '<link rel="stylesheet" href="public/css/style.css"></head><body>';
        echo '<div class="container mt-5"><div class="alert alert-info">';
        echo '<h4>Página em Desenvolvimento</h4>';
        echo '<p>Esta página está em construção. Por favor, volte mais tarde.</p>';
        echo '<a href="index.php?page=dashboard" class="btn btn-primary">Voltar ao Dashboard</a>';
        echo '</div></div></body></html>';
        break;
        
    default:
        header("HTTP/1.0 404 Not Found");
        echo '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>404 - Página não encontrada</title>';
        echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">';
        echo '</head><body><div class="container mt-5"><div class="alert alert-danger">';
        echo '<h1>404</h1><p>Página não encontrada.</p>';
        echo '<a href="index.php?page=dashboard" class="btn btn-primary">Ir para Dashboard</a>';
        echo '</div></div></body></html>';
        break;
}

