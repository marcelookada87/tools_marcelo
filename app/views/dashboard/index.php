<?php
$pageTitle = "Dashboard - " . APP_NAME;
$currentPage = 'dashboard';
require_once __DIR__ . '/../layouts/header.php';

$controller = new DashboardController();
$data = $controller->index();
$stats = $controller->getStats();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title">Dashboard</h1>
                <p class="text-muted">Bem-vindo ao painel de controle</p>
            </div>
            
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Total de Usuários</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['total_users']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-people"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Usuários Ativos</h6>
                                    <h2 class="card-title mb-0"><?php echo $stats['active_users']; ?></h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-person-check"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Acessos Hoje</h6>
                                    <h2 class="card-title mb-0">24</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-graph-up"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="card-subtitle mb-2">Sistema</h6>
                                    <h2 class="card-title mb-0">Online</h2>
                                </div>
                                <div class="stat-icon">
                                    <i class="bi bi-hdd-network"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Atividade Recente</h5>
                        </div>
                        <div class="card-body">
                            <canvas id="activityChart" height="80"></canvas>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-clock-history"></i> Últimos Acessos</h5>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <?php foreach (array_slice($data['users'], 0, 5) as $user): ?>
                                    <div class="list-group-item px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($user['full_name']); ?></h6>
                                                <small class="text-muted">
                                                    <?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : 'Nunca'; ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0"><i class="bi bi-people"></i> Usuários Cadastrados</h5>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="usersTable">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuário</th>
                                            <th>E-mail</th>
                                            <th>Nome Completo</th>
                                            <th>Status</th>
                                            <th>Último Acesso</th>
                                            <th>Criado em</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($data['users'] as $user): ?>
                                            <tr>
                                                <td><?php echo $user['id']; ?></td>
                                                <td><strong><?php echo htmlspecialchars($user['username']); ?></strong></td>
                                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                                <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                                                <td>
                                                    <?php
                                                    $statusClass = $user['status'] === 'active' ? 'success' : 'danger';
                                                    $statusText = $user['status'] === 'active' ? 'Ativo' : 'Inativo';
                                                    ?>
                                                    <span class="badge bg-<?php echo $statusClass; ?>">
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $user['last_login'] ? date('d/m/Y H:i', strtotime($user['last_login'])) : '-'; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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

