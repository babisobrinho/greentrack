<?php
require_once 'includes/auth.php';
require_once 'includes/functions.php';

// Redireciona se já estiver logado
if (isset($_SESSION['utilizador_id'])) {
    if ($_SESSION['tipo'] == 'admin') {
        header('Location: admin/dashboard.php');
    } else {
        header('Location: user/dashboard.php');
    }
    exit();
}

$pageTitle = 'Registo - GreenTrack';
$relativePath = '';
require_once 'layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="mb-0">Criar Conta</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="includes/processa_registo.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : bin2hex(random_bytes(32)); ?>">
                        
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="nome" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control form-control" id="nome" name="nome" required
                                       placeholder="Introduza o seu nome completo"
                                       value="<?php echo isset($_POST['nome']) ? htmlspecialchars($_POST['nome']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                                <input type="date" class="form-control form-control" id="data_nascimento" name="data_nascimento" required
                                       value="<?php echo isset($_POST['data_nascimento']) ? htmlspecialchars($_POST['data_nascimento']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control form-control" id="email" name="email" required
                                       placeholder="Introduza o seu email"
                                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="palavra_passe" class="form-label">Palavra-passe</label>
                                <input type="password" class="form-control form-control" id="palavra_passe" name="palavra_passe" 
                                       minlength="8" required placeholder="Mínimo 8 caracteres">
                            </div>
                            
                            <div class="col-md-6">
                                <label for="confirmar_palavra_passe" class="form-label">Confirmar Palavra-passe</label>
                                <input type="password" class="form-control form-control" id="confirmar_palavra_passe" 
                                       name="confirmar_palavra_passe" required placeholder="Confirme a sua palavra-passe">
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="termos" name="termos" required>
                                    <label class="form-check-label" for="termos">
                                        Concordo com os <a href="#" class="text-primary">Termos de Serviço</a> e <a href="#" class="text-primary">Política de Privacidade</a>
                                    </label>
                                </div>
                            </div>
                            
                            <div class="col-12 mt-4">
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Criar Conta</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">Já tem uma conta? 
                        <a href="login.php" class="text-primary fw-bold">Inicie sessão aqui</a>
                    </p>
                </div>
            </div>
            
            <div class="text-center mt-4">
                <a href="index.php" class="text-muted">Voltar à página inicial</a>
            </div>
        </div>
    </div>
</div>

<?php require_once 'layouts/footer.php'; ?>

