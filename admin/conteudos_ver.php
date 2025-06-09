<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

if ($_SESSION['tipo'] !== 'admin') {
    header('Location: conteudos.php');
    exit();
}

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

$likes = obterContagemVotos($pdo, $conteudoId, 'like');
$dislikes = obterContagemVotos($pdo, $conteudoId, 'dislike');

$stmt = $pdo->prepare("SELECT 
    DATE(v.data_voto) as data,
    SUM(CASE WHEN v.tipo = 'like' THEN 1 ELSE 0 END) as likes,
    SUM(CASE WHEN v.tipo = 'dislike' THEN 1 ELSE 0 END) as dislikes
    FROM votos v
    WHERE v.conteudo_id = ?
    GROUP BY DATE(v.data_voto)
    ORDER BY data ASC");
$stmt->execute([$conteudoId]);
$interacoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$chartLabels = [];
$chartLikes = [];
$chartDislikes = [];

foreach ($interacoes as $interacao) {
    $chartLabels[] = date('d/m/Y', strtotime($interacao['data']));
    $chartLikes[] = $interacao['likes'];
    $chartDislikes[] = $interacao['dislikes'];
}

$pageTitle = $conteudo['titulo'] . ' - Admin - GreenTrack';
require_once '../layouts/header.php';
?>

<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0"><?= htmlspecialchars($conteudo['titulo']) ?></h1>
                <?php if ($conteudo['utilizador_id'] == $_SESSION['utilizador_id']): ?>
                    <div>
                        <a href="conteudos_editar.php?id=<?= $conteudo['id'] ?>" class="btn btn-primary me-2">
                            <iconify-icon icon="solar:pen-bold" class="me-1"></iconify-icon>
                            Editar
                        </a>
                        <button class="btn btn-danger delete-btn" 
                                data-id="<?= $conteudo['id'] ?>" 
                                data-name="<?= htmlspecialchars($conteudo['titulo']) ?>">
                            <iconify-icon icon="solar:trash-bin-minimalistic-bold" class="me-1"></iconify-icon>
                            Apagar
                        </button>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h6 class="mb-0"><?= htmlspecialchars($conteudo['autor']) ?></h6>
                            <small class="text-muted">
                                <iconify-icon icon="solar:calendar-linear" class="me-1"></iconify-icon>
                                <?= date('d/m/Y H:i', strtotime($conteudo['data_publicacao'])) ?>
                            </small>
                        </div>
                        <div class="d-flex gap-3">
                            <span class="badge bg-success bg-opacity-10 text-success">
                                <iconify-icon icon="solar:like-bold" class="me-1"></iconify-icon>
                                <?= $likes ?> likes
                            </span>
                            <span class="badge bg-danger bg-opacity-10 text-danger">
                                <iconify-icon icon="solar:dislike-bold" class="me-1"></iconify-icon>
                                <?= $dislikes ?> dislikes
                            </span>
                        </div>
                    </div>
                    <div class="content-text mb-4">
                        <?= nl2br(htmlspecialchars($conteudo['conteudo'])) ?>
                    </div>
                </div>
            </div>
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Interações ao longo do tempo</h5>
                </div>
                <div class="card-body">
                    <?php if($interacoes): ?>
                        <canvas id="interactionsChart" height="80"></canvas>
                    <?php else: ?>
                        <div class="text-center p-5">
                        <iconify-icon icon="solar:chat-round-like-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                        <p class="text-muted mb-3">Este artigo não possui interações</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="d-grid">
        <a href="conteudos.php" class="btn btn-outline-secondary">
            <iconify-icon icon="solar:arrow-left-linear" class="me-1"></iconify-icon>
            Voltar para a gestão de conteúdos
        </a>
    </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmar Exclusão</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja excluir o conteúdo <strong id="contentNameToDelete"></strong>?</p>
                <p class="text-danger">Esta ação não pode ser desfeita!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteBtn" class="btn btn-danger">Excluir</a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('interactionsChart')?.getContext('2d');
    if (ctx) {
        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($chartLabels) ?>,
                datasets: [
                    {
                        label: 'Likes',
                        data: <?= json_encode($chartLikes) ?>,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Dislikes',
                        data: <?= json_encode($chartDislikes) ?>,
                        borderColor: '#dc3545',
                        backgroundColor: 'rgba(220, 53, 69, 0.1)',
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    const deleteButtons = document.querySelectorAll('.delete-btn');
    const confirmDeleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
    const contentNameToDelete = document.getElementById('contentNameToDelete');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const contentId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            contentNameToDelete.textContent = name;
            confirmDeleteBtn.href = `conteudos_eliminar.php?id=${contentId}`;
            
            confirmDeleteModal.show();
        });
    });

    confirmDeleteBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        fetch(this.href, {
            method: 'GET'
        })
        .then(response => {
            if (response.ok) {
                window.location.href = 'conteudos.php';
            } else {
                console.error('Erro ao excluir');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
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