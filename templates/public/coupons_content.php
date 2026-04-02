<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Todos os Cupons</h1>
        <p class="text-gray-500 mt-1"><?= $total ?> cupons disponíveis</p>
    </div>

    <div class="flex flex-wrap gap-2 mb-8">
        <a href="/cupons" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= empty($categoryFilter) ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>">Todos</a>
        <?php foreach ($categories as $cat): ?>
        <a href="/cupons?categoria=<?= e($cat['slug']) ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?= ($categoryFilter ?? '') === $cat['slug'] ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' ?>"><?= e($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>

    <?php if ($coupons): ?>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($coupons as $coupon): ?>
        <div class="gradient-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl">
            <?php if ($coupon['image']): ?>
            <div class="h-44 overflow-hidden bg-gray-100"><img src="<?= e($coupon['image']) ?>" alt="<?= e($coupon['title']) ?>" class="w-full h-full object-cover"></div>
            <?php endif; ?>
            <div class="p-5">
                <div class="flex items-center gap-2 mb-3">
                    <?php if ($coupon['is_verified']): ?><span class="px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-semibold">Verificado</span><?php endif; ?>
                    <?php if ($coupon['category_name']): ?><span class="px-2 py-0.5 bg-primary-50 text-primary-700 rounded-full text-xs font-semibold"><?= e($coupon['category_name']) ?></span><?php endif; ?>
                    <?php if ($coupon['discount_value']): ?><span class="ml-auto text-lg font-extrabold text-primary-600"><?= $coupon['discount_type'] === 'percentage' ? e($coupon['discount_value']) . '%' : 'R$' . e($coupon['discount_value']) ?></span><?php endif; ?>
                </div>
                <?php if ($coupon['store_name']): ?><p class="text-xs text-gray-400 font-medium uppercase tracking-wider mb-1"><?= e($coupon['store_name']) ?></p><?php endif; ?>
                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2"><a href="/cupom/<?= e($coupon['slug']) ?>" class="hover:text-primary-600 transition-colors"><?= e($coupon['title']) ?></a></h3>
                <div class="mt-4"><?php include BASE_PATH . '/templates/partials/coupon_actions.php'; ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($totalPages > 1): ?>
    <div class="flex justify-center gap-2 mt-10">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/cupons?page=<?= $i ?><?= $categoryFilter ? '&categoria=' . e($categoryFilter) : '' ?>" class="w-10 h-10 flex items-center justify-center rounded-xl text-sm font-medium transition-colors <?= $i === $page ? 'bg-primary-600 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-gray-50' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
        <h3 class="text-lg font-semibold text-gray-700">Nenhum cupom encontrado</h3>
        <p class="text-gray-500 mt-1">Tente outra categoria ou volte mais tarde</p>
    </div>
    <?php endif; ?>
</div>
