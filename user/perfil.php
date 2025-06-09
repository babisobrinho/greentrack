<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Perfil - GreenTrack';
$relativePath = '../';
require_once '../layouts/header.php';

$stmt = $pdo->prepare("SELECT * FROM utilizadores WHERE id = ?");
$stmt->execute([$_SESSION['utilizador_id']]);
$utilizador = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$utilizador) {
    header('Location: ../includes/logout.php');
    exit();
}

$stmt = $pdo->prepare("SELECT COUNT(*) as total_acoes, SUM(impacto) as total_impacto FROM acoes_sustentaveis WHERE utilizador_id = ?");
$stmt->execute([$_SESSION['utilizador_id']]);
$estatisticas = $stmt->fetch(PDO::FETCH_ASSOC);

function formatDate($dateString) {
    if (empty($dateString)) return 'Não disponível';
    $date = new DateTime($dateString);
    return $date->format('d/m/Y');
}

$stmt = $pdo->prepare("SELECT v.*, c.titulo, c.data_publicacao, u.nome as autor_nome 
                    FROM votos v 
                    JOIN conteudos c ON v.conteudo_id = c.id 
                    JOIN utilizadores u ON c.utilizador_id = u.id 
                    WHERE v.utilizador_id = ? 
                    ORDER BY v.data_voto DESC LIMIT 5");
$stmt->execute([$_SESSION['utilizador_id']]);
$votos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="profile-cover" style="background: linear-gradient(135deg, #2c8a5a 0%, #2ecc71 100%); height: 100px;"></div>
                <div class="card-body text-center pb-0" style="margin-top: -60px;">
                    <div class="d-inline-block border border-4 border-white rounded-circle overflow-hidden mb-3 shadow-sm">
                        <div class="bg-light d-flex align-items-center justify-content-center" style="width: 120px; height: 120px;">
                            <iconify-icon icon="solar:user-circle-bold" width="120" height="120" class="text-success"></iconify-icon>
                        </div>
                    </div>
                    <h3 class="mb-1"><?php echo htmlspecialchars($utilizador['nome']); ?></h3>
                    <p class="badge bg-primary mb-3">
                        <?php echo $utilizador['tipo'] == 'admin' ? 'Administrador' : 'Membro'; ?>
                    </p>
                    <div class="d-flex justify-content-center gap-3 mb-4">
                        <div class="text-center">
                            <div class="h4 mb-0"><?php echo $estatisticas['total_acoes'] ?? 0; ?></div>
                            <small class="text-muted">Ações</small>
                        </div>
                        <div class="text-center">
                            <div class="h4 mb-0"><?php echo number_format($estatisticas['total_impacto'] ?? 0, 2); ?> kg</div>
                            <small class="text-muted">CO₂ reduzido</small>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 pt-0">
                    <div class="d-grid gap-2">
                        <a href="editar_perfil.php" class="btn btn-outline-primary rounded-pill">
                            <iconify-icon icon="solar:pen-linear" class="me-1"></iconify-icon>
                            Editar Perfil
                        </a>
                        <button class="btn btn-outline-danger rounded-pill" onclick="confirmarExclusao()">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="me-1"></iconify-icon>
                            Excluir Conta
                        </button>
                    </div>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 mt-4">
                <div class="card-body">
                    <h5 class="card-title d-flex align-items-center mb-3">
                        <iconify-icon icon="solar:info-circle-linear" class="me-2 text-primary"></iconify-icon>
                        Detalhes
                    </h5>
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2 d-flex">
                            <iconify-icon icon="solar:letter-linear" class="me-2 text-muted"></iconify-icon>
                            <span><?php echo htmlspecialchars($utilizador['email']); ?></span>
                        </li>
                        <li class="mb-2 d-flex">
                            <iconify-icon icon="solar:calendar-linear" class="me-2 text-muted"></iconify-icon>
                            <span><?php echo formatDate($utilizador['data_nascimento']); ?></span>
                        </li>
                        <li class="mb-2 d-flex">
                            <iconify-icon icon="solar:calendar-add-linear" class="me-2 text-muted"></iconify-icon>
                            <span>Membro desde <?php echo formatDate($utilizador['data_registro']); ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        As Minhas Ações Recentes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php
                    $stmt = $pdo->prepare("SELECT * FROM acoes_sustentaveis WHERE utilizador_id = ? ORDER BY data_registro DESC LIMIT 5");
                    $stmt->execute([$_SESSION['utilizador_id']]);
                    $acoes = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    if (empty($acoes)): ?>
                        <div class="text-center p-4">
                            <iconify-icon icon="solar:leaf-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                            <p class="text-muted mb-3">Ainda não registou nenhuma ação sustentável</p>
                            <a href="registar_acao.php" class="btn btn-sm btn-primary">Registar Primeira Ação</a>
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($acoes as $acao): ?>
                                <li class="list-group-item border-0 py-3 px-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="bg-success bg-opacity-10 text-success rounded-circle p-2 d-flex align-items-center">
                                                <iconify-icon icon="solar:leaf-bold" width="20" height="20"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($acao['nome']); ?></h6>
                                                <span class="badge bg-success rounded-pill">
                                                    <?php echo $acao['impacto']; ?> kg CO₂
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                                <span class="me-2" ><?php echo formatDate($acao['data_registro']); ?></span>
                                                <iconify-icon icon="solar:tag-horizontal-bold" class="me-1"></iconify-icon>
                                                <?php echo htmlspecialchars($acao['categoria']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <div class="card-footer bg-white border-0 text-center py-3">
                            <a href="historico.php" class="text-primary text-decoration-none">
                                Ver todas as ações →
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="mb-0 d-flex align-items-center">
                        As Minhas Interações Recentes
                    </h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($votos)): ?>
                        <div class="text-center p-4">
                            <iconify-icon icon="solar:chat-round-like-broken" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                            <p class="text-muted mb-3">Ainda não interagiu com nenhum conteúdo</p>
                        </div>
                    <?php else: ?>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($votos as $voto): ?>
                                <li class="list-group-item border-0 py-3 px-4">
                                    <div class="d-flex align-items-start">
                                        <div class="flex-shrink-0 me-3">
                                            <div class="<?php echo $voto['tipo'] == 'like' ? 'bg-success bg-opacity-10 text-success' : 'bg-danger bg-opacity-10 text-danger'; ?> rounded-circle p-2 d-flex align-items-center">
                                                <iconify-icon icon="solar:<?php echo $voto['tipo'] == 'like' ? 'like-bold' : 'dislike-bold'; ?>" width="20" height="20"></iconify-icon>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="mb-0"><?php echo htmlspecialchars($voto['titulo']); ?></h6>
                                                <span class="badge bg-secondary rounded-pill">
                                                    <?php echo formatDate($voto['data_voto']); ?>
                                                </span>
                                            </div>
                                            <small class="text-muted">
                                                <iconify-icon icon="solar:user-bold" class="me-1"></iconify-icon>
                                                <span class="me-2"><?php echo htmlspecialchars($voto['autor_nome']); ?></span>
                                                <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                                <?php echo formatDate($voto['data_publicacao']); ?>
                                            </small>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarExclusao() {
    if (confirm('Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.')) {
        window.location.href = 'excluir_conta.php';
    }
}
</script>

<?php require_once '../layouts/footer.php'; ?>