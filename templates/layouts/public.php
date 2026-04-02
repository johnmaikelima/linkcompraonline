<!DOCTYPE html>
<html lang="pt-BR" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle ?? get_setting('site_name', SITE_NAME)) ?></title>
    <meta name="description" content="<?= e($pageDescription ?? get_setting('site_description')) ?>">
    <meta name="keywords" content="<?= e(get_setting('site_keywords')) ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {50:'#eef2ff',100:'#e0e7ff',200:'#c7d2fe',300:'#a5b4fc',400:'#818cf8',500:'#6366f1',600:'#4f46e5',700:'#4338ca',800:'#3730a3',900:'#312e81'},
                        accent: {50:'#fdf4ff',100:'#fae8ff',200:'#f5d0fe',300:'#f0abfc',400:'#e879f9',500:'#d946ef',600:'#c026d3',700:'#a21caf',800:'#86198f',900:'#701a75'}
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide-static@latest/font/lucide.min.css">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass { backdrop-filter: blur(12px); background: rgba(255,255,255,0.85); }
        .gradient-hero { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 30%, #d946ef 70%, #f59e0b 100%); }
        .gradient-card:hover { transform: translateY(-4px); box-shadow: 0 20px 40px -12px rgba(99,102,241,0.25); }
        .gradient-card { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .coupon-code { border: 2px dashed #6366f1; background: repeating-linear-gradient(45deg, #eef2ff, #eef2ff 10px, #e0e7ff 10px, #e0e7ff 20px); }
        .animate-float { animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }
        .badge-pulse { animation: pulse 2s infinite; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

<!-- Navbar -->
<nav class="glass fixed top-0 w-full z-50 border-b border-gray-200/50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-2">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <span class="text-xl font-bold bg-gradient-to-r from-primary-600 to-accent-600 bg-clip-text text-transparent">LinkCom</span>
                </a>
                <div class="hidden md:flex items-center gap-6">
                    <a href="/" class="text-gray-600 hover:text-primary-600 font-medium transition-colors text-sm">Início</a>
                    <a href="/cupons" class="text-gray-600 hover:text-primary-600 font-medium transition-colors text-sm">Cupons</a>
                    <?php
                    $navCats = get_db()->query("SELECT * FROM categories WHERE active = 1 ORDER BY sort_order LIMIT 5")->fetchAll();
                    foreach ($navCats as $cat): ?>
                        <a href="/categoria/<?= e($cat['slug']) ?>" class="text-gray-600 hover:text-primary-600 font-medium transition-colors text-sm"><?= e($cat['name']) ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <form action="/busca" method="GET" class="hidden sm:flex items-center">
                    <div class="relative">
                        <input type="text" name="q" placeholder="Buscar cupons..." value="<?= e($_GET['q'] ?? '') ?>" class="w-56 pl-10 pr-4 py-2 bg-gray-100 border-0 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:bg-white transition-all">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>
                </form>
            </div>
        </div>
    </div>
</nav>

<!-- Flash Messages -->
<?php foreach (get_flashes() as $flash): ?>
<div class="fixed top-20 right-4 z-50 animate-fade-in">
    <div class="px-6 py-3 rounded-xl shadow-lg <?= $flash['type'] === 'success' ? 'bg-green-500' : 'bg-red-500' ?> text-white font-medium">
        <?= e($flash['message']) ?>
    </div>
</div>
<?php endforeach; ?>

<!-- Content -->
<main class="flex-1 pt-16">
    <?php include $contentTemplate; ?>
</main>

<!-- Footer -->
<footer class="bg-gray-900 text-gray-400 mt-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-2 mb-4">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-accent-500 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <span class="text-xl font-bold text-white">LinkCom</span>
                </div>
                <p class="text-sm leading-relaxed max-w-md"><?= e(get_setting('site_description', 'Os melhores cupons de desconto e ofertas da internet')) ?></p>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Categorias</h4>
                <ul class="space-y-2">
                    <?php foreach (($navCats ?? []) as $cat): ?>
                    <li><a href="/categoria/<?= e($cat['slug']) ?>" class="text-sm hover:text-primary-400 transition-colors"><?= e($cat['name']) ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-semibold mb-4">Links</h4>
                <ul class="space-y-2">
                    <li><a href="/cupons" class="text-sm hover:text-primary-400 transition-colors">Todos os Cupons</a></li>
                    <li><a href="/busca" class="text-sm hover:text-primary-400 transition-colors">Buscar</a></li>
                </ul>
            </div>
        </div>
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
            <?= e(get_setting('footer_text', '© ' . date('Y') . ' LinkCom. Todos os direitos reservados.')) ?>
        </div>
    </div>
</footer>

<script>
// Auto-hide flash messages
document.querySelectorAll('.animate-fade-in').forEach(el => {
    setTimeout(() => el.style.display = 'none', 4000);
});

// Revelar cupom + abrir link de afiliado em nova aba
function revealCoupon(code, redirectUrl, btn) {
    // Abre o link de afiliado em nova aba (guarda o cookie)
    if (redirectUrl) {
        window.open(redirectUrl, '_blank');
    }
    // Revela o código completo
    btn.innerText = code;
    btn.classList.remove('cursor-pointer');
    btn.classList.add('bg-green-100', 'text-green-700', 'border-green-400');
    btn.onclick = function() { copyToClipboard(code, btn); };
    // Copia automaticamente
    copyToClipboard(code, btn);
}

function copyToClipboard(code, btn) {
    navigator.clipboard.writeText(code).then(() => {
        const orig = btn.innerText;
        btn.innerText = 'Copiado!';
        btn.classList.add('bg-green-500', 'text-white');
        setTimeout(() => {
            btn.innerText = orig;
            btn.classList.remove('bg-green-500', 'text-white');
        }, 2000);
    });
}
</script>
<?= get_setting('analytics_code') ?>
</body>
</html>
