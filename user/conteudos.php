<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Conteúdos - GreenTrack';
$relativePath = '../';
require_once '../layouts/header.php';

// Parâmetros de busca/filtro
$search = $_GET['search'] ?? '';
$dataFiltro = $_GET['data'] ?? '';
$pagina = max(1, $_GET['pagina'] ?? 1);
$porPagina = 6;

// Construção da query com filtros
$where = [];
$params = [];

if (!empty($search)) {
    $where[] = "(c.titulo LIKE ? OR c.conteudo LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($dataFiltro)) {
    $where[] = "DATE(c.data_publicacao) = ?";
    $params[] = $dataFiltro;
}

$whereClause = $where ? 'WHERE ' . implode(' AND ', $where) : '';

// Busca total de conteúdos para paginação
$stmt = $pdo->prepare("SELECT COUNT(*) FROM conteudos c $whereClause");
$stmt->execute($params);
$totalConteudos = $stmt->fetchColumn();
$totalPaginas = ceil($totalConteudos / $porPagina);

// Busca conteúdos com paginação
$offset = ($pagina - 1) * $porPagina;
$stmt = $pdo->prepare("SELECT c.*, u.nome as autor 
                    FROM conteudos c 
                    JOIN utilizadores u ON c.utilizador_id = u.id 
                    $whereClause 
                    ORDER BY c.data_publicacao DESC 
                    LIMIT $offset, $porPagina");
$stmt->execute($params);
$conteudos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Busca o conteúdo mais recente para destaque
$stmt = $pdo->query("SELECT c.*, u.nome as autor
                    FROM conteudos c 
                    JOIN utilizadores u ON c.utilizador_id = u.id 
                    ORDER BY c.data_publicacao DESC 
                    LIMIT 1");
$destaque = $stmt->fetch(PDO::FETCH_ASSOC);

// Busca votos do usuário atual
$votos = [];
if (isset($_SESSION['utilizador_id'])) {
    $stmt = $pdo->prepare("SELECT conteudo_id, tipo FROM votos WHERE utilizador_id = ?");
    $stmt->execute([$_SESSION['utilizador_id']]);
    $votos = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}
?>

<div class="container py-5">
    <!-- Barra de pesquisa e filtros -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <form action="" method="get" class="row g-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <iconify-icon icon="solar:magnifer-linear"></iconify-icon>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0" 
                                    placeholder="Pesquisar por título ou conteúdo..." value="<?= htmlspecialchars($search) ?>">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <input type="date" name="data" class="form-control" value="<?= htmlspecialchars($dataFiltro) ?>">
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <iconify-icon icon="solar:filter-linear" class="me-2"></iconify-icon>
                                Filtrar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php if ($destaque && $pagina == 1 && empty($search) && empty($dataFiltro)): ?>
    <!-- Destaque do conteúdo mais recente -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="row g-0">
                    <div class="col-12">
                        <div class="card-body p-4 p-lg-5 h-100 d-flex flex-column">
                            <div class="mb-3">
                                <span class="badge bg-warning bg-opacity-10 text-warning mb-2">Destaque</span>
                                <h2 class="card-title"><?= htmlspecialchars($destaque['titulo']) ?></h2>
                                <p class="text-muted small">
                                    <iconify-icon icon="solar:user-linear" class="me-1"></iconify-icon>
                                    <span class="me-2"><?= htmlspecialchars($destaque['autor']) ?></span>
                                    <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                    <?= date('d/m/Y', strtotime($destaque['data_publicacao'])) ?>
                                </p>
                            </div>
                            <p class="card-text mb-4"><?= nl2br(htmlspecialchars(substr($destaque['conteudo'], 0, 250) . (strlen($destaque['conteudo']) > 250 ? '...' : ''))) ?></p>
                            
                            <div class="mt-auto d-flex justify-content-between align-items-center">
                                <a href="conteudos_ver.php?id=<?= $destaque['id'] ?>" class="btn btn-primary">
                                    Ler artigo completo
                                </a>
                                
                                <div class="votos d-flex align-items-center">
                                    <button class="btn btn-sm <?= ($votos[$destaque['id']] ?? null) == 'like' ? 'btn-primary' : 'btn-outline-primary'; ?> me-2 like-btn" 
                                        data-conteudo-id="<?= $destaque['id'] ?>">
                                        <iconify-icon icon="solar:like-bold" class="me-1" width="16" height="16"></iconify-icon>
                                        <span class="like-count"><?= obterContagemVotos($pdo, $destaque['id'], 'like') ?></span>
                                    </button>
                                    <button class="btn btn-sm <?= ($votos[$destaque['id']] ?? null) == 'dislike' ? 'btn-danger' : 'btn-outline-danger'; ?> dislike-btn" 
                                        data-conteudo-id="<?= $destaque['id'] ?>">
                                        <iconify-icon icon="solar:dislike-bold" class="me-1" width="16" height="16"></iconify-icon>
                                        <span class="dislike-count"><?= obterContagemVotos($pdo, $destaque['id'], 'dislike') ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Lista de conteúdos -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="h3 mb-0"><?= empty($search) && empty($dataFiltro) ? 'Todos os Conteúdos' : 'Resultados da Pesquisa' ?></h2>
            </div>
        </div>
        
        <?php if (empty($conteudos)): ?>
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <iconify-icon icon="solar:documents-minimalistic-linear" width="64" height="64" class="text-muted mb-3"></iconify-icon>
                    <h3 class="h5">Nenhum conteúdo encontrado</h3>
                    <p class="text-muted mb-0">Não encontramos nenhum conteúdo com os critérios selecionados.</p>
                    <a href="conteudos.php" class="btn btn-outline-primary mt-3">Limpar filtros</a>
                </div>
            </div>
        </div>
        <?php else: ?>
            <?php foreach ($conteudos as $conteudo): 
                $userVote = $votos[$conteudo['id']] ?? null;
            ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow rounded-lg overflow-hidden">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($conteudo['titulo']) ?></h5>
                            <p class="card-text text-muted small mb-3">
                                <iconify-icon icon="solar:user-linear" class="me-1"></iconify-icon>
                                <span class="me-2"><?= htmlspecialchars($conteudo['autor']) ?></span>
                                <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                <?= date('d/m/Y', strtotime($conteudo['data_publicacao'])) ?>
                            </p>
                            <p class="card-text mb-4"><?= nl2br(htmlspecialchars(substr($conteudo['conteudo'], 0, 120) . (strlen($conteudo['conteudo']) > 120 ? '...' : ''))) ?></p>
                            
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="conteudos_ver.php?id=<?= $conteudo['id'] ?>" class="btn btn-sm btn-outline-primary">
                                    <iconify-icon icon="solar:document-text-linear" class="me-1" width="16" height="16"></iconify-icon>
                                    Ler mais
                                </a>
                                
                                <div class="votos d-flex align-items-center">
                                    <button class="btn btn-sm <?= $userVote == 'like' ? 'btn-primary' : 'btn-outline-primary'; ?> me-2 like-btn" 
                                        data-conteudo-id="<?= $conteudo['id'] ?>">
                                        <iconify-icon icon="solar:like-bold" class="me-1" width="16" height="16"></iconify-icon>
                                        <span class="like-count"><?= obterContagemVotos($pdo, $conteudo['id'], 'like') ?></span>
                                    </button>
                                    <button class="btn btn-sm <?= $userVote == 'dislike' ? 'btn-danger' : 'btn-outline-danger'; ?> dislike-btn" 
                                        data-conteudo-id="<?= $conteudo['id'] ?>">
                                        <iconify-icon icon="solar:dislike-bold" class="me-1" width="16" height="16"></iconify-icon>
                                        <span class="dislike-count"><?= obterContagemVotos($pdo, $conteudo['id'], 'dislike') ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <!-- Paginação -->
    <?php if ($totalPaginas > 1): ?>
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <?php if ($pagina > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina - 1])) ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                    <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $i])) ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <?php if ($pagina < $totalPaginas): ?>
                    <li class="page-item">
                        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['pagina' => $pagina + 1])) ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Script para lidar com os votos (mesmo do original)
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
                // Atualiza a UI
                const likeBtn = document.querySelector(`.like-btn[data-conteudo-id="${conteudoId}"]`);
                const dislikeBtn = document.querySelector(`.dislike-btn[data-conteudo-id="${conteudoId}"]`);
                
                // Atualiza contagens
                document.querySelector(`.like-btn[data-conteudo-id="${conteudoId}"] .like-count`).textContent = data.likes;
                document.querySelector(`.dislike-btn[data-conteudo-id="${conteudoId}"] .dislike-count`).textContent = data.dislikes;
                
                // Atualiza estilos dos botões
                if (data.user_vote === 'like') {
                    likeBtn.classList.remove('btn-outline-primary');
                    likeBtn.classList.add('btn-primary');
                    dislikeBtn.classList.remove('btn-danger');
                    dislikeBtn.classList.add('btn-outline-danger');
                } else if (data.user_vote === 'dislike') {
                    likeBtn.classList.remove('btn-primary');
                    likeBtn.classList.add('btn-outline-primary');
                    dislikeBtn.classList.remove('btn-outline-danger');
                    dislikeBtn.classList.add('btn-danger');
                } else {
                    likeBtn.classList.remove('btn-primary');
                    likeBtn.classList.add('btn-outline-primary');
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
// Função auxiliar para obter contagem de votos
function obterContagemVotos($pdo, $conteudoId, $tipo) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM votos WHERE conteudo_id = ? AND tipo = ?");
    $stmt->execute([$conteudoId, $tipo]);
    return $stmt->fetchColumn();
}
?>