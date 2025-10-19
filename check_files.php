<?php
/**
 * Verificador de Arquivos Necessários
 * Upload para o servidor e acesse via navegador
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 Verificação de Arquivos - Dashboard System</h1>";
echo "<style>
    body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
    .ok { color: green; font-weight: bold; }
    .error { color: red; font-weight: bold; }
    .warning { color: orange; font-weight: bold; }
    table { width: 100%; border-collapse: collapse; background: white; }
    th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
    th { background: #333; color: white; }
    .section { margin: 20px 0; padding: 15px; background: white; border-radius: 5px; }
</style>";

echo "<div class='section'>";
echo "<h2>📂 Diretório Atual</h2>";
echo "<p><strong>Path:</strong> " . __DIR__ . "</p>";
echo "</div>";

$requiredFiles = [
    'index.php' => 'Roteador principal',
    'app/config/config.php' => 'Configurações',
    'app/config/database.php' => 'Classe Database',
    'app/controllers/AuthController.php' => 'Controller de autenticação',
    'app/controllers/DashboardController.php' => 'Controller do dashboard',
    'app/models/User.php' => 'Model de usuários',
    'app/views/auth/login.php' => 'Página de login',
    'app/views/dashboard/index.php' => 'Dashboard',
    'app/views/layouts/header.php' => 'Header',
    'app/views/layouts/footer.php' => 'Footer',
    'app/views/layouts/menu.php' => 'Menu lateral',
    'app/views/layouts/navbar.php' => 'Navbar',
    'app/views/pages/users.php' => 'Página usuários',
    'app/views/pages/settings.php' => 'Página configurações',
    'app/views/pages/reports.php' => 'Página relatórios',
    'app/views/pages/utils.php' => 'Página utilitários',
    'public/css/style.css' => 'Estilos CSS',
    'public/js/main.js' => 'JavaScript',
    'patch/version_01/patch_001_create_users_table.php' => 'Patch PHP',
    'patch/sql/version_01/patch_001_create_users_table.sql' => 'Patch SQL',
    'patch/sql/version_01/main_structure.sql' => 'Estrutura completa SQL',
    'apply_patches.php' => 'Aplicador de patches',
];

echo "<div class='section'>";
echo "<h2>📋 Verificação de Arquivos</h2>";
echo "<table>";
echo "<tr><th>Arquivo</th><th>Descrição</th><th>Status</th></tr>";

$missingFiles = [];
$foundFiles = 0;

foreach ($requiredFiles as $file => $description) {
    $fullPath = __DIR__ . '/' . $file;
    $exists = file_exists($fullPath);
    
    if ($exists) {
        $foundFiles++;
        $status = "<span class='ok'>✅ OK</span>";
    } else {
        $missingFiles[] = $file;
        $status = "<span class='error'>❌ FALTA</span>";
    }
    
    echo "<tr>";
    echo "<td><code>$file</code></td>";
    echo "<td>$description</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}

echo "</table>";
echo "</div>";

$totalFiles = count($requiredFiles);
$percentage = round(($foundFiles / $totalFiles) * 100, 1);

echo "<div class='section'>";
echo "<h2>📊 Estatísticas</h2>";
echo "<p><strong>Total de arquivos necessários:</strong> $totalFiles</p>";
echo "<p><strong>Arquivos encontrados:</strong> $foundFiles</p>";
echo "<p><strong>Arquivos faltando:</strong> " . count($missingFiles) . "</p>";
echo "<p><strong>Completude:</strong> <span style='font-size: 24px; font-weight: bold;'>{$percentage}%</span></p>";
echo "</div>";

if (count($missingFiles) > 0) {
    echo "<div class='section'>";
    echo "<h2>⚠️ Arquivos que precisam ser enviados:</h2>";
    echo "<ul>";
    foreach ($missingFiles as $file) {
        echo "<li><code>$file</code></li>";
    }
    echo "</ul>";
    echo "</div>";
}

// Verificar extensões PHP
echo "<div class='section'>";
echo "<h2>🔧 Extensões PHP</h2>";
echo "<table>";
echo "<tr><th>Extensão</th><th>Status</th></tr>";

$extensions = ['pdo', 'pdo_mysql', 'mbstring', 'json'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    $status = $loaded ? "<span class='ok'>✅ Instalada</span>" : "<span class='error'>❌ NÃO instalada</span>";
    echo "<tr><td><code>$ext</code></td><td>$status</td></tr>";
}
echo "</table>";
echo "</div>";

echo "<div class='section'>";
echo "<h2>ℹ️ Informações do Sistema</h2>";
echo "<p><strong>PHP Version:</strong> " . PHP_VERSION . "</p>";
echo "<p><strong>Server:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Desconhecido') . "</p>";
echo "<p><strong>Document Root:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Desconhecido') . "</p>";
echo "</div>";

if ($percentage == 100) {
    echo "<div class='section' style='background: #d4edda; border: 2px solid #28a745;'>";
    echo "<h2 style='color: #155724;'>🎉 Parabéns! Todos os arquivos estão presentes!</h2>";
    echo "<p>O sistema está pronto para funcionar.</p>";
    echo "<p><a href='index.php' style='padding: 10px 20px; background: #28a745; color: white; text-decoration: none; border-radius: 5px;'>Acessar Dashboard</a></p>";
    echo "</div>";
} else {
    echo "<div class='section' style='background: #f8d7da; border: 2px solid #dc3545;'>";
    echo "<h2 style='color: #721c24;'>⚠️ Atenção! Arquivos faltando</h2>";
    echo "<p>Faça upload dos arquivos faltantes via cPanel File Manager ou FTP.</p>";
    echo "</div>";
}

echo "<hr>";
echo "<p style='text-align: center; color: #666;'><small>Após verificar, você pode deletar este arquivo (check_files.php)</small></p>";

