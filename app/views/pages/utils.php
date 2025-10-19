<?php
$pageTitle = "Utilitários - " . APP_NAME;
$currentPage = 'utils';
require_once __DIR__ . '/../layouts/header.php';
AuthController::requireAuth();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title"><i class="bi bi-tools"></i> Utilitários do Sistema</h1>
                <p class="text-muted">Ferramentas úteis para desenvolvimento e manutenção</p>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-key"></i> Gerador de Hash de Senha</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Digite uma senha para gerar o hash bcrypt usado no banco de dados:</p>
                            
                            <form id="passwordHashForm">
                                <div class="mb-3">
                                    <label for="passwordInput" class="form-label">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="passwordInput" placeholder="Digite a senha">
                                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordInput">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-hash"></i> Gerar Hash
                                </button>
                            </form>
                            
                            <div id="hashResult" class="mt-3" style="display: none;">
                                <hr>
                                <h6><i class="bi bi-check-circle text-success"></i> Hash Gerado:</h6>
                                <div class="alert alert-info">
                                    <code id="generatedHash" class="d-block"></code>
                                </div>
                                <button class="btn btn-sm btn-outline-primary" id="copyHash">
                                    <i class="bi bi-clipboard"></i> Copiar Hash
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-shield-check"></i> Verificador de Senha</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted mb-3">Verifique se uma senha corresponde a um hash:</p>
                            
                            <form id="passwordVerifyForm">
                                <div class="mb-3">
                                    <label for="verifyPassword" class="form-label">Senha</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                        <input type="password" class="form-control" id="verifyPassword" placeholder="Digite a senha">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="verifyHash" class="form-label">Hash</label>
                                    <textarea class="form-control" id="verifyHash" rows="3" placeholder="Cole o hash aqui"></textarea>
                                </div>
                                
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle"></i> Verificar
                                </button>
                            </form>
                            
                            <div id="verifyResult" class="mt-3" style="display: none;">
                                <hr>
                                <div id="verifyMessage"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-database"></i> Informações do Banco</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            try {
                                $database = new Database();
                                $pdo = $database->getConnection();
                                
                                // Informações da conexão
                                echo "<h6>Conexão:</h6>";
                                echo "<ul class='list-unstyled'>";
                                echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
                                echo "<li><strong>Database:</strong> " . DB_NAME . "</li>";
                                echo "<li><strong>Charset:</strong> " . DB_CHARSET . "</li>";
                                echo "<li><strong>Versão:</strong> " . DB_VERSION . "</li>";
                                echo "</ul>";
                                
                                // Contar usuários
                                $stmt = $pdo->query("SELECT COUNT(*) as total FROM users");
                                $totalUsers = $stmt->fetch()['total'];
                                
                                $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE status = 'active'");
                                $activeUsers = $stmt->fetch()['total'];
                                
                                echo "<h6>Usuários:</h6>";
                                echo "<ul class='list-unstyled'>";
                                echo "<li><strong>Total:</strong> {$totalUsers}</li>";
                                echo "<li><strong>Ativos:</strong> {$activeUsers}</li>";
                                echo "</ul>";
                                
                            } catch (Exception $e) {
                                echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-code-square"></i> Exemplos de Uso</h5>
                        </div>
                        <div class="card-body">
                            <h6>Para criar um novo usuário:</h6>
                            <pre class="bg-light p-3 rounded"><code>INSERT INTO users (username, email, password, full_name, status) 
VALUES ('novo_user', 'email@exemplo.com', 'HASH_AQUI', 'Nome Completo', 'active');</code></pre>
                            
                            <h6>Para atualizar senha:</h6>
                            <pre class="bg-light p-3 rounded"><code>UPDATE users 
SET password = 'NOVO_HASH_AQUI' 
WHERE username = 'admin';</code></pre>
                            
                            <h6>Hash padrão admin123:</h6>
                            <code class="d-block text-break">$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

