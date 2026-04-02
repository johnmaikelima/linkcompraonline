<?php
require_once BASE_PATH . '/config.php';

class AuthController {

    public function loginForm(): void {
        if (is_logged_in()) {
            header('Location: /admin');
            exit;
        }
        include BASE_PATH . '/templates/auth/login.php';
    }

    public function login(): void {
        if (!verify_csrf($_POST['csrf_token'] ?? '')) {
            flash('error', 'Token de segurança inválido.');
            header('Location: /admin/login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            flash('error', 'Preencha todos os campos.');
            header('Location: /admin/login');
            exit;
        }

        // Rate limiting simples por sessão
        $attempts = $_SESSION['login_attempts'] ?? 0;
        $lastAttempt = $_SESSION['login_last_attempt'] ?? 0;

        if ($attempts >= 5 && (time() - $lastAttempt) < 300) {
            flash('error', 'Muitas tentativas. Aguarde 5 minutos.');
            header('Location: /admin/login');
            exit;
        }

        $db = get_db();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // Login bem-sucedido
            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['login_attempts'] = 0;

            flash('success', 'Bem-vindo, ' . e($user['name']) . '!');
            header('Location: /admin');
            exit;
        }

        // Login falhou
        $_SESSION['login_attempts'] = $attempts + 1;
        $_SESSION['login_last_attempt'] = time();

        flash('error', 'E-mail ou senha incorretos.');
        header('Location: /admin/login');
        exit;
    }

    public function logout(): void {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }
        session_destroy();
        header('Location: /admin/login');
        exit;
    }
}
