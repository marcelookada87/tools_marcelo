<?php
$pageTitle = "Branch Name - " . APP_NAME;
$currentPage = 'branch-name';
require_once __DIR__ . '/../layouts/header.php';
AuthController::requireAuth();
?>

<div class="wrapper">
    <?php require_once __DIR__ . '/../layouts/menu.php'; ?>
    
    <div id="content">
        <?php require_once __DIR__ . '/../layouts/navbar.php'; ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h1 class="page-title"><i class="bi bi-git"></i> Branch Name</h1>
                <p class="text-muted">Converte texto em formato de nome de branch (substitui espaços por hífens)</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-body p-4">
                            <div class="mb-4">
                                <label for="branchType" class="form-label fw-bold">Tipo de Branch:</label>
                                <select class="form-select form-select-lg" id="branchType">
                                    <option value="saas-feature">saas-feature</option>
                                    <option value="saas-fix">saas-fix</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="branchNumber" class="form-label fw-bold">Número (opcional):</label>
                                <input type="text" class="form-control form-control-lg" id="branchNumber" 
                                       placeholder="Ex: 654654" 
                                       autocomplete="off">
                                <small class="text-muted">Se preenchido, aparecerá antes do texto</small>
                            </div>
                            
                            <div class="mb-4">
                                <label for="inputText" class="form-label fw-bold">Digite o texto:</label>
                                <input type="text" class="form-control form-control-lg" id="inputText" 
                                       placeholder="Ex: marcelo takashi okada 27 anos" 
                                       autocomplete="off">
                                <small class="text-muted">Os espaços serão substituídos por hífens automaticamente</small>
                            </div>
                            
                            <div class="mb-3">
                                <label for="outputText" class="form-label fw-bold">Resultado:</label>
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-lg" id="outputText" 
                                           readonly 
                                           placeholder="saas-feature/654654-marcelo-takashi-okada-27-anos">
                                    <button class="btn btn-primary" type="button" id="copyBtn" disabled>
                                        <i class="bi bi-clipboard"></i> Copiar
                                    </button>
                                </div>
                            </div>
                            
                            <div id="copyAlert" class="alert alert-success d-none" role="alert">
                                <i class="bi bi-check-circle-fill"></i> Texto copiado com sucesso!
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-body">
                            <h6 class="card-title"><i class="bi bi-info-circle"></i> Como funciona:</h6>
                            <ul class="mb-0">
                                <li>Selecione o tipo de branch (saas-feature ou saas-fix)</li>
                                <li>Digite o número (opcional)</li>
                                <li>Digite qualquer texto no campo</li>
                                <li>Os espaços serão automaticamente substituídos por hífens (-)</li>
                                <li>O texto será convertido para minúsculas</li>
                                <li>Com número: tipo/numero-texto-com-hifen</li>
                                <li>Sem número: tipo/texto-com-hifen</li>
                                <li>Clique no botão "Copiar" para copiar o resultado</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>

<script>
$(document).ready(function() {
    const branchType = $('#branchType');
    const branchNumber = $('#branchNumber');
    const inputText = $('#inputText');
    const outputText = $('#outputText');
    const copyBtn = $('#copyBtn');
    const copyAlert = $('#copyAlert');
    
    function updateOutput() {
        const value = inputText.val();
        
        if (value.trim() === '') {
            outputText.val('');
            copyBtn.prop('disabled', true);
            return;
        }
        
        const converted = value
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-');
        
        const prefix = branchType.val();
        const number = branchNumber.val().trim();
        
        let result = prefix + '/';
        
        if (number !== '') {
            result += number + '-';
        }
        
        result += converted;
        
        outputText.val(result);
        copyBtn.prop('disabled', false);
    }
    
    inputText.on('input', updateOutput);
    branchType.on('change', updateOutput);
    branchNumber.on('input', updateOutput);
    
    copyBtn.on('click', function() {
        const textToCopy = outputText.val();
        
        if (textToCopy) {
            navigator.clipboard.writeText(textToCopy).then(function() {
                copyAlert.removeClass('d-none').addClass('show');
                
                setTimeout(function() {
                    copyAlert.removeClass('show').addClass('d-none');
                }, 3000);
            }).catch(function(err) {
                alert('Erro ao copiar: ' + err);
            });
        }
    });
    
    inputText.on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            if (outputText.val()) {
                copyBtn.click();
            }
        }
    });
    
    branchNumber.on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            inputText.focus();
        }
    });
    
    inputText.focus();
});
</script>

