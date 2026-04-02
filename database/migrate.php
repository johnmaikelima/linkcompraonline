<?php
require_once __DIR__ . '/../config.php';

$db = get_db();

// Tabela de usuários
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'admin',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Tabela de categorias
$db->exec("CREATE TABLE IF NOT EXISTS categories (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    icon TEXT DEFAULT 'tag',
    color TEXT DEFAULT '#6366f1',
    description TEXT DEFAULT '',
    article TEXT DEFAULT '',
    active INTEGER DEFAULT 1,
    sort_order INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Migrar colunas novas se tabela já existe
try {
    $db->exec("ALTER TABLE categories ADD COLUMN description TEXT DEFAULT ''");
} catch (\Exception $e) {}
try {
    $db->exec("ALTER TABLE categories ADD COLUMN article TEXT DEFAULT ''");
} catch (\Exception $e) {}

// Migrar colunas de loja em product_pages
try { $db->exec("ALTER TABLE product_pages ADD COLUMN store_name TEXT DEFAULT ''"); } catch (\Exception $e) {}
try { $db->exec("ALTER TABLE product_pages ADD COLUMN store_url TEXT DEFAULT ''"); } catch (\Exception $e) {}
try { $db->exec("ALTER TABLE product_pages ADD COLUMN buy_url TEXT DEFAULT ''"); } catch (\Exception $e) {}

// Tabela de cupons
$db->exec("CREATE TABLE IF NOT EXISTS coupons (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    code TEXT,
    discount_type TEXT DEFAULT 'percentage',
    discount_value TEXT,
    store_name TEXT,
    store_logo TEXT,
    image TEXT,
    affiliate_url TEXT,
    amazon_asin TEXT,
    category_id INTEGER,
    expiry_date DATE,
    is_featured INTEGER DEFAULT 0,
    is_verified INTEGER DEFAULT 0,
    active INTEGER DEFAULT 1,
    clicks INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
)");

// Tabela de páginas de produto
$db->exec("CREATE TABLE IF NOT EXISTS product_pages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    slug TEXT NOT NULL UNIQUE,
    description TEXT,
    content TEXT,
    image TEXT,
    price TEXT,
    original_price TEXT,
    store_name TEXT DEFAULT '',
    store_url TEXT DEFAULT '',
    buy_url TEXT DEFAULT '',
    amazon_url TEXT,
    amazon_asin TEXT,
    rating REAL DEFAULT 0,
    pros TEXT,
    cons TEXT,
    category_id INTEGER,
    seo_title TEXT,
    seo_description TEXT,
    active INTEGER DEFAULT 1,
    views INTEGER DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL
)");

// Tabela de configurações
$db->exec("CREATE TABLE IF NOT EXISTS settings (
    key TEXT PRIMARY KEY,
    value TEXT DEFAULT ''
)");

// Inserir configurações padrão
$defaults = [
    'site_name' => 'LinkCom - Cupons de Desconto',
    'site_description' => 'Os melhores cupons de desconto e ofertas da internet',
    'site_keywords' => 'cupons, desconto, ofertas, promoções, amazon',
    'amazon_access_key' => '',
    'amazon_secret_key' => '',
    'amazon_partner_tag' => '',
    'amazon_region' => 'BR',
    'amazon_api_enabled' => '0',
    'primary_color' => '#6366f1',
    'hero_title' => 'Encontre os Melhores Cupons de Desconto',
    'hero_subtitle' => 'Economize em suas compras com nossos cupons exclusivos e ofertas imperdíveis',
    'footer_text' => '© 2026 LinkCom. Todos os direitos reservados.',
    'analytics_code' => '',
];

$stmt = $db->prepare('INSERT OR IGNORE INTO settings (key, value) VALUES (:key, :value)');
foreach ($defaults as $key => $value) {
    $stmt->execute([':key' => $key, ':value' => $value]);
}

// Criar usuário admin padrão
$adminExists = $db->query("SELECT COUNT(*) FROM users")->fetchColumn();
if ($adminExists == 0) {
    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'admin')");
    $stmt->execute([
        ':name' => 'Administrador',
        ':email' => 'admin@linkcom.com',
        ':password' => password_hash('admin123', PASSWORD_DEFAULT),
    ]);
    echo "Usuário admin criado: admin@linkcom.com / admin123\n";
}

// Inserir categorias padrão
$catExists = $db->query("SELECT COUNT(*) FROM categories")->fetchColumn();
if ($catExists == 0) {
    $cats = [
        ['Tecnologia', 'tecnologia', 'laptop', '#3b82f6'],
        ['Moda', 'moda', 'shirt', '#ec4899'],
        ['Casa & Cozinha', 'casa-cozinha', 'home', '#f59e0b'],
        ['Esportes', 'esportes', 'trophy', '#10b981'],
        ['Beleza', 'beleza', 'sparkles', '#8b5cf6'],
        ['Livros', 'livros', 'book-open', '#ef4444'],
        ['Games', 'games', 'gamepad-2', '#06b6d4'],
        ['Alimentação', 'alimentacao', 'utensils', '#f97316'],
    ];
    $stmt = $db->prepare("INSERT INTO categories (name, slug, icon, color, sort_order) VALUES (?, ?, ?, ?, ?)");
    foreach ($cats as $i => $cat) {
        $stmt->execute([$cat[0], $cat[1], $cat[2], $cat[3], $i]);
    }
    echo "Categorias padrão criadas.\n";
}

echo "Migração concluída com sucesso!\n";
