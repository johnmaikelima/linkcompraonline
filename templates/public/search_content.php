<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Resultados da Busca</h1>
    <?php if ($q): ?><p class="text-gray-500 mb-8">Resultados para "<strong class="text-gray-700"><?= e($q) ?></strong>"</p><?php endif; ?>

    <?php if ($coupons): ?>
    <h2 class="text-xl font-bold text-gray-900 mb-4">Cupons (<?= count($coupons) ?>)</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-10">
        <?php foreach ($coupons as $c): ?>
        <div class="gradient-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between">
                <div class="flex-1">
                    <?php if ($c['store_name']): ?><p class="text-xs text-gray-400 font-medium uppercase"><?= e($c['store_name']) ?></p><?php endif; ?>
                    <h3 class="font-bold text-gray-900 mt-1"><a href="/cupom/<?= e($c['slug']) ?>" class="hover:text-primary-600"><?= e($c['title']) ?></a></h3>
                </div>
                <?php if ($c['discount_value']): ?><span class="ml-3 px-3 py-1 bg-primary-100 text-primary-700 rounded-lg text-sm font-bold"><?= $c['discount_type'] === 'percentage' ? e($c['discount_value']) . '%' : 'R$' . e($c['discount_value']) ?></span><?php endif; ?>
            </div>
            <div class="flex items-center gap-2 mt-4">
                <?php $coupon = $c; include BASE_PATH . '/templates/partials/coupon_actions.php'; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if ($products): ?>
    <h2 class="text-xl font-bold text-gray-900 mb-4">Produtos (<?= count($products) ?>)</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <?php foreach ($products as $p): ?>
        <a href="/produto/<?= e($p['slug']) ?>" class="gradient-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl group">
            <?php if ($p['image']): ?><div class="h-44 overflow-hidden bg-gray-100"><img src="<?= e($p['image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform"></div><?php endif; ?>
            <div class="p-4">
                <h3 class="font-bold text-gray-900 group-hover:text-primary-600"><?= e($p['title']) ?></h3>
                <?php if ($p['price']): ?><p class="text-primary-600 font-bold mt-1">R$ <?= e($p['price']) ?></p><?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php if (!$coupons && !$products): ?>
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        <h3 class="text-lg font-semibold text-gray-700">Nenhum resultado encontrado</h3>
        <p class="text-gray-500 mt-1">Tente buscar com outros termos</p>
        <a href="/cupons" class="inline-block mt-4 px-6 py-2 bg-primary-600 text-white rounded-xl text-sm font-semibold hover:bg-primary-700 transition">Ver todos os cupons</a>
    </div>
    <?php endif; ?>
</div>
