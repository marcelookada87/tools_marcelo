<?php
$currentUser = AuthController::getCurrentUser();
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <button type="button" id="sidebarCollapse" class="btn btn-dark">
            <i class="bi bi-list"></i>
        </button>
        
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle"></i>
                    <?php echo htmlspecialchars($currentUser['full_name'] ?? 'Usuário'); ?>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="index.php?page=profile">
                            <i class="bi bi-person"></i> Perfil
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="index.php?page=logout">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

