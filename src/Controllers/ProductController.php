<?php
require_once BASE_PATH . '/config.php';

class ProductController {

    public function index(): void {
        require_login();
        $db = get_db();
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 15;
        $offset = ($page - 1) * $perPage;

        $stmt = $db->prepare("SELECT p.*, cat.name as category_name FROM product_pages p LEFT JOIN categories cat ON p.category_id = cat.id ORDER BY p.created_at DESC LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $products = $stmt->fetchAll();
        $total = $db->query("SELECT COUNT(*) FROM product_pages")->fetchColumn();
        $totalPages = ceil($total / $perPage);

        $pageTitle = 'Produtos';
        $contentTemplate = BASE_PATH . '/templates/admin/products/index_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function create(): void {
        require_login();
        $db = get_db();
        $categories = $db->query("SELECT * FROM categories WHERE active = 1 ORDER BY name")->fetchAll();
        $product = null;
        $pageTitle = 'Novo Produto';
        $contentTemplate = BASE_PATH . '/templates/admin/products/form_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function store(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/produtos/criar'); exit; }

        $db = get_db();
        $data = $this->sanitizeInput($_POST);
        $data['slug'] = $this->uniqueSlug($db, $data['title']);
        $data['image'] = $this->handleUpload('image');

        $stmt = $db->prepare("INSERT INTO product_pages (title, slug, description, content, image, price, original_price, store_name, store_url, buy_url, amazon_url, amazon_asin, rating, pros, cons, category_id, seo_title, seo_description, active) VALUES (:title, :slug, :description, :content, :image, :price, :original_price, :store_name, :store_url, :buy_url, :amazon_url, :amazon_asin, :rating, :pros, :cons, :category_id, :seo_title, :seo_description, :active)");
        $stmt->execute([
            ':title' => $data['title'], ':slug' => $data['slug'], ':description' => $data['description'],
            ':content' => $data['content'], ':image' => $data['image'], ':price' => $data['price'],
            ':original_price' => $data['original_price'], ':store_name' => $data['store_name'],
            ':store_url' => $data['store_url'], ':buy_url' => $data['buy_url'],
            ':amazon_url' => $data['amazon_url'], ':amazon_asin' => $data['amazon_asin'],
            ':rating' => $data['rating'], ':pros' => $data['pros'], ':cons' => $data['cons'],
            ':category_id' => $data['category_id'] ?: null,
            ':seo_title' => $data['seo_title'], ':seo_description' => $data['seo_description'], ':active' => $data['active'],
        ]);

        flash('success', 'Produto criado com sucesso!');
        header('Location: /admin/produtos');
        exit;
    }

    public function edit(string $id): void {
        require_login();
        $db = get_db();
        $stmt = $db->prepare("SELECT * FROM product_pages WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $product = $stmt->fetch();
        if (!$product) { flash('error', 'Produto não encontrado.'); header('Location: /admin/produtos'); exit; }

        $categories = $db->query("SELECT * FROM categories WHERE active = 1 ORDER BY name")->fetchAll();
        $pageTitle = 'Editar Produto';
        $contentTemplate = BASE_PATH . '/templates/admin/products/form_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function update(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header("Location: /admin/produtos/editar/{$id}"); exit; }

        $db = get_db();
        $data = $this->sanitizeInput($_POST);
        $image = $this->handleUpload('image') ?: ($_POST['current_image'] ?? '');

        $stmt = $db->prepare("UPDATE product_pages SET title=:title, description=:description, content=:content, image=:image, price=:price, original_price=:original_price, store_name=:store_name, store_url=:store_url, buy_url=:buy_url, amazon_url=:amazon_url, amazon_asin=:amazon_asin, rating=:rating, pros=:pros, cons=:cons, category_id=:category_id, seo_title=:seo_title, seo_description=:seo_description, active=:active, updated_at=CURRENT_TIMESTAMP WHERE id=:id");
        $stmt->execute([
            ':id' => $id, ':title' => $data['title'], ':description' => $data['description'],
            ':content' => $data['content'], ':image' => $image, ':price' => $data['price'],
            ':original_price' => $data['original_price'], ':store_name' => $data['store_name'],
            ':store_url' => $data['store_url'], ':buy_url' => $data['buy_url'],
            ':amazon_url' => $data['amazon_url'], ':amazon_asin' => $data['amazon_asin'],
            ':rating' => $data['rating'], ':pros' => $data['pros'], ':cons' => $data['cons'],
            ':category_id' => $data['category_id'] ?: null,
            ':seo_title' => $data['seo_title'], ':seo_description' => $data['seo_description'], ':active' => $data['active'],
        ]);

        flash('success', 'Produto atualizado!');
        header('Location: /admin/produtos');
        exit;
    }

    public function delete(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/produtos'); exit; }
        $db = get_db();
        $db->prepare("DELETE FROM product_pages WHERE id = :id")->execute([':id' => $id]);
        flash('success', 'Produto excluído!');
        header('Location: /admin/produtos');
        exit;
    }

    private function sanitizeInput(array $post): array {
        return [
            'title' => trim($post['title'] ?? ''), 'description' => trim($post['description'] ?? ''),
            'content' => $post['content'] ?? '', 'price' => trim($post['price'] ?? ''),
            'original_price' => trim($post['original_price'] ?? ''),
            'store_name' => trim($post['store_name'] ?? ''), 'store_url' => trim($post['store_url'] ?? ''),
            'buy_url' => trim($post['buy_url'] ?? ''),
            'amazon_url' => trim($post['amazon_url'] ?? ''), 'amazon_asin' => trim($post['amazon_asin'] ?? ''),
            'rating' => (float)($post['rating'] ?? 0),
            'pros' => trim($post['pros'] ?? ''), 'cons' => trim($post['cons'] ?? ''),
            'category_id' => $post['category_id'] ?? null, 'seo_title' => trim($post['seo_title'] ?? ''),
            'seo_description' => trim($post['seo_description'] ?? ''), 'active' => isset($post['active']) ? 1 : 0,
        ];
    }

    private function uniqueSlug(PDO $db, string $title): string {
        $base = slug($title); $s = $base; $i = 1;
        while ($db->query("SELECT COUNT(*) FROM product_pages WHERE slug = " . $db->quote($s))->fetchColumn() > 0) { $s = $base . '-' . $i++; }
        return $s;
    }

    private function handleUpload(string $field): string {
        if (empty($_FILES[$field]['tmp_name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return '';
        $allowed = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES[$field]['tmp_name']);
        finfo_close($finfo);
        if (!in_array($mime, $allowed)) return '';
        $ext = match($mime) { 'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/gif' => 'gif', default => 'jpg' };
        $uploadDir = BASE_PATH . '/public/assets/img/uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $filename = uniqid('prod_') . '.' . $ext;
        move_uploaded_file($_FILES[$field]['tmp_name'], $uploadDir . $filename);
        return '/assets/img/uploads/' . $filename;
    }
}
