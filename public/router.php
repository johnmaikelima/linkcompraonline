<?php
/**
 * Router para o PHP built-in server.
 * Serve arquivos estáticos diretamente e encaminha o resto para index.php.
 */
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$file = __DIR__ . $uri;

// Se o arquivo existe e não é diretório, serve diretamente (CSS, JS, imagens)
if ($uri !== '/' && is_file($file)) {
    return false;
}

// Tudo o mais vai para index.php
require __DIR__ . '/index.php';
