<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

if (!isset($_GET['id'])) {
    header('Location: conteudos.php');
    exit();
}

$conteudoId = $_GET['id'];

$stmt = $pdo->prepare("SELECT c.*, u.nome as autor
                    FROM conteudos c 
                    JOIN utilizadores u ON c.utilizador_id = u.id 
                    WHERE c.id = ?");
$stmt->execute([$conteudoId]);
$conteudo = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$conteudo) {
    header('Location: conteudos.php');
    exit();
}

$userVote = null;
if (isset($_SESSION['utilizador_id'])) {
    $stmt = $pdo->prepare("SELECT tipo FROM votos WHERE utilizador_id = ? AND conteudo_id = ?");
    $stmt->execute([$_SESSION['utilizador_id'], $conteudoId]);
    $userVote = $stmt->fetchColumn();
}

$likes = obterContagemVotos($pdo, $conteudoId, 'like');
$dislikes = obterContagemVotos($pdo, $conteudoId, 'dislike');

$stmt = $pdo->prepare("SELECT c.id, c.titulo, c.data_publicacao 
                    FROM conteudos c 
                    WHERE c.utilizador_id = ? AND c.id != ? 
                    ORDER BY c.data_publicacao DESC 
                    LIMIT 5");
$stmt->execute([$conteudo['utilizador_id'], $conteudoId]);
$relacionados = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->query("SELECT c.id, c.titulo, c.data_publicacao 
                    FROM conteudos c 
                    ORDER BY c.data_publicacao DESC 
                    LIMIT 5");
$recentes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$pageTitle = $conteudo['titulo'] . ' - GreenTrack';
require_once '../layouts/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-lg-8">
            <article class="card shadow-sm border-0 mb-5">
                <div class="card-body p-4 p-lg-5">
                    <h1 class="card-title mb-3"><?= htmlspecialchars($conteudo['titulo']) ?></h1>
                    <div class="d-flex align-items-center mb-4">
                        <div class="flex-grow-1">
                            <h6 class="mb-0"><?= htmlspecialchars($conteudo['autor']) ?></h6>
                            <small class="text-muted">
                                <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                <?= date('d/m/Y H:i', strtotime($conteudo['data_publicacao'])) ?>
                            </small>
                        </div>
                    </div>
                    
                    <div class="content-text mb-5">
                        <?= nl2br(htmlspecialchars($conteudo['conteudo'])) ?>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center border-top border-bottom py-3 mb-4">
                        <div class="votos d-flex align-items-center">
                            <button class="btn btn-sm <?= $userVote == 'like' ? 'btn-success' : 'btn-outline-success'; ?> me-2 like-btn" 
                                data-conteudo-id="<?= $conteudo['id'] ?>">
                                <iconify-icon icon="solar:like-bold" class="me-1" width="16" height="16"></iconify-icon>
                                <span class="like-count"><?= $likes ?></span>
                            </button>
                            <button class="btn btn-sm <?= $userVote == 'dislike' ? 'btn-danger' : 'btn-outline-danger'; ?> dislike-btn" 
                                data-conteudo-id="<?= $conteudo['id'] ?>">
                                <iconify-icon icon="solar:dislike-bold" class="me-1" width="16" height="16"></iconify-icon>
                                <span class="dislike-count"><?= $dislikes ?></span>
                            </button>
                        </div>
                        
                        <div class="share-buttons">
                            <small class="text-muted me-2">Partilhar:</small>
                            <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Facebook">
                                facebook
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-secondary me-1" title="Twitter">
                                twitter
                            </a>
                            <a href="#" class="btn btn-sm btn-outline-secondary" title="LinkedIn">
                                linkedin
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px;">
                <?php if (!empty($relacionados)): ?>
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-header bg-white border-0 py-3">
                            <h5 class="mb-0">Mais de <?= htmlspecialchars($conteudo['autor']) ?></h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($recentes as $recente): ?>
                                <li class="list-group-item border-0">
                                    <a href="conteudos_ver.php?id=<?= $recente['id'] ?>" class="text-decoration-none">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span><?= htmlspecialchars($recente['titulo']) ?></span>
                                            <iconify-icon icon="solar:arrow-right-linear" class="text-muted"></iconify-icon>
                                        </div>
                                        <small class="text-muted d-block">
                                            <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                            <?= date('d/m/Y', strtotime($recente['data_publicacao'])) ?>
                                        </small>
                                    </a>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-0 py-3">
                        <h5 class="mb-0">Conteúdos recentes</h5>
                    </div>
                    <div class="card-body p-0">
                        <ul class="list-group list-group-flush">
                            <?php foreach ($relacionados as $relacionado): ?>
                            <li class="list-group-item border-0">
                                <a href="conteudos_ver.php?id=<?= $relacionado['id'] ?>" class="text-decoration-none">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span><?= htmlspecialchars($relacionado['titulo']) ?></span>
                                        <iconify-icon icon="solar:arrow-right-linear" class="text-muted"></iconify-icon>
                                    </div>
                                    <small class="text-muted d-block">
                                        <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                        <?= date('d/m/Y', strtotime($relacionado['data_publicacao'])) ?>
                                    </small>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                <div class="d-grid">
                    <a href="conteudos.php" class="btn btn-outline-primary">
                        <iconify-icon icon="solar:arrow-left-linear" class="me-1"></iconify-icon>
                        Voltar para todos os conteúdos
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.like-btn, .dislike-btn').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const conteudoId = this.dataset.conteudoId;
        const isLike = this.classList.contains('like-btn');
        
        fetch('conteudos_votar.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                conteudo_id: conteudoId,
                tipo: isLike ? 'like' : 'dislike'
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const likeBtn = document.querySelector(`.like-btn[data-conteudo-id="${conteudoId}"]`);
                const dislikeBtn = document.querySelector(`.dislike-btn[data-conteudo-id="${conteudoId}"]`);

                document.querySelector(`.like-btn[data-conteudo-id="${conteudoId}"] .like-count`).textContent = data.likes;
                document.querySelector(`.dislike-btn[data-conteudo-id="${conteudoId}"] .dislike-count`).textContent = data.dislikes;
                
                if (data.user_vote === 'like') {
                    likeBtn.classList.remove('btn-outline-success');
                    likeBtn.classList.add('btn-success');
                    dislikeBtn.classList.remove('btn-danger');
                    dislikeBtn.classList.add('btn-outline-danger');
                } else if (data.user_vote === 'dislike') {
                    likeBtn.classList.remove('btn-success');
                    likeBtn.classList.add('btn-outline-success');
                    dislikeBtn.classList.remove('btn-outline-danger');
                    dislikeBtn.classList.add('btn-danger');
                } else {
                    likeBtn.classList.remove('btn-success');
                    likeBtn.classList.add('btn-outline-success');
                    dislikeBtn.classList.remove('btn-danger');
                    dislikeBtn.classList.add('btn-outline-danger');
                }
            }
        });
    });
});
</script>

<?php require_once '../layouts/footer.php'; ?>

<?php
function obterContagemVotos($pdo, $conteudoId, $tipo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE conteudo_id = ? AND tipo = ?");
    $stmt->execute([$conteudoId, $tipo]);
    return $stmt->fetchColumn();
}
?>