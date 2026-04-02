<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <!-- Header da categoria -->
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center" style="background: <?= e($category['color']) ?>20; color: <?= e($category['color']) ?>">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-900"><?= e($category['name']) ?></h1>
                <p class="text-gray-500"><?= count($coupons) ?> cupons disponíveis</p>
            </div>
        </div>
        <?php if (!empty($category['description'])): ?>
        <p class="text-gray-600 leading-relaxed max-w-3xl mt-4"><?= nl2br(e($category['description'])) ?></p>
        <?php endif; ?>
    </div>

    <!-- Cupons -->
    <?php if ($coupons): ?>
    <h2 class="text-xl font-bold text-gray-900 mb-4">Cupons</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <?php foreach ($coupons as $coupon): ?>
        <div class="gradient-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-lg">
            <div class="flex items-start justify-between mb-3">
                <div class="flex-1">
                    <?php if ($coupon['store_name']): ?><p class="text-xs text-gray-400 font-medium uppercase"><?= e($coupon['store_name']) ?></p><?php endif; ?>
                    <h3 class="font-bold text-gray-900 mt-1 line-clamp-2"><a href="/cupom/<?= e($coupon['slug']) ?>" class="hover:text-primary-600"><?= e($coupon['title']) ?></a></h3>
                </div>
                <?php if ($coupon['discount_value']): ?><span class="ml-3 px-3 py-1.5 bg-gradient-to-r from-primary-500 to-accent-500 text-white rounded-xl text-sm font-bold whitespace-nowrap"><?= $coupon['discount_type'] === 'percentage' ? e($coupon['discount_value']) . '%' : 'R$' . e($coupon['discount_value']) ?></span><?php endif; ?>
            </div>
            <div class="mt-4"><?php include BASE_PATH . '/templates/partials/coupon_actions.php'; ?></div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Produtos -->
    <?php if ($products): ?>
    <h2 class="text-xl font-bold text-gray-900 mb-4">Produtos</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <?php foreach ($products as $p): ?>
        <a href="/produto/<?= e($p['slug']) ?>" class="gradient-card bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl group">
            <?php if ($p['image']): ?><div class="h-48 overflow-hidden bg-gray-100"><img src="<?= e($p['image']) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"></div><?php endif; ?>
            <div class="p-4">
                <h3 class="font-bold text-gray-900 group-hover:text-primary-600 line-clamp-2"><?= e($p['title']) ?></h3>
                <?php if ($p['price']): ?><p class="mt-2 text-lg font-bold text-primary-600">R$ <?= e($p['price']) ?></p><?php endif; ?>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <!-- Artigo da Categoria -->
    <?php if (!empty($category['article'])): ?>
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 md:p-12 mt-8">
        <article class="prose prose-lg prose-gray max-w-none
            prose-headings:text-gray-900 prose-headings:font-bold
            prose-h2:text-2xl prose-h2:mt-8 prose-h2:mb-4
            prose-h3:text-xl prose-h3:mt-6 prose-h3:mb-3
            prose-p:text-gray-600 prose-p:leading-relaxed
            prose-a:text-primary-600 prose-a:font-semibold prose-a:no-underline hover:prose-a:underline
            prose-strong:text-gray-900
            prose-ul:text-gray-600 prose-ol:text-gray-600
            prose-li:marker:text-primary-500
            prose-img:rounded-2xl prose-img:shadow-lg">
            <?= $category['article'] ?>
        </article>
    </div>
    <?php endif; ?>

    <?php if (!$coupons && !$products && empty($category['article'])): ?>
    <div class="text-center py-16">
        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        <h3 class="text-lg font-semibold text-gray-700">Nenhum conteúdo nesta categoria</h3>
    </div>
    <?php endif; ?>
</div>
