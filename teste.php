<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Teste de Database</h1>";
echo "<pre>";

echo "1. Diretório atual: " . __DIR__ . "\n\n";

echo "2. Tentando incluir config.php...\n";
$configPath = __DIR__ . '/app/config/config.php';
echo "   Caminho: $configPath\n";
if (file_exists($configPath)) {
    echo "   ✅ config.php existe\n";
    require_once $configPath;
    echo "   ✅ config.php incluído\n\n";
} else {
    echo "   ❌ config.php NÃO existe\n";
    die();
}

echo "3. Verificando database.php...\n";
$dbPath = __DIR__ . '/app/config/database.php';
echo "   Caminho: $dbPath\n";
if (file_exists($dbPath)) {
    echo "   ✅ database.php existe\n";
    echo "   Tamanho: " . filesize($dbPath) . " bytes\n\n";
} else {
    echo "   ❌ database.php NÃO existe\n";
    die();
}

echo "4. Listando arquivos em app/config/:\n";
$files = scandir(__DIR__ . '/app/config/');
foreach ($files as $file) {
    if ($file != '.' && $file != '..') {
        echo "   - $file\n";
    }
}
echo "\n";

echo "5. Tentando carregar Database manualmente...\n";
require_once $dbPath;
echo "   ✅ database.php incluído\n\n";

echo "6. Verificando se classe Database existe...\n";
if (class_exists('Database')) {
    echo "   ✅ Classe Database existe!\n\n";
    
    echo "7. Tentando criar instância...\n";
    try {
        $db = new Database();
        echo "   ✅ Instância criada!\n\n";
        
        echo "8. Tentando conectar...\n";
        $conn = $db->getConnection();
        echo "   ✅ CONEXÃO OK!\n\n";
        
        echo "═══════════════════════════════════\n";
        echo "✅ TUDO FUNCIONANDO!\n";
        echo "O problema NÃO é o database.php\n";
        echo "O problema é o AUTOLOADER!\n";
        echo "═══════════════════════════════════\n";
        
    } catch (Exception $e) {
        echo "   ❌ Erro: " . $e->getMessage() . "\n";
    }
} else {
    echo "   ❌ Classe Database NÃO existe!\n";
}

echo "</pre>";

