<!-- Hero -->
<section class="gradient-hero relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-10 left-10 w-72 h-72 bg-white rounded-full mix-blend-overlay filter blur-3xl"></div>
        <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full mix-blend-overlay filter blur-3xl"></div>
    </div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 text-center">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-white mb-6 leading-tight">
            <?= e(get_setting('hero_title', 'Encontre os Melhores Cupons de Desconto')) ?>
        </h1>
        <p class="text-lg md:text-xl text-white/80 max-w-2xl mx-auto mb-10">
            <?= e(get_setting('hero_subtitle', 'Economize em suas compras com nossos cupons exclusivos')) ?>
        </p>
        <form action="/busca" method="GET" class="max-w-xl mx-auto">
            <div class="flex bg-white rounded-2xl shadow-2xl shadow-black/10 overflow-hidden p-1.5">
                <input type="text" name="q" placeholder="Buscar cupons, lojas, produtos..." class="flex-1 px-5 py-3.5 text-gray-700 border-0 focus:ring-0 text-base bg-transparent outline-none">
                <button type="submit" class="px-8 py-3.5 bg-gradient-to-r from-primary-600 to-accent-600 text-white rounded-xl font-semibold hover:from-primary-700 hover:to-accent-700 transition-all shadow-lg">
                    Buscar
                </button>
            </div>
        </form>
        <div class="flex flex-wrap justify-center gap-3 mt-8">
            <?php foreach (array_slice($categories, 0, 6) as $cat): ?>
            <a href="/categoria/<?= e($cat['slug']) ?>" class="px-4 py-2 bg-white/15 backdrop-blur-sm text-white rounded-full text-sm font-medium hover:bg-white/25 transition-colors">
                <?= e($cat['name']) ?>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Cupons em Destaque -->
<?php if ($featured): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl md:text-3xl font-bold text-gray-900">Cupons em Destaque</h2>
            <p class="text-gray-500 mt-1">As melhores ofertas selecionadas para você</p>
        </div>
        <a href="/cupons" class="text-primary-600 hover:text-primary-700 font-semibold text-sm flex items-center gap-1">
            Ver todos
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($featured as $coupon): ?>
        <div class="gradient-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl group">
            <?php if ($coupon['image']): ?>
            <div class="h-48 overflow-hidden bg-gray-100">
                <img src="<?= e($coupon['image']) ?>" alt="<?= e($coupon['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
            </div>
            <?php endif; ?>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    <?php if ($coupon['is_verified']): ?>
                    <span class="px-2.5 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Verificado</span>
                    <?php endif; ?>
                    <?php if ($coupon['category_name']): ?>
                    <span class="px-2.5 py-1 bg-primary-50 text-primary-700 rounded-full text-xs font-semibold"><?= e($coupon['category_name']) ?></span>
                    <?php endif; ?>
                    <?php if ($coupon['discount_value']): ?>
                    <span class="ml-auto text-xl font-extrabold text-primary-600">
                        <?= $coupon['discount_type'] === 'percentage' ? e($coupon['discount_value']) . '%' : 'R$' . e($coupon['discount_value']) ?>
                    </span>
                    <?php endif; ?>
                </div>
                <?php if ($coupon['store_name']): ?>
                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1"><?= e($coupon['store_name']) ?></p>
                <?php endif; ?>
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2">
                    <a href="/cupom/<?= e($coupon['slug']) ?>" class="hover:text-primary-600 transition-colors"><?= e($coupon['title']) ?></a>
                </h3>
                <?php if ($coupon['description']): ?>
                <p class="text-sm text-gray-500 mb-4 line-clamp-2"><?= e($coupon['description']) ?></p>
                <?php endif; ?>
                <?php include BASE_PATH . '/templates/partials/coupon_actions.php'; ?>
                <?php if ($coupon['expiry_date']): ?>
                <p class="text-xs text-gray-400 mt-3 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Válido até <?= date('d/m/Y', strtotime($coupon['expiry_date'])) ?>
                </p>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Categorias -->
<?php if ($categories): ?>
<section class="bg-white border-y border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 text-center mb-3">Explore por Categoria</h2>
        <p class="text-gray-500 text-center mb-10">Encontre cupons nas suas categorias favoritas</p>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php foreach ($categories as $cat): ?>
            <a href="/categoria/<?= e($cat['slug']) ?>" class="gradient-card group flex flex-col items-center gap-3 p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary-200 hover:bg-primary-50 transition-all text-center">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center" style="background: <?= e($cat['color']) ?>20; color: <?= e($cat['color']) ?>">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 group-hover:text-primary-700"><?= e($cat['name']) ?></h3>
                    <p class="text-xs text-gray-400 mt-1"><?= $cat['coupon_count'] ?> cupons</p>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Cupons Recentes -->
<?php if ($latest): ?>
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Cupons Recentes</h2>
    <p class="text-gray-500 mb-8">Adicionados recentemente na plataforma</p>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
        <?php foreach ($latest as $coupon): ?>
        <div class="gradient-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <?php if ($coupon['store_name']): ?><p class="text-xs text-gray-400 font-medium uppercase tracking-wider"><?= e($coupon['store_name']) ?></p><?php endif; ?>
                    <h3 class="font-bold text-gray-900 mt-1 line-clamp-2">
                        <a href="/cupom/<?= e($coupon['slug']) ?>" class="hover:text-primary-600 transition-colors"><?= e($coupon['title']) ?></a>
                    </h3>
                </div>
                <?php if ($coupon['discount_value']): ?>
                <div class="ml-3 px-3 py-1.5 bg-gradient-to-r from-primary-500 to-accent-500 text-white rounded-xl text-sm font-bold whitespace-nowrap">
                    <?= $coupon['discount_type'] === 'percentage' ? e($coupon['discount_value']) . '%' : 'R$' . e($coupon['discount_value']) ?>
                </div>
                <?php endif; ?>
            </div>
            <?php include BASE_PATH . '/templates/partials/coupon_actions.php'; ?>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Produtos em Destaque -->
<?php if ($products): ?>
<section class="bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">Produtos Recomendados</h2>
        <p class="text-gray-500 mb-8">Análises detalhadas dos melhores produtos</p>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($products as $product): ?>
            <a href="/produto/<?= e($product['slug']) ?>" class="gradient-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl group">
                <?php if ($product['image']): ?>
                <div class="h-48 overflow-hidden bg-gray-100"><img src="<?= e($product['image']) ?>" alt="<?= e($product['title']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"></div>
                <?php else: ?>
                <div class="h-48 bg-gradient-to-br from-primary-100 to-accent-100 flex items-center justify-center">
                    <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <?php endif; ?>
                <div class="p-5">
                    <?php if ($product['category_name']): ?><span class="text-xs text-primary-600 font-semibold"><?= e($product['category_name']) ?></span><?php endif; ?>
                    <h3 class="font-bold text-gray-900 mt-1 group-hover:text-primary-600 transition-colors line-clamp-2"><?= e($product['title']) ?></h3>
                    <?php if ($product['price']): ?>
                    <div class="mt-3 flex items-baseline gap-2">
                        <span class="text-lg font-bold text-primary-600">R$ <?= e($product['price']) ?></span>
                        <?php if ($product['original_price']): ?><span class="text-sm text-gray-400 line-through">R$ <?= e($product['original_price']) ?></span><?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
