<?php
$pageTitle = "Usuários - " . APP_NAME;
$currentPage = 'users';
require_once __DIR__ . '/../layouts/header.php';
AuthController::requireAuth();

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$users = $user->getAll();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title"><i class="bi bi-people"></i> Gerenciamento de Usuários</h1>
                <p class="text-muted">Gerencie todos os usuários do sistema</p>
            </div>
            
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Lista de Usuários</h5>
                            <button class="btn btn-primary btn-sm">
                                <i class="bi bi-plus-circle"></i> Novo Usuário
                            </button>
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
                                            <th>Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($users as $userData): ?>
                                            <tr>
                                                <td><?php echo $userData['id']; ?></td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                            <?php echo strtoupper(substr($userData['username'], 0, 1)); ?>
                                                        </div>
                                                        <strong><?php echo htmlspecialchars($userData['username']); ?></strong>
                                                    </div>
                                                </td>
                                                <td><?php echo htmlspecialchars($userData['email']); ?></td>
                                                <td><?php echo htmlspecialchars($userData['full_name']); ?></td>
                                                <td>
                                                    <?php
                                                    $statusClass = $userData['status'] === 'active' ? 'success' : 'danger';
                                                    $statusText = $userData['status'] === 'active' ? 'Ativo' : 'Inativo';
                                                    ?>
                                                    <span class="badge bg-<?php echo $statusClass; ?>">
                                                        <?php echo $statusText; ?>
                                                    </span>
                                                </td>
                                                <td><?php echo $userData['last_login'] ? date('d/m/Y H:i', strtotime($userData['last_login'])) : '-'; ?></td>
                                                <td><?php echo date('d/m/Y', strtotime($userData['created_at'])); ?></td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button class="btn btn-outline-primary" title="Editar">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <button class="btn btn-outline-danger" title="Excluir">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
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

