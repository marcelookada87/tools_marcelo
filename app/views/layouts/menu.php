<?php
/**
 * Menu de Navegação
 * Este arquivo contém todos os itens do menu
 * Fácil de adicionar ou remover itens
 */

$menuItems = [
    [
        'title' => 'Dashboard',
        'icon' => 'bi-speedometer2',
        'url' => 'index.php?page=dashboard',
        'active' => ($currentPage ?? '') === 'dashboard'
    ],
    [
        'title' => 'Usuários',
        'icon' => 'bi-people',
        'url' => 'index.php?page=users',
        'active' => ($currentPage ?? '') === 'users'
    ],
    [
        'title' => 'Configurações',
        'icon' => 'bi-gear',
        'url' => 'index.php?page=settings',
        'active' => ($currentPage ?? '') === 'settings'
    ],
    [
        'title' => 'Relatórios',
        'icon' => 'bi-file-earmark-text',
        'url' => 'index.php?page=reports',
        'active' => ($currentPage ?? '') === 'reports'
    ],
    [
        'title' => 'Utilitários',
        'icon' => 'bi-tools',
        'url' => 'index.php?page=utils',
        'active' => ($currentPage ?? '') === 'utils'
    ]
];
?>

<nav id="sidebar" class="sidebar">
    <div class="sidebar-header">
        <h3><i class="bi bi-grid-3x3-gap-fill"></i> <?php echo APP_NAME; ?></h3>
    </div>
    
    <ul class="list-unstyled components">
        <?php foreach ($menuItems as $item): ?>
            <li class="<?php echo $item['active'] ? 'active' : ''; ?>">
                <a href="<?php echo $item['url']; ?>">
                    <i class="<?php echo $item['icon']; ?>"></i>
                    <span><?php echo $item['title']; ?></span>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
    
    <div class="sidebar-footer">
        <a href="index.php?page=logout" class="btn btn-danger btn-sm w-100">
            <i class="bi bi-box-arrow-right"></i> Sair
        </a>
    </div>
</nav>

