<?php
require_once '../includes/auth.php';
require_once '../includes/db.php';
requireLogin();

$pageTitle = 'Histórico - GreenTrack';
require_once '../layouts/header.php';

$itensPorPagina = 10;
$paginaAtual = isset($_GET['pagina']) ? max(1, intval($_GET['pagina'])) : 1;

$filtro_categoria = $_GET['categoria'] ?? '';
$filtro_data_inicio = $_GET['data_inicio'] ?? '';
$filtro_data_fim = $_GET['data_fim'] ?? '';
$filtro_impacto_min = $_GET['impacto_min'] ?? '';
$filtro_impacto_max = $_GET['impacto_max'] ?? '';

$queryBase = "FROM acoes_sustentaveis WHERE utilizador_id = ?";
$params = [$_SESSION['utilizador_id']];

if (!empty($filtro_categoria)) {
    $queryBase .= " AND categoria = ?";
    $params[] = $filtro_categoria;
}

if (!empty($filtro_data_inicio)) {
    $queryBase .= " AND data_registro >= ?";
    $params[] = $filtro_data_inicio;
}

if (!empty($filtro_data_fim)) {
    $queryBase .= " AND data_registro <= ?";
    $params[] = $filtro_data_fim;
}

if (!empty($filtro_impacto_min)) {
    $queryBase .= " AND impacto >= ?";
    $params[] = $filtro_impacto_min;
}

if (!empty($filtro_impacto_max)) {
    $queryBase .= " AND impacto <= ?";
    $params[] = $filtro_impacto_max;
}

$stmtTotal = $pdo->prepare("SELECT COUNT(*) " . $queryBase);
$stmtTotal->execute($params);
$totalRegistros = $stmtTotal->fetchColumn();

$totalPaginas = ceil($totalRegistros / $itensPorPagina);

if ($paginaAtual > $totalPaginas && $totalPaginas > 0) {
    $paginaAtual = $totalPaginas;
}

$offset = ($paginaAtual - 1) * $itensPorPagina;

$namedParams = [];
$queryBaseNamed = "FROM acoes_sustentaveis WHERE utilizador_id = :utilizador_id";
$namedParams[':utilizador_id'] = $_SESSION['utilizador_id'];

if (!empty($filtro_categoria)) {
    $queryBaseNamed .= " AND categoria = :categoria";
    $namedParams[':categoria'] = $filtro_categoria;
}

if (!empty($filtro_data_inicio)) {
    $queryBaseNamed .= " AND data_registro >= :data_inicio";
    $namedParams[':data_inicio'] = $filtro_data_inicio;
}

if (!empty($filtro_data_fim)) {
    $queryBaseNamed .= " AND data_registro <= :data_fim";
    $namedParams[':data_fim'] = $filtro_data_fim;
}

if (!empty($filtro_impacto_min)) {
    $queryBaseNamed .= " AND impacto >= :impacto_min";
    $namedParams[':impacto_min'] = $filtro_impacto_min;
}

if (!empty($filtro_impacto_max)) {
    $queryBaseNamed .= " AND impacto <= :impacto_max";
    $namedParams[':impacto_max'] = $filtro_impacto_max;
}

$queryDados = "SELECT * " . $queryBaseNamed . " ORDER BY data_registro DESC LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($queryDados);

$namedParams[':limit'] = $itensPorPagina;
$namedParams[':offset'] = $offset;

foreach ($namedParams as $key => $value) {
    $stmt->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
}

$stmt->execute();
$acoes = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtTotal = $pdo->prepare("SELECT COUNT(*) " . $queryBaseNamed);
foreach ($namedParams as $key => $value) {
    if ($key !== ':limit' && $key !== ':offset') {
        $stmtTotal->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
    }
}
$stmtTotal->execute();
$totalRegistros = $stmtTotal->fetchColumn();

$categorias = $pdo->query("SELECT DISTINCT categoria FROM acoes_sustentaveis WHERE utilizador_id = {$_SESSION['utilizador_id']} ORDER BY categoria")->fetchAll(PDO::FETCH_COLUMN);

$total_acoes = $totalRegistros;
$stmtImpacto = $pdo->prepare("SELECT SUM(impacto) " . $queryBase);
$stmtImpacto->execute($params);
$total_impacto = $stmtImpacto->fetchColumn() ?? 0;
$media_impacto = $total_acoes > 0 ? $total_impacto / $total_acoes : 0;
?>

<div class="container py-5">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="mb-0">Histórico de Ações</h1>
                <a href="acoes_criar.php" class="btn btn-primary">
                    Nova Ação
                </a>
            </div>
            <p class="text-muted mb-0">Visualize e filtre todas as suas ações sustentáveis</p>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card border-start-lg border-primary shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Total de Ações</h6>
                            <h2 class="mb-0"><?php echo $total_acoes; ?></h2>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:checklist-minimalistic-bold" width="24" height="24" class="text-primary"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-start-lg border-success shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Impacto Total</h6>
                            <h2 class="mb-0"><?php echo number_format($total_impacto, 2); ?> <small class="text-muted">kg CO₂</small></h2>
                        </div>
                        <div class="bg-success bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:leaf-bold" width="24" height="24" class="text-success"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card border-start-lg border-info shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="text-uppercase text-muted mb-2">Impacto Médio</h6>
                            <h2 class="mb-0"><?php echo number_format($media_impacto, 2); ?> <small class="text-muted">kg CO₂</small></h2>
                        </div>
                        <div class="bg-info bg-opacity-10 p-3 rounded">
                            <iconify-icon icon="solar:chart-linear" width="24" height="24" class="text-info"></iconify-icon>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0">Filtrar Ações</h5>
        </div>
        <div class="card-body">
            <form method="get" class="row g-3">
                <div class="col-md-3">
                    <label for="categoria" class="form-label">Categoria</label>
                    <select id="categoria" name="categoria" class="form-select">
                        <option value="">Todas</option>
                        <?php foreach ($categorias as $cat): ?>
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo $filtro_categoria === $cat ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($cat); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="data_inicio" class="form-label">Data Inicial</label>
                    <input type="date" id="data_inicio" name="data_inicio" class="form-control" value="<?php echo htmlspecialchars($filtro_data_inicio); ?>">
                </div>
                <div class="col-md-3">
                    <label for="data_fim" class="form-label">Data Final</label>
                    <input type="date" id="data_fim" name="data_fim" class="form-control" value="<?php echo htmlspecialchars($filtro_data_fim); ?>">
                </div>
                <div class="col-md-3">
                    <label for="impacto_min" class="form-label">Impacto Mínimo (kg)</label>
                    <input type="number" step="0.01" id="impacto_min" name="impacto_min" class="form-control" placeholder="Mínimo" value="<?php echo htmlspecialchars($filtro_impacto_min); ?>">
                </div>
                <div class="col-md-3">
                    <label for="impacto_max" class="form-label">Impacto Máximo (kg)</label>
                    <input type="number" step="0.01" id="impacto_max" name="impacto_max" class="form-control" placeholder="Máximo" value="<?php echo htmlspecialchars($filtro_impacto_max); ?>">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary me-2">
                        <iconify-icon icon="solar:magnifer-linear" class="me-1"></iconify-icon>
                        Aplicar Filtros
                    </button>
                    <a href="historico.php" class="btn btn-outline-secondary">
                        <iconify-icon icon="solar:restart-linear" class="me-1"></iconify-icon>
                        Limpar Filtros
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Todas as Ações</h5>
            <div class="text-muted small">
                <?php echo $total_acoes; ?> ação(ões) encontrada(s)
            </div>
        </div>
        <div class="card-body p-0">
            <?php if (empty($acoes)): ?>
                <div class="text-center p-5">
                    <iconify-icon icon="solar:leaf-linear" width="48" height="48" class="text-muted mb-3"></iconify-icon>
                    <p class="text-muted mb-3">Nenhuma ação encontrada com os filtros aplicados</p>
                    <a href="acoes_criar.php" class="btn btn-primary">
                        Registar Nova Ação
                    </a>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Ação</th>
                                <th class="text-end">Impacto (kg CO₂)</th>
                                <th>Categoria</th>
                                <th class="text-end">Data</th>
                                <th class="text-end"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($acoes as $acao): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 p-2 rounded me-3">
                                                <iconify-icon icon="solar:leaf-bold" width="20" height="20" class="text-success"></iconify-icon>
                                            </div>
                                            <div><?php echo htmlspecialchars($acao['nome']); ?></div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <span class="badge bg-success rounded-pill">
                                            <?php echo number_format($acao['impacto'], 2); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?php echo htmlspecialchars($acao['categoria']); ?>
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <small class="text-muted">
                                            <?php echo date('d/m/Y', strtotime($acao['data_registro'])); ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-end gap-2">
                                            <a href="acoes_editar.php?id=<?= $acao['id'] ?>" class="text-decoration-none">
                                                <iconify-icon icon="solar:document-add-bold-duotone" width="24"></iconify-icon>
                                            </a>
                                            <a class="text-decoration-none text-danger delete-action-btn" style="cursor: pointer;"
                                                data-id="<?= $acao['id'] ?>" 
                                                data-name="<?= htmlspecialchars($acao['nome']) ?>">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-bold-duotone" width="24"></iconify-icon>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-white border-top py-3">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mb-0">
                            <?php if ($paginaAtual > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaAtual - 1])); ?>" aria-label="Anterior">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php
                            $inicio = max(1, $paginaAtual - 2);
                            $fim = min($totalPaginas, $paginaAtual + 2);
                            
                            if ($inicio > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['pagina' => 1])) . '">1</a></li>';
                                if ($inicio > 2) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                            }
                            
                            for ($i = $inicio; $i <= $fim; $i++): ?>
                                <li class="page-item <?php echo $i == $paginaAtual ? 'active' : ''; ?>">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $i])); ?>">
                                        <?php echo $i; ?>
                                    </a>
                                </li>
                            <?php endfor;
                            
                            if ($fim < $totalPaginas) {
                                if ($fim < $totalPaginas - 1) {
                                    echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                                }
                                echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($_GET, ['pagina' => $totalPaginas])) . '">' . $totalPaginas . '</a></li>';
                            }
                            ?>

                            <?php if ($paginaAtual < $totalPaginas): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['pagina' => $paginaAtual + 1])); ?>" aria-label="Próxima">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php else: ?>
                                <li class="page-item disabled">
                                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                    
                    <div class="text-center text-muted small mt-2">
                        A exibir <?php echo count($acoes); ?> de <?php echo $totalRegistros; ?> ações
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmDeleteActionModal" tabindex="-1" aria-labelledby="confirmDeleteActionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteActionModalLabel">Confirmar Eliminação</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Tem certeza que deseja eliminar a ação "<strong id="actionNameToDelete"></strong>"?</p>
                <p class="text-danger">Esta ação não pode ser desfeita!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <a href="#" id="confirmDeleteActionBtn" class="btn btn-danger">Eliminar</a>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteActionButtons = document.querySelectorAll('.delete-action-btn');
    const confirmDeleteActionModal = new bootstrap.Modal(document.getElementById('confirmDeleteActionModal'));
    const actionNameToDelete = document.getElementById('actionNameToDelete');
    const confirmDeleteActionBtn = document.getElementById('confirmDeleteActionBtn');
    
    deleteActionButtons.forEach(button => {
        button.addEventListener('click', function() {
            const actionId = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            actionNameToDelete.textContent = name;
            confirmDeleteActionBtn.onclick = function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `acoes_eliminar.php?id=${actionId}`;
                
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'confirmar';
                input.value = '1';
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            };
            
            confirmDeleteActionModal.show();
        });
    });
});
</script>

<?php require_once '../layouts/footer.php'; ?>