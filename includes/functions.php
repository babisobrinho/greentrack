<?php
function formatarData($date, $includeTime = false) {
    if (empty($date)) return '';
    $format = $includeTime ? 'd/m/Y H:i' : 'd/m/Y';
    $dateObj = new DateTime($date);
    return $dateObj->format($format);
}

function limitarTexto($text, $limit = 100, $end = '...') {
    if (strlen($text) <= $limit) return $text;
    return substr($text, 0, $limit) . $end;
}

function sanitizarHTML($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function redirecionarComMensagem($url, $mensagem, $tipo = 'success') {
    if ($tipo == 'success') {
        $_SESSION['success_message'] = $mensagem;
    } else {
        $_SESSION['error_message'] = $mensagem;
    }
    header("Location: $url");
    exit;
}

function tempoDecorrido($date) {
    $now = new DateTime();
    $past = new DateTime($date);
    $diff = $now->diff($past);
    
    if ($diff->y > 0) {
        return $diff->y == 1 ? "há 1 ano" : "há " . $diff->y . " anos";
    }
    
    if ($diff->m > 0) {
        return $diff->m == 1 ? "há 1 mês" : "há " . $diff->m . " meses";
    }
    
    if ($diff->d > 0) {
        return $diff->d == 1 ? "há 1 dia" : "há " . $diff->d . " dias";
    }
    
    if ($diff->h > 0) {
        return $diff->h == 1 ? "há 1 hora" : "há " . $diff->h . " horas";
    }
    
    if ($diff->i > 0) {
        return $diff->i == 1 ? "há 1 minuto" : "há " . $diff->i . " minutos";
    }
    
    return "agora mesmo";
}

function formatarValor($value, $decimals = 2, $suffix = '') {
    return number_format($value, $decimals, ',', '.') . ($suffix ? " $suffix" : '');
}

