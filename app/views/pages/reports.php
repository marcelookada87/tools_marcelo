<?php
$pageTitle = "Relatórios - " . APP_NAME;
$currentPage = 'reports';
require_once __DIR__ . '/../layouts/header.php';
AuthController::requireAuth();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title"><i class="bi bi-file-earmark-text"></i> Relatórios</h1>
                <p class="text-muted">Visualize e exporte relatórios do sistema</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-people text-primary" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Usuários</h5>
                            <p class="card-text text-muted">Relatório de usuários cadastrados</p>
                            <button class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-download"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-graph-up text-success" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Acessos</h5>
                            <p class="card-text text-muted">Histórico de acessos ao sistema</p>
                            <button class="btn btn-sm btn-outline-success">
                                <i class="bi bi-download"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-clock-history text-warning" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Atividades</h5>
                            <p class="card-text text-muted">Log de atividades do sistema</p>
                            <button class="btn btn-sm btn-outline-warning">
                                <i class="bi bi-download"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <i class="bi bi-shield-check text-info" style="font-size: 3rem;"></i>
                            <h5 class="card-title mt-3">Segurança</h5>
                            <p class="card-text text-muted">Relatório de segurança</p>
                            <button class="btn btn-sm btn-outline-info">
                                <i class="bi bi-download"></i> Exportar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Gerar Relatório Customizado</h5>
                        </div>
                        <div class="card-body">
                            <form class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tipo de Relatório</label>
                                    <select class="form-select">
                                        <option>Usuários</option>
                                        <option>Acessos</option>
                                        <option>Atividades</option>
                                        <option>Segurança</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Data Inicial</label>
                                    <input type="date" class="form-control" value="<?php echo date('Y-m-01'); ?>">
                                </div>
                                
                                <div class="col-md-3">
                                    <label class="form-label">Data Final</label>
                                    <input type="date" class="form-control" value="<?php echo date('Y-m-d'); ?>">
                                </div>
                                
                                <div class="col-md-2">
                                    <label class="form-label">Formato</label>
                                    <select class="form-select">
                                        <option>PDF</option>
                                        <option>Excel</option>
                                        <option>CSV</option>
                                    </select>
                                </div>
                                
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-file-earmark-arrow-down"></i> Gerar Relatório
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Relatórios Recentes</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tipo</th>
                                            <th>Período</th>
                                            <th>Formato</th>
                                            <th>Gerado em</th>
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><i class="bi bi-people text-primary"></i> Usuários</td>
                                            <td>01/10/2025 - 19/10/2025</td>
                                            <td><span class="badge bg-danger">PDF</span></td>
                                            <td>19/10/2025 10:30</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-graph-up text-success"></i> Acessos</td>
                                            <td>01/09/2025 - 30/09/2025</td>
                                            <td><span class="badge bg-success">Excel</span></td>
                                            <td>01/10/2025 14:15</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><i class="bi bi-shield-check text-info"></i> Segurança</td>
                                            <td>01/08/2025 - 31/08/2025</td>
                                            <td><span class="badge bg-info">CSV</span></td>
                                            <td>01/09/2025 09:00</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-download"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

