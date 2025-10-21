<?php
/**
 * Controller de Autenticação
 * Gerencia login, logout e sessões
 */

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    /**
     * Processa o login
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $remember = isset($_POST['remember']) && $_POST['remember'] == '1';

            if (empty($username) || empty($password)) {
                return [
                    'success' => false,
                    'message' => 'Usuário e senha são obrigatórios'
                ];
            }

            if ($this->user->authenticate($username, $password)) {
                // Define o tempo de vida da sessão: 1 ano
                $lifetime = 365 * 24 * 60 * 60;
                
                // Configura o cookie de sessão com o tempo definido
                $params = session_get_cookie_params();
                setcookie(
                    session_name(),
                    session_id(),
                    time() + $lifetime,
                    $params['path'],
                    $params['domain'],
                    $params['secure'],
                    $params['httponly']
                );
                
                // Configura o tempo de vida da sessão no servidor
                ini_set('session.gc_maxlifetime', $lifetime);
                
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['full_name'] = $this->user->full_name;
                $_SESSION['logged_in'] = true;
                $_SESSION['login_time'] = time();
                $_SESSION['session_lifetime'] = $lifetime;

                return [
                    'success' => true,
                    'message' => 'Login realizado com sucesso',
                    'redirect' => 'index.php?page=dashboard'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Usuário ou senha inválidos'
                ];
            }
        }
    }

    /**
     * Realiza o logout
     */
    public function logout() {
        session_unset();
        session_destroy();
        header('Location: index.php?page=login');
        exit();
    }

    /**
     * Verifica se o usuário está autenticado
     */
    public static function isAuthenticated() {
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            return false;
        }
        
        // Verifica se a sessão expirou
        if (isset($_SESSION['login_time']) && isset($_SESSION['session_lifetime'])) {
            $elapsed = time() - $_SESSION['login_time'];
            if ($elapsed > $_SESSION['session_lifetime']) {
                // Sessão expirada
                session_unset();
                session_destroy();
                return false;
            }
        }
        
        return true;
    }

    /**
     * Middleware para proteger páginas
     */
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: index.php?page=login');
            exit();
        }
    }

    /**
     * Retorna dados do usuário logado
     */
    public static function getCurrentUser() {
        if (self::isAuthenticated()) {
            return [
                'id' => $_SESSION['user_id'] ?? null,
                'username' => $_SESSION['username'] ?? null,
                'full_name' => $_SESSION['full_name'] ?? null
            ];
        }
        return null;
    }
}

