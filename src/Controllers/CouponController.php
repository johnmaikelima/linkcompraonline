<?php
require_once BASE_PATH . '/config.php';

class CouponController {

    public function index(): void {
        require_login();
        $db = get_db();

        $search = $_GET['q'] ?? '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        if ($search) {
            $stmt = $db->prepare("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id WHERE c.title LIKE :q OR c.store_name LIKE :q ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':q', "%{$search}%");
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $coupons = $stmt->fetchAll();

            $countStmt = $db->prepare("SELECT COUNT(*) FROM coupons WHERE title LIKE :q OR store_name LIKE :q");
            $countStmt->execute([':q' => "%{$search}%"]);
            $total = $countStmt->fetchColumn();
        } else {
            $stmt = $db->prepare("SELECT c.*, cat.name as category_name FROM coupons c LEFT JOIN categories cat ON c.category_id = cat.id ORDER BY c.created_at DESC LIMIT :limit OFFSET :offset");
            $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->execute();
            $coupons = $stmt->fetchAll();
            $total = $db->query("SELECT COUNT(*) FROM coupons")->fetchColumn();
        }

        $totalPages = ceil($total / $perPage);
        $pageTitle = 'Cupons';
        $contentTemplate = BASE_PATH . '/templates/admin/coupons/index_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function create(): void {
        require_login();
        $db = get_db();
        $categories = $db->query("SELECT * FROM categories WHERE active = 1 ORDER BY name")->fetchAll();
        $coupon = null;
        $pageTitle = 'Novo Cupom';
        $contentTemplate = BASE_PATH . '/templates/admin/coupons/form_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function store(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            flash('error', 'Token inválido.');
            header('Location: /admin/cupons/criar');
            exit;
        }

        $db = get_db();
        $data = $this->sanitizeInput($_POST);
        $data['slug'] = $this->uniqueSlug($db, $data['title']);
        $data['image'] = $this->handleUpload('image');

        $stmt = $db->prepare("INSERT INTO coupons (title, slug, description, code, discount_type, discount_value, store_name, store_logo, image, affiliate_url, amazon_asin, category_id, expiry_date, is_featured, is_verified, active) VALUES (:title, :slug, :description, :code, :discount_type, :discount_value, :store_name, :store_logo, :image, :affiliate_url, :amazon_asin, :category_id, :expiry_date, :is_featured, :is_verified, :active)");

        $stmt->execute([
            ':title' => $data['title'], ':slug' => $data['slug'], ':description' => $data['description'],
            ':code' => $data['code'], ':discount_type' => $data['discount_type'], ':discount_value' => $data['discount_value'],
            ':store_name' => $data['store_name'], ':store_logo' => $data['store_logo'], ':image' => $data['image'],
            ':affiliate_url' => $data['affiliate_url'], ':amazon_asin' => $data['amazon_asin'],
            ':category_id' => $data['category_id'] ?: null, ':expiry_date' => $data['expiry_date'] ?: null,
            ':is_featured' => $data['is_featured'], ':is_verified' => $data['is_verified'], ':active' => $data['active'],
        ]);

        flash('success', 'Cupom criado com sucesso!');
        header('Location: /admin/cupons');
        exit;
    }

    public function edit(string $id): void {
        require_login();
        $db = get_db();

        $stmt = $db->prepare("SELECT * FROM coupons WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $coupon = $stmt->fetch();

        if (!$coupon) { flash('error', 'Cupom não encontrado.'); header('Location: /admin/cupons'); exit; }

        $categories = $db->query("SELECT * FROM categories WHERE active = 1 ORDER BY name")->fetchAll();
        $pageTitle = 'Editar Cupom';
        $contentTemplate = BASE_PATH . '/templates/admin/coupons/form_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function update(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header("Location: /admin/cupons/editar/{$id}"); exit; }

        $db = get_db();
        $data = $this->sanitizeInput($_POST);
        $image = $this->handleUpload('image') ?: ($_POST['current_image'] ?? '');

        $stmt = $db->prepare("UPDATE coupons SET title=:title, description=:description, code=:code, discount_type=:discount_type, discount_value=:discount_value, store_name=:store_name, store_logo=:store_logo, image=:image, affiliate_url=:affiliate_url, amazon_asin=:amazon_asin, category_id=:category_id, expiry_date=:expiry_date, is_featured=:is_featured, is_verified=:is_verified, active=:active, updated_at=CURRENT_TIMESTAMP WHERE id=:id");

        $stmt->execute([
            ':id' => $id, ':title' => $data['title'], ':description' => $data['description'],
            ':code' => $data['code'], ':discount_type' => $data['discount_type'], ':discount_value' => $data['discount_value'],
            ':store_name' => $data['store_name'], ':store_logo' => $data['store_logo'], ':image' => $image,
            ':affiliate_url' => $data['affiliate_url'], ':amazon_asin' => $data['amazon_asin'],
            ':category_id' => $data['category_id'] ?: null, ':expiry_date' => $data['expiry_date'] ?: null,
            ':is_featured' => $data['is_featured'], ':is_verified' => $data['is_verified'], ':active' => $data['active'],
        ]);

        flash('success', 'Cupom atualizado com sucesso!');
        header('Location: /admin/cupons');
        exit;
    }

    public function delete(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/cupons'); exit; }
        $db = get_db();
        $db->prepare("DELETE FROM coupons WHERE id = :id")->execute([':id' => $id]);
        flash('success', 'Cupom excluído!');
        header('Location: /admin/cupons');
        exit;
    }

    private function sanitizeInput(array $post): array {
        return [
            'title' => trim($post['title'] ?? ''), 'description' => trim($post['description'] ?? ''),
            'code' => trim($post['code'] ?? ''), 'discount_type' => $post['discount_type'] ?? 'percentage',
            'discount_value' => trim($post['discount_value'] ?? ''), 'store_name' => trim($post['store_name'] ?? ''),
            'store_logo' => trim($post['store_logo'] ?? ''), 'affiliate_url' => trim($post['affiliate_url'] ?? ''),
            'amazon_asin' => trim($post['amazon_asin'] ?? ''), 'category_id' => $post['category_id'] ?? null,
            'expiry_date' => $post['expiry_date'] ?? null, 'is_featured' => isset($post['is_featured']) ? 1 : 0,
            'is_verified' => isset($post['is_verified']) ? 1 : 0, 'active' => isset($post['active']) ? 1 : 0,
        ];
    }

    private function uniqueSlug(PDO $db, string $title): string {
        $base = slug($title); $s = $base; $i = 1;
        while ($db->query("SELECT COUNT(*) FROM coupons WHERE slug = " . $db->quote($s))->fetchColumn() > 0) { $s = $base . '-' . $i++; }
        return $s;
    }

    private function handleUpload(string $field): string {
        if (empty($_FILES[$field]['tmp_name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return '';
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES[$field]['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed)) { flash('error', 'Tipo de imagem não permitido.'); return ''; }
        $ext = match($mime) { 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif', default => 'jpg' };
        $uploadDir = BASE_PATH . '/public/assets/img/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = uniqid('img_') . '.' . $ext;
        move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . $filename);
        return '/assets/img/uploads/' . $filename;
    }
}
