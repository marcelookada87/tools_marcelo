<?php
/**
 * Controller do Dashboard
 * Gerencia as páginas do dashboard
 */

class DashboardController {
    private $db;
    private $user;

    public function __construct() {
        AuthController::requireAuth();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    /**
     * Página principal do dashboard
     */
    public function index() {
        $currentUser = AuthController::getCurrentUser();
        $users = $this->user->getAll();
        
        return [
            'currentUser' => $currentUser,
            'totalUsers' => count($users),
            'users' => $users
        ];
    }

    /**
     * Estatísticas do dashboard
     */
    public function getStats() {
        $users = $this->user->getAll();
        $activeUsers = array_filter($users, fn($u) => $u['status'] === 'active');
        
        return [
            'total_users' => count($users),
            'active_users' => count($activeUsers),
            'last_login' => date('d/m/Y H:i:s')
        ];
    }
}

