<?php
$pageTitle = "Login - " . APP_NAME;
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="login-container">
    <div class="login-box">
        <div class="text-center mb-4">
            <h1 class="h3"><i class="bi bi-grid-3x3-gap-fill"></i> <?php echo APP_NAME; ?></h1>
            <p class="text-muted">Faça login para continuar</p>
        </div>
        
        <div id="alert-container"></div>
        
        <form id="loginForm" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Usuário ou E-mail</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" id="username" name="username" required autofocus>
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input type="password" class="form-control" id="password" name="password" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Lembrar-me</label>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-box-arrow-in-right"></i> Entrar
            </button>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

