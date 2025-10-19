jQuery(document).ready(function($) {
    
    $('#sidebarCollapse').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#content').toggleClass('active');
    });
    
    $('#togglePassword').on('click', function() {
        const passwordInput = $('#password');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
    
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        const submitBtn = $(this).find('button[type="submit"]');
        const alertContainer = $('#alert-container');
        
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Entrando...');
        alertContainer.empty();
        
        $.ajax({
            url: 'index.php?page=login',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alertContainer.html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        '<i class="bi bi-check-circle"></i> ' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                    
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 1000);
                } else {
                    alertContainer.html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        '<i class="bi bi-exclamation-triangle"></i> ' + response.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );
                    submitBtn.prop('disabled', false).html('<i class="bi bi-box-arrow-in-right"></i> Entrar');
                }
            },
            error: function() {
                alertContainer.html(
                    '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                    '<i class="bi bi-exclamation-triangle"></i> Erro ao processar requisição.' +
                    '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                    '</div>'
                );
                submitBtn.prop('disabled', false).html('<i class="bi bi-box-arrow-in-right"></i> Entrar');
            }
        });
    });
    
    if ($('#activityChart').length) {
        const ctx = document.getElementById('activityChart').getContext('2d');
        
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(13, 110, 253, 0.3)');
        gradient.addColorStop(1, 'rgba(13, 110, 253, 0.05)');
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                datasets: [{
                    label: 'Acessos',
                    data: [12, 19, 15, 25, 22, 30, 28, 35, 32, 40, 38, 45],
                    backgroundColor: gradient,
                    borderColor: 'rgba(13, 110, 253, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: 'rgba(13, 110, 253, 1)',
                    pointHoverRadius: 5,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            borderDash: [5, 5]
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    }
    
    if ($('#usersTable').length) {
        $('#usersTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/pt-BR.json'
            },
            order: [[0, 'desc']],
            pageLength: 10
        });
    }
    
    // Gerador de Hash de Senha
    $('#passwordHashForm').on('submit', function(e) {
        e.preventDefault();
        
        const password = $('#passwordInput').val();
        if (!password) {
            alert('Digite uma senha!');
            return;
        }
        
        $.ajax({
            url: 'index.php?page=utils&action=generate_hash',
            type: 'POST',
            data: { password: password },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $('#generatedHash').text(response.hash);
                    $('#hashResult').show();
                } else {
                    alert('Erro: ' + response.message);
                }
            },
            error: function() {
                alert('Erro ao gerar hash!');
            }
        });
    });
    
    // Verificador de Senha
    $('#passwordVerifyForm').on('submit', function(e) {
        e.preventDefault();
        
        const password = $('#verifyPassword').val();
        const hash = $('#verifyHash').val();
        
        if (!password || !hash) {
            alert('Digite a senha e o hash!');
            return;
        }
        
        $.ajax({
            url: 'index.php?page=utils&action=verify_password',
            type: 'POST',
            data: { password: password, hash: hash },
            dataType: 'json',
            success: function(response) {
                let alertClass = response.valid ? 'alert-success' : 'alert-danger';
                let icon = response.valid ? 'bi-check-circle' : 'bi-x-circle';
                let message = response.valid ? 'Senha válida!' : 'Senha inválida!';
                
                $('#verifyMessage').html(
                    '<div class="alert ' + alertClass + '">' +
                    '<i class="' + icon + '"></i> ' + message +
                    '</div>'
                );
                $('#verifyResult').show();
            },
            error: function() {
                alert('Erro ao verificar senha!');
            }
        });
    });
    
    // Copiar Hash
    $('#copyHash').on('click', function() {
        const hash = $('#generatedHash').text();
        navigator.clipboard.writeText(hash).then(function() {
            $(this).html('<i class="bi bi-check"></i> Copiado!');
            setTimeout(() => {
                $(this).html('<i class="bi bi-clipboard"></i> Copiar Hash');
            }, 2000);
        }.bind(this));
    });
    
    // Toggle Password Input
    $('#togglePasswordInput').on('click', function() {
        const passwordInput = $('#passwordInput');
        const icon = $(this).find('i');
        
        if (passwordInput.attr('type') === 'password') {
            passwordInput.attr('type', 'text');
            icon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            passwordInput.attr('type', 'password');
            icon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });
});

