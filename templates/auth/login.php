<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LinkCom Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="min-h-screen flex">
    <!-- Left side - decorative -->
    <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-20 left-20 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-xl animate-pulse"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>
        <div class="relative z-10 flex flex-col justify-center px-16 text-white">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="text-3xl font-bold">LinkCom</span>
            </div>
            <h2 class="text-4xl font-bold mb-4 leading-tight">Gerencie seus cupons<br>de forma inteligente</h2>
            <p class="text-lg text-white/80 max-w-md">Painel administrativo completo para gerenciar cupons de desconto, páginas de produtos e integração com a Amazon.</p>
            <div class="mt-12 flex gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold">100%</div>
                    <div class="text-sm text-white/70">Seguro</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">24/7</div>
                    <div class="text-sm text-white/70">Disponível</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold">API</div>
                    <div class="text-sm text-white/70">Amazon</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right side - login form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 bg-gray-50">
        <div class="w-full max-w-md">
            <div class="lg:hidden flex items-center gap-3 mb-8 justify-center">
                <div class="w-12 h-12 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl flex items-center justify-center">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <span class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">LinkCom</span>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-2">Bem-vindo de volta</h1>
            <p class="text-gray-500 mb-8">Faça login para acessar o painel</p>

            <?php foreach (get_flashes() as $flash): ?>
            <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium <?= $flash['type'] === 'success' ? 'bg-green-50 text-green-700 border border-green-200' : 'bg-red-50 text-red-700 border border-red-200' ?>">
                <?= e($flash['message']) ?>
            </div>
            <?php endforeach; ?>

            <form method="POST" action="/admin/login" class="space-y-5">
                <?= csrf_field() ?>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">E-mail</label>
                    <input type="email" name="email" required autocomplete="email"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="seu@email.com">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Senha</label>
                    <input type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all"
                        placeholder="••••••••">
                </div>

                <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg shadow-indigo-500/25 hover:shadow-indigo-500/40">
                    Entrar
                </button>
            </form>

            <p class="text-center text-xs text-gray-400 mt-8">Protegido com criptografia e CSRF token</p>
        </div>
    </div>
</body>
</html>
