<?php
/**
 * Script para aplicar patches no banco de dados
 * Execute: php apply_patches.php
 */

echo "===========================================\n";
echo "    APLICADOR DE PATCHES - Dashboard DB    \n";
echo "===========================================\n\n";

require_once __DIR__ . '/app/config/database.php';

try {
    $database = new Database();
    $pdo = $database->getConnection();
    
    echo "✓ Conexão com banco de dados estabelecida\n\n";
    
    $version = 1;
    $patchDir = __DIR__ . "/patch/version_0{$version}";
    
    if (!is_dir($patchDir)) {
        throw new Exception("Diretório de patches não encontrado: {$patchDir}");
    }
    
    $patches = glob($patchDir . '/patch_*.php');
    sort($patches);
    
    if (empty($patches)) {
        echo "⚠ Nenhum patch encontrado.\n";
        exit(0);
    }
    
    echo "Patches encontrados: " . count($patches) . "\n";
    echo "-------------------------------------------\n\n";
    
    foreach ($patches as $patch) {
        $patchName = basename($patch);
        echo "Aplicando: {$patchName}...\n";
        
        ob_start();
        require $patch;
        $output = ob_get_clean();
        
        echo $output . "\n";
        echo "-------------------------------------------\n\n";
    }
    
    echo "✓ Todos os patches foram aplicados com sucesso!\n\n";
    echo "Credenciais de acesso:\n";
    echo "Usuário: admin\n";
    echo "Senha: admin123\n\n";
    
} catch (PDOException $e) {
    echo "✗ Erro de conexão: " . $e->getMessage() . "\n";
    echo "\nVerifique as configurações em app/config/config.php\n";
    exit(1);
} catch (Exception $e) {
    echo "✗ Erro: " . $e->getMessage() . "\n";
    exit(1);
}

