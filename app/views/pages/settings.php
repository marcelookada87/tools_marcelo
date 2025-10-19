<?php
$pageTitle = "Configurações - " . APP_NAME;
$currentPage = 'settings';
require_once __DIR__ . '/../layouts/header.php';
AuthController::requireAuth();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title"><i class="bi bi-gear"></i> Configurações</h1>
                <p class="text-muted">Configure as opções do sistema</p>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações Gerais</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label class="form-label">Nome da Aplicação</label>
                                    <input type="text" class="form-control" value="<?php echo APP_NAME; ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">URL da Aplicação</label>
                                    <input type="text" class="form-control" value="<?php echo APP_URL; ?>">
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Ambiente</label>
                                    <select class="form-select">
                                        <option <?php echo APP_ENV === 'development' ? 'selected' : ''; ?>>development</option>
                                        <option <?php echo APP_ENV === 'production' ? 'selected' : ''; ?>>production</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label">Timezone</label>
                                    <input type="text" class="form-control" value="<?php echo date_default_timezone_get(); ?>" readonly>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-check-circle"></i> Salvar Configurações
                                </button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Configurações de Segurança</h5>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="twoFactor">
                                    <label class="form-check-label" for="twoFactor">
                                        Autenticação de dois fatores
                                    </label>
                                </div>
                                
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="sessionTimeout" checked>
                                    <label class="form-check-label" for="sessionTimeout">
                                        Timeout de sessão automático
                                    </label>
                                </div>
                                
                                <div class="mb-3 form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="loginHistory" checked>
                                    <label class="form-check-label" for="loginHistory">
                                        Registrar histórico de login
                                    </label>
                                </div>
                                
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-shield-check"></i> Salvar Segurança
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Informações do Sistema</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item px-0">
                                    <strong>Versão PHP:</strong><br>
                                    <?php echo PHP_VERSION; ?>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>Versão DB:</strong><br>
                                    <?php echo DB_VERSION; ?>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>Servidor:</strong><br>
                                    <?php echo $_SERVER['SERVER_SOFTWARE'] ?? 'N/A'; ?>
                                </li>
                                <li class="list-group-item px-0">
                                    <strong>Data/Hora:</strong><br>
                                    <?php echo date('d/m/Y H:i:s'); ?>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Manutenção</h5>
                        </div>
                        <div class="card-body">
                            <button class="btn btn-warning w-100 mb-2">
                                <i class="bi bi-arrow-clockwise"></i> Limpar Cache
                            </button>
                            <button class="btn btn-info w-100 mb-2">
                                <i class="bi bi-database"></i> Backup do Banco
                            </button>
                            <button class="btn btn-danger w-100">
                                <i class="bi bi-exclamation-triangle"></i> Modo Manutenção
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

