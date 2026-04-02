<?php
require_once __DIR__ . '/../config.php';

// Inicializar banco se não existir
if (!file_exists(DB_PATH)) {
    require_once BASE_PATH . '/database/migrate.php';
}

// Router simples
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = rtrim($uri, '/') ?: '/';
$method = $_SERVER['REQUEST_METHOD'];

// Rotas públicas
$routes = [
    // Frontend público
    'GET /'                         => 'PublicController@home',
    'GET /cupons'                   => 'PublicController@coupons',
    'GET /cupom/{slug}'             => 'PublicController@couponDetail',
    'GET /produto/{slug}'           => 'PublicController@productPage',
    'GET /categoria/{slug}'         => 'PublicController@category',
    'GET /redirect/{id}'            => 'PublicController@redirect',
    'GET /busca'                    => 'PublicController@search',

    // Auth
    'GET /admin/login'              => 'AuthController@loginForm',
    'POST /admin/login'             => 'AuthController@login',
    'GET /admin/logout'             => 'AuthController@logout',

    // Admin Dashboard
    'GET /admin'                    => 'AdminController@dashboard',

    // Admin Cupons
    'GET /admin/cupons'             => 'CouponController@index',
    'GET /admin/cupons/criar'       => 'CouponController@create',
    'POST /admin/cupons/criar'      => 'CouponController@store',
    'GET /admin/cupons/editar/{id}' => 'CouponController@edit',
    'POST /admin/cupons/editar/{id}'=> 'CouponController@update',
    'POST /admin/cupons/excluir/{id}' => 'CouponController@delete',

    // Admin Páginas de Produto
    'GET /admin/produtos'           => 'ProductController@index',
    'GET /admin/produtos/criar'     => 'ProductController@create',
    'POST /admin/produtos/criar'    => 'ProductController@store',
    'GET /admin/produtos/editar/{id}' => 'ProductController@edit',
    'POST /admin/produtos/editar/{id}'=> 'ProductController@update',
    'POST /admin/produtos/excluir/{id}' => 'ProductController@delete',

    // Admin Categorias
    'GET /admin/categorias'             => 'CategoryController@index',
    'POST /admin/categorias/criar'      => 'CategoryController@store',
    'GET /admin/categorias/editar/{id}' => 'CategoryController@edit',
    'POST /admin/categorias/editar/{id}'=> 'CategoryController@update',
    'POST /admin/categorias/excluir/{id}' => 'CategoryController@delete',

    // Admin Configurações
    'GET /admin/configuracoes'      => 'SettingsController@index',
    'POST /admin/configuracoes'     => 'SettingsController@update',
    'GET /admin/configuracoes/amazon' => 'SettingsController@amazon',
    'POST /admin/configuracoes/amazon' => 'SettingsController@amazonUpdate',
    'POST /admin/configuracoes/amazon/testar' => 'SettingsController@amazonTest',
];

// Encontrar rota correspondente
$matchedRoute = null;
$params = [];

foreach ($routes as $route => $handler) {
    [$routeMethod, $routePath] = explode(' ', $route, 2);

    if ($method !== $routeMethod) continue;

    // Converter {param} em regex
    $pattern = preg_replace('/\{([a-z]+)\}/', '(?P<$1>[^/]+)', $routePath);
    $pattern = '#^' . $pattern . '$#';

    if (preg_match($pattern, $uri, $matches)) {
        $matchedRoute = $handler;
        foreach ($matches as $key => $val) {
            if (!is_int($key)) $params[$key] = $val;
        }
        break;
    }
}

if ($matchedRoute) {
    [$controller, $action] = explode('@', $matchedRoute);
    require_once BASE_PATH . "/src/Controllers/{$controller}.php";
    $ctrl = new $controller();
    $ctrl->$action(...array_values($params));
} else {
    http_response_code(404);
    include BASE_PATH . '/templates/public/404.php';
}
