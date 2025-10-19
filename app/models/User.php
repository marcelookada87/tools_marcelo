<?php
/**
 * Model User
 * Gerencia operações relacionadas aos usuários
 */

class User {
    private $conn;
    private $table = 'users';

    public $id;
    public $username;
    public $email;
    public $password;
    public $full_name;
    public $status;
    public $last_login;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    /**
     * Autentica um usuário
     */
    public function authenticate($username, $password) {
        $query = "SELECT * FROM {$this->table} 
                  WHERE (username = :username OR email = :email) 
                  AND status = 'active' 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            
            if (password_verify($password, $row['password'])) {
                $this->id = $row['id'];
                $this->username = $row['username'];
                $this->email = $row['email'];
                $this->full_name = $row['full_name'];
                $this->status = $row['status'];
                
                $this->updateLastLogin();
                
                return true;
            }
        }
        
        return false;
    }

    /**
     * Atualiza o último login do usuário
     */
    private function updateLastLogin() {
        $query = "UPDATE {$this->table} 
                  SET last_login = NOW() 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
    }

    /**
     * Busca usuário por ID
     */
    public function findById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch();
            
            $this->id = $row['id'];
            $this->username = $row['username'];
            $this->email = $row['email'];
            $this->full_name = $row['full_name'];
            $this->status = $row['status'];
            $this->last_login = $row['last_login'];
            $this->created_at = $row['created_at'];
            $this->updated_at = $row['updated_at'];
            
            return true;
        }
        
        return false;
    }

    /**
     * Lista todos os usuários
     */
    public function getAll() {
        $query = "SELECT id, username, email, full_name, status, last_login, created_at 
                  FROM {$this->table} 
                  ORDER BY created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    /**
     * Cria um novo usuário
     */
    public function create() {
        $query = "INSERT INTO {$this->table} 
                  (username, email, password, full_name, status) 
                  VALUES (:username, :email, :password, :full_name, :status)";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));
        $hashed_password = password_hash($this->password, PASSWORD_BCRYPT);

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':status', $this->status);

        return $stmt->execute();
    }

    /**
     * Atualiza um usuário existente
     */
    public function update() {
        $query = "UPDATE {$this->table} 
                  SET username = :username, 
                      email = :email, 
                      full_name = :full_name, 
                      status = :status 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $this->username = htmlspecialchars(strip_tags($this->username));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->full_name = htmlspecialchars(strip_tags($this->full_name));

        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }

    /**
     * Deleta um usuário
     */
    public function delete() {
        $query = "DELETE FROM {$this->table} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        return $stmt->execute();
    }
}

