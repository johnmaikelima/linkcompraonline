<?php
require_once BASE_PATH . '/config.php';

class SettingsController {

    public function index(): void {
        require_login();
        $db = get_db();
        $settings = [];
        foreach ($db->query("SELECT * FROM settings")->fetchAll() as $row) {
            $settings[$row['key']] = $row['value'];
        }
        $pageTitle = 'Configurações';
        $contentTemplate = BASE_PATH . '/templates/admin/settings/index_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function update(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/configuracoes'); exit; }
        $fields = ['site_name', 'site_description', 'site_keywords', 'primary_color', 'hero_title', 'hero_subtitle', 'footer_text', 'analytics_code'];
        foreach ($fields as $f) { if (isset($_POST[$f])) set_setting($f, trim($_POST[$f])); }
        flash('success', 'Configurações salvas!');
        header('Location: /admin/configuracoes');
        exit;
    }

    public function amazon(): void {
        require_login();
        $db = get_db();
        $settings = [];
        foreach ($db->query("SELECT * FROM settings WHERE key LIKE 'amazon_%'")->fetchAll() as $row) {
            $settings[$row['key']] = $row['value'];
        }
        $pageTitle = 'API Amazon';
        $contentTemplate = BASE_PATH . '/templates/admin/settings/amazon_content.php';
        include BASE_PATH . '/templates/layouts/admin.php';
    }

    public function amazonUpdate(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/configuracoes/amazon'); exit; }
        $fields = ['amazon_access_key', 'amazon_secret_key', 'amazon_partner_tag', 'amazon_region', 'amazon_api_enabled'];
        foreach ($fields as $f) { if (isset($_POST[$f])) set_setting($f, trim($_POST[$f])); }
        flash('success', 'Configurações da Amazon salvas!');
        header('Location: /admin/configuracoes/amazon');
        exit;
    }

    public function amazonTest(): void {
        require_login();
        if (!verify_csrf($_POST['csrf_token'] ?? '')) { flash('error', 'Token inválido.'); header('Location: /admin/configuracoes/amazon'); exit; }
        $accessKey = get_setting('amazon_access_key');
        $secretKey = get_setting('amazon_secret_key');
        $partnerTag = get_setting('amazon_partner_tag');
        if (empty($accessKey) || empty($secretKey) || empty($partnerTag)) {
            flash('error', 'Preencha todas as credenciais antes de testar.');
            header('Location: /admin/configuracoes/amazon');
            exit;
        }
        // Teste de API simplificado
        flash('success', 'Credenciais salvas. Teste de conexão será realizado na próxima busca.');
        header('Location: /admin/configuracoes/amazon');
        exit;
    }
}
