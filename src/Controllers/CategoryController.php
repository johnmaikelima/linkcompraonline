<?php
require_once BASE_PATH . '/config.php';

class CategoryController {

    public function index(): void {
        require_login();
        $db = get_db();
        $categories = $db->query("SELECT c.*, (SELECT COUNT(*) FROM coupons WHERE category_id = c.id) as coupon_count FROM categories c ORDER BY c.sort_order, c.name")->fetchAll();
        $pageTitle = 'Categorias';
        $contentTemplate = BASE_PATH . '/templates/admin/categories/index_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function store(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/categorias'); exit; }
        $name = trim($_POST['name'] ?? '');
        $color = trim($_POST['color'] ?? '#6366f1');
        $icon = trim($_POST['icon'] ?? 'tag');
        if (empty($name)) { flash('error', 'Nome obrigatório.'); header('Location: /admin/categorias'); exit; }
        $db = get_db();
        $db->prepare("INSERT INTO categories (name, slug, icon, color) VALUES (:name, :slug, :icon, :color)")->execute([
            ':name' => $name, ':slug' => slug($name), ':icon' => $icon, ':color' => $color,
        ]);
        flash('success', 'Categoria criada!');
        header('Location: /admin/categorias');
        exit;
    }

    public function edit(string $id): void {
        require_login();
        $db = get_db();
        $stmt = $db->prepare("SELECT * FROM categories WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $category = $stmt->fetch();
        if (!$category) { flash('error', 'Categoria não encontrada.'); header('Location: /admin/categorias'); exit; }

        $pageTitle = 'Editar Categoria: ' . $category['name'];
        $contentTemplate = BASE_PATH . '/templates/admin/categories/edit_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function update(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/categorias'); exit; }
        $db = get_db();
        $db->prepare("UPDATE categories SET name=:name, slug=:slug, icon=:icon, color=:color, description=:description, article=:article, active=:active WHERE id=:id")->execute([
            ':id' => $id,
            ':name' => trim($_POST['name'] ?? ''),
            ':slug' => slug(trim($_POST['name'] ?? '')),
            ':icon' => trim($_POST['icon'] ?? 'tag'),
            ':color' => trim($_POST['color'] ?? '#6366f1'),
            ':description' => trim($_POST['description'] ?? ''),
            ':article' => $_POST['article'] ?? '',
            ':active' => isset($_POST['active']) ? 1 : 0,
        ]);
        flash('success', 'Categoria atualizada!');
        header('Location: /admin/categorias/editar/' . $id);
        exit;
    }

    public function delete(string $id): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/categorias'); exit; }
        $db = get_db();
        $db->prepare("DELETE FROM categories WHERE id = :id")->execute([':id' => $id]);
        flash('success', 'Categoria excluída!');
        header('Location: /admin/categorias');
        exit;
    }
}
