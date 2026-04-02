<?php
require_once BASE_PATH . '/config.php';

class PublicController {

    public function home(): void {
        $db = get_db();
        $featured = $db->query("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.active = 1 AND c.is_featured = 1 ORDER BY c.created_at DESC LIMIT 6")->fetchAll();
        $latest = $db->query("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.active = 1 ORDER BY c.created_at DESC LIMIT 12")->fetchAll();
        $categories = $db->query("SELECT c.*, (SELECT COUNT(*) FROM coupons WHERE category_id = c.id AND active = 1) as coupon_count FROM categories c WHERE c.active = 1 ORDER BY c.sort_order, c.name")->fetchAll();
        $products = $db->query("SELECT p.*, cat.name as category_name FROM product_pages p LEFT JOIN categories cat ON p.category_id = cat.id WHERE p.active = 1 ORDER BY p.created_at DESC LIMIT 4")->fetchAll();

        $contentTemplate = BASE_PATH . '/templates/public/home_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }

    public function coupons(): void {
        $db = get_db();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 12;
        $offset = ($page - 1) * $perPage;
        $categoryFilter = $_GET['categoria'] ?? '';

        $where = "WHERE c.active = 1";
        $params = [];
        if ($categoryFilter) { $where .= " AND cat.slug = :cat_slug"; $params[':cat_slug'] = $categoryFilter; }

        $stmt = $db->prepare("SELECT c.*, cat.name as category_name, cat.slug as category_slug FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id {$where} ORDER BY c.is_featured DESC, c.created_at DESC LIMIT :limit OFFSET :offset");
        foreach ($params as $k => $v) $stmt->bindValue($k, $v);
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $coupons = $stmt->fetchAll();

        $countStmt = $db->prepare("SELECT COUNT(*) FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id {$where}");
        foreach ($params as $k => $v) $countStmt->bindValue($k, $v);
        $countStmt->execute();
        $total = $countStmt->fetchColumn();
        $totalPages = ceil($total / $perPage);

        $categories = $db->query("SELECT * FROM categories WHERE active = 1 ORDER BY name")->fetchAll();

        $pageTitle = 'Todos os Cupons - LinkCom';
        $contentTemplate = BASE_PATH . '/templates/public/coupons_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }

    public function couponDetail(string $slug): void {
        $db = get_db();
        $stmt = $db->prepare("SELECT c.*, cat.name as category_name, cat.slug as category_slug FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.slug = :slug AND c.active = 1");
        $stmt->execute([':slug' => $slug]);
        $coupon = $stmt->fetch();

        if (!$coupon) { http_response_code(404); include BASE_PATH . '/templates/public/404.php'; return; }

        $related = $db->prepare("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.active = 1 AND c.id != :id AND c.category_id = :cat_id ORDER BY RANDOM() LIMIT 4");
        $related->execute([':id' => $coupon['id'], ':cat_id' => $coupon['category_id']]);
        $relatedCoupons = $related->fetchAll();

        $pageTitle = $coupon['title'] . ' - LinkCom';
        $contentTemplate = BASE_PATH . '/templates/public/coupon_detail_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }

    public function productPage(string $slug): void {
        $db = get_db();
        $stmt = $db->prepare("SELECT p.*, cat.name as category_name, cat.slug as category_slug FROM product_pages p LEFT JOIN categories cat ON p.category_id = cat.id WHERE p.slug = :slug AND p.active = 1");
        $stmt->execute([':slug' => $slug]);
        $product = $stmt->fetch();

        if (!$product) { http_response_code(404); include BASE_PATH . '/templates/public/404.php'; return; }

        $db->prepare("UPDATE product_pages SET views = views + 1 WHERE id = :id")->execute([':id' => $product['id']]);

        $related = $db->prepare("SELECT c.* FROM coupons c WHERE c.active = 1 AND c.category_id = :cat_id ORDER BY c.created_at DESC LIMIT 4");
        $related->execute([':cat_id' => $product['category_id']]);
        $relatedCoupons = $related->fetchAll();

        $pageTitle = ($product['seo_title'] ?: $product['title']) . ' - LinkCom';
        $pageDescription = $product['seo_description'] ?: $product['description'];
        $contentTemplate = BASE_PATH . '/templates/public/product_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }

    public function category(string $slug): void {
        $db = get_db();
        $stmt = $db->prepare("SELECT * FROM categories WHERE slug = :slug AND active = 1");
        $stmt->execute([':slug' => $slug]);
        $category = $stmt->fetch();

        if (!$category) { http_response_code(404); include BASE_PATH . '/templates/public/404.php'; return; }

        $couponsStmt = $db->prepare("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.active = 1 AND c.category_id = :cat_id ORDER BY c.is_featured DESC, c.created_at DESC");
        $couponsStmt->execute([':cat_id' => $category['id']]);
        $coupons = $couponsStmt->fetchAll();

        $productsStmt = $db->prepare("SELECT * FROM product_pages WHERE active = 1 AND category_id = :cat_id ORDER BY created_at DESC");
        $productsStmt->execute([':cat_id' => $category['id']]);
        $products = $productsStmt->fetchAll();

        $pageTitle = $category['name'] . ' - Cupons de Desconto';
        $contentTemplate = BASE_PATH . '/templates/public/category_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }

    public function redirect(string $id): void {
        $db = get_db();
        $stmt = $db->prepare("SELECT affiliate_url FROM coupons WHERE id = :id AND active = 1");
        $stmt->execute([':id' => $id]);
        $coupon = $stmt->fetch();
        if ($coupon && $coupon['affiliate_url']) {
            $db->prepare("UPDATE coupons SET clicks = clicks + 1 WHERE id = :id")->execute([':id' => $id]);
            header('Location: ' . $coupon['affiliate_url']);
        } else {
            header('Location: /');
        }
        exit;
    }

    public function search(): void {
        $db = get_db();
        $q = trim($_GET['q'] ?? '');
        $coupons = $products = [];

        if ($q) {
            $stmt = $db->prepare("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.active = 1 AND (c.title LIKE :q OR c.description LIKE :q OR c.store_name LIKE :q) ORDER BY c.is_featured DESC LIMIT 20");
            $stmt->execute([':q' => "%{$q}%"]);
            $coupons = $stmt->fetchAll();

            $stmt = $db->prepare("SELECT p.*, cat.name as category_name FROM product_pages p LEFT JOIN categories cat ON p.category_id = cat.id WHERE p.active = 1 AND (p.title LIKE :q OR p.description LIKE :q) LIMIT 10");
            $stmt->execute([':q' => "%{$q}%"]);
            $products = $stmt->fetchAll();
        }

        $pageTitle = 'Busca - LinkCom';
        $contentTemplate = BASE_PATH . '/templates/public/search_content.php';
        include BASE_PATH . '/templates/layouts/public.php';
    }
}
