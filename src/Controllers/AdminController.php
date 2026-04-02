<?php
require_once BASE_PATH . '/config.php';

class AdminController {

    public function dashboard(): void {
        require_login();
        $db = get_db();

        $stats = [
            'total_coupons' => $db->query("SELECT COUNT(*) FROM coupons")->fetchColumn(),
            'active_coupons' => $db->query("SELECT COUNT(*) FROM coupons WHERE active = 1")->fetchColumn(),
            'total_products' => $db->query("SELECT COUNT(*) FROM product_pages")->fetchColumn(),
            'total_categories' => $db->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
            'total_clicks' => $db->query("SELECT COALESCE(SUM(clicks), 0) FROM coupons")->fetchColumn(),
            'total_views' => $db->query("SELECT COALESCE(SUM(views), 0) FROM product_pages")->fetchColumn(),
        ];

        $recent_coupons = $db->query("SELECT * FROM coupons ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $recent_products = $db->query("SELECT * FROM product_pages ORDER BY created_at DESC LIMIT 5")->fetchAll();
        $top_coupons = $db->query("SELECT * FROM coupons WHERE active = 1 ORDER BY clicks DESC LIMIT 5")->fetchAll();

        $pageTitle = 'Dashboard';
        $contentTemplate = BASE_PATH . '/templates/admin/dashboard_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }
}
