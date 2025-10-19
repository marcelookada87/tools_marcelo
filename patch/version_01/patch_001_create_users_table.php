<?php
/**
 * Patch 001 - Criação da tabela de usuários
 * Versão: 1.0
 * Data: 2025-10-19
 */

require_once __DIR__ . '/../../app/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    // Lê o arquivo SQL correspondente
    $sqlFile = __DIR__ . '/../sql/version_01/patch_001_create_users_table.sql';
    
    if (!file_exists($sqlFile)) {
        throw new Exception("Arquivo SQL não encontrado: {$sqlFile}");
    }
    
    $sql = file_get_contents($sqlFile);
    
    // Executa o SQL
    $pdo->exec($sql);
    
    echo "Patch 001 aplicado com sucesso!\n";
    echo "Tabela 'users' criada com sucesso.\n";
    
} catch (PDOException $e) {
    echo "Erro ao aplicar patch 001: " . $e->getMessage() . "\n";
    exit(1);
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
    exit(1);
}

