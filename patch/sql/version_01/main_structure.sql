-- Estrutura Principal do Banco de Dados
-- Versão: 1.0
-- Data: 2025-10-19
-- Este arquivo reflete a estrutura completa do banco de dados

-- Database: dashboard_db

-- ========================================
-- Tabela: users
-- ========================================
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `full_name` VARCHAR(100) NOT NULL,
    `status` ENUM('active', 'inactive', 'blocked') DEFAULT 'active',
    `last_login` DATETIME NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_username` (`username`),
    INDEX `idx_email` (`email`),
    INDEX `idx_status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Usuário administrador padrão
-- Username: admin
-- Senha: admin123
INSERT INTO `users` (`username`, `email`, `password`, `full_name`, `status`) VALUES
('admin', 'admin@dashboard.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrador', 'active');

