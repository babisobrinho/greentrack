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

$pageTitle = 'Login - GreenTrack';
$relativePath = '';
require_once 'layouts/header.php';
?>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card border-0 shadow-lg rounded-lg">
                <div class="card-header bg-success text-white text-center py-4">
                    <h2 class="mb-0">Iniciar Sessão</h2>
                </div>
                <div class="card-body p-4 p-md-5">
                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($_GET['error']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['success_message'])): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                        </div>
                    <?php endif; ?>
                    
                    <form action="includes/processa_login.php" method="POST">
                        <input type="hidden" name="csrf_token" value="<?php echo isset($_SESSION['csrf_token']) ? $_SESSION['csrf_token'] : bin2hex(random_bytes(32)); ?>">
                        
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control form-control" id="email" name="email" required placeholder="Introduza o seu email">
                        </div>
                        
                        <div class="mb-4">
                            <label for="palavra_passe" class="form-label">Palavra-passe</label>
                            <input type="password" class="form-control form-control" id="palavra_passe" name="palavra_passe" required placeholder="Introduza a sua palavra-passe">
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="lembrar" name="lembrar">
                                <label class="form-check-label" for="lembrar">Lembrar-me</label>
                            </div>
                            <a href="#" class="text-primary">Esqueceu a palavra-passe?</a>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary">Entrar</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer bg-light text-center py-3">
                    <p class="mb-0">Não tem uma conta? 
                        <a href="registo.php" class="text-primary fw-bold">Registe-se aqui</a>
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

