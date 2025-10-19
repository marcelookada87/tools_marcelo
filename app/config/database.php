<?php
/**
 * Classe de Conexão com o Banco de Dados
 */

class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    private $charset;
    private $conn = null;

    public function __construct() {
        if (defined('DB_HOST')) {
            $this->host = DB_HOST;
            $this->db_name = DB_NAME;
            $this->username = DB_USER;
            $this->password = DB_PASS;
            $this->charset = DB_CHARSET;
        } else {
            $this->host = 'localhost';
            $this->db_name = 'dashboard_db';
            $this->username = 'root';
            $this->password = '';
            $this->charset = 'utf8mb4';
        }
    }

    public function getConnection() {
        if ($this->conn === null) {
            try {
                $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ];
                
                $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            } catch (PDOException $e) {
                throw new Exception("Erro de conexão: " . $e->getMessage());
            }
        }
        
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn = null;
    }
}

