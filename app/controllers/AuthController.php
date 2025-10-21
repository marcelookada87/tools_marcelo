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

            if (empty($username) || empty($password)) {
                return [
                    'success' => false,
                    'message' => 'Usuário e senha são obrigatórios'
                ];
            }

            if ($this->user->authenticate($username, $password)) {
                $_SESSION['user_id'] = $this->user->id;
                $_SESSION['username'] = $this->user->username;
                $_SESSION['full_name'] = $this->user->full_name;
                $_SESSION['logged_in'] = true;

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
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
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

