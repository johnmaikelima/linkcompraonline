<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-primary-600">Início</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="/cupons" class="hover:text-primary-600">Cupons</a>
        <?php if ($coupon['category_name']): ?>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="/categoria/<?= e($coupon['category_slug']) ?>" class="hover:text-primary-600"><?= e($coupon['category_name']) ?></a>
        <?php endif; ?>
    </nav>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <?php if ($coupon['image']): ?>
        <div class="h-64 md:h-80 overflow-hidden bg-gray-100"><img src="<?= e($coupon['image']) ?>" alt="<?= e($coupon['title']) ?>" class="w-full h-full object-cover"></div>
        <?php endif; ?>
        <div class="p-8">
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <?php if ($coupon['is_verified']): ?><span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold flex items-center gap-1"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Verificado</span><?php endif; ?>
                <?php if ($coupon['is_featured']): ?><span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-full text-sm font-semibold">Destaque</span><?php endif; ?>
                <?php if ($coupon['category_name']): ?><span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-sm font-semibold"><?= e($coupon['category_name']) ?></span><?php endif; ?>
            </div>
            <?php if ($coupon['store_name']): ?><p class="text-sm text-gray-400 font-medium uppercase tracking-wider mb-2"><?= e($coupon['store_name']) ?></p><?php endif; ?>
            <h1 class="text-3xl font-bold text-gray-900 mb-4"><?= e($coupon['title']) ?></h1>
            <?php if ($coupon['discount_value']): ?>
            <div class="inline-flex items-baseline gap-1 px-5 py-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white rounded-2xl mb-6">
                <span class="text-3xl font-extrabold"><?= $coupon['discount_type'] === 'percentage' ? e($coupon['discount_value']) . '%' : 'R$ ' . e($coupon['discount_value']) ?></span>
                <span class="text-sm font-medium opacity-80">de desconto</span>
            </div>
            <?php endif; ?>
            <?php if ($coupon['description']): ?><div class="prose prose-gray max-w-none mb-8"><p class="text-gray-600 leading-relaxed"><?= nl2br(e($coupon['description'])) ?></p></div><?php endif; ?>

            <div class="bg-gray-50 rounded-2xl p-6">
                <?php if ($coupon['code']): ?>
                <p class="text-xs text-gray-500 font-medium mb-3">Clique para revelar o código e abrir a loja:</p>
                <?php
                $redirectUrl = $coupon['affiliate_url'] ? '/redirect/' . $coupon['id'] : '';
                ?>
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <button onclick="revealCoupon('<?= e($coupon['code']) ?>', '<?= e($redirectUrl) ?>', this)"
                        class="flex-1 w-full coupon-code px-5 py-4 rounded-xl text-center text-xl font-bold text-primary-700 hover:bg-primary-100 transition-colors cursor-pointer">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <?= e(mask_code($coupon['code'])) ?>
                        </span>
                    </button>
                    <?php if ($coupon['affiliate_url']): ?>
                    <a href="/redirect/<?= $coupon['id'] ?>" target="_blank" rel="nofollow noopener" class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-base font-bold hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/25 text-center">Ir à Loja</a>
                    <?php endif; ?>
                </div>
                <?php elseif ($coupon['affiliate_url']): ?>
                <a href="/redirect/<?= $coupon['id'] ?>" target="_blank" rel="nofollow noopener" class="block w-full px-8 py-4 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-base font-bold hover:from-primary-700 hover:to-primary-800 transition-all shadow-lg shadow-primary-500/25 text-center">Ir à Loja</a>
                <?php endif; ?>
            </div>
            <?php if ($coupon['expiry_date']): ?>
            <p class="text-sm text-gray-400 mt-4 flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Válido até <?= date('d/m/Y', strtotime($coupon['expiry_date'])) ?>
            </p>
            <?php endif; ?>
        </div>
    </div>

    <?php if ($relatedCoupons): ?>
    <div class="mt-12">
        <h2 class="text-xl font-bold text-gray-900 mb-6">Cupons Relacionados</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <?php foreach ($relatedCoupons as $rc): ?>
            <div class="gradient-card bg-white rounded-2xl border border-gray-100 p-5 shadow-sm hover:shadow-lg">
                <div class="flex items-start justify-between">
                    <div>
                        <?php if ($rc['store_name']): ?><p class="text-xs text-gray-400 font-medium uppercase"><?= e($rc['store_name']) ?></p><?php endif; ?>
                        <h3 class="font-bold text-gray-900 mt-1"><a href="/cupom/<?= e($rc['slug']) ?>" class="hover:text-primary-600"><?= e($rc['title']) ?></a></h3>
                    </div>
                    <?php if ($rc['discount_value']): ?><span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-lg text-sm font-bold"><?= $rc['discount_type'] === 'percentage' ? e($rc['discount_value']) . '%' : 'R$' . e($rc['discount_value']) ?></span><?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
