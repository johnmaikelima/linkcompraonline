<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="/" class="hover:text-primary-600">Início</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span>Produto</span>
        <?php if ($product['category_name']): ?>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <a href="/categoria/<?= e($product['category_slug']) ?>" class="hover:text-primary-600"><?= e($product['category_name']) ?></a>
        <?php endif; ?>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden shadow-sm sticky top-24">
                <?php if ($product['image']): ?>
                <img src="<?= e($product['image']) ?>" alt="<?= e($product['title']) ?>" class="w-full aspect-square object-cover">
                <?php else: ?>
                <div class="w-full aspect-square bg-gradient-to-br from-primary-100 to-accent-100 flex items-center justify-center">
                    <svg class="w-20 h-20 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="lg:col-span-3">
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8">
                <?php if ($product['category_name']): ?><span class="px-3 py-1 bg-primary-50 text-primary-700 rounded-full text-sm font-semibold"><?= e($product['category_name']) ?></span><?php endif; ?>
                <h1 class="text-3xl font-bold text-gray-900 mt-3 mb-4"><?= e($product['title']) ?></h1>

                <?php if ($product['rating'] > 0): ?>
                <div class="flex items-center gap-2 mb-4">
                    <div class="flex text-amber-400">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-5 h-5 <?= $i <= $product['rating'] ? 'fill-current' : 'text-gray-200' ?>" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <?php endfor; ?>
                    </div>
                    <span class="text-sm text-gray-500"><?= number_format($product['rating'], 1) ?>/5</span>
                </div>
                <?php endif; ?>

                <?php if ($product['price']): ?>
                <div class="flex items-baseline gap-3 mb-6">
                    <?php if ($product['original_price']): ?><span class="text-lg text-gray-400 line-through">R$ <?= e($product['original_price']) ?></span><?php endif; ?>
                    <span class="text-4xl font-extrabold text-primary-600">R$ <?= e($product['price']) ?></span>
                    <?php if ($product['original_price'] && $product['price']):
                        $orig = (float)str_replace(',', '.', $product['original_price']);
                        $curr = (float)str_replace(',', '.', $product['price']);
                        $disc = $orig > 0 ? round((1 - $curr / $orig) * 100) : 0;
                        if ($disc > 0): ?>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">-<?= $disc ?>%</span>
                    <?php endif; endif; ?>
                </div>
                <?php endif; ?>

                <?php if ($product['description']): ?><p class="text-gray-600 leading-relaxed mb-6"><?= nl2br(e($product['description'])) ?></p><?php endif; ?>

                <?php
                $primaryUrl = $product['buy_url'] ?: $product['amazon_url'];
                $primaryLabel = $product['buy_url'] ? ('Comprar' . ($product['store_name'] ? ' na ' . e($product['store_name']) : '')) : 'Comprar na Amazon';
                $showAmazonSecondary = $product['buy_url'] && $product['amazon_url'];
                ?>

                <?php if ($primaryUrl): ?>
                <a href="<?= e($primaryUrl) ?>" target="_blank" rel="nofollow noopener" class="inline-flex items-center gap-3 px-8 py-4 bg-gradient-to-r from-primary-500 to-primary-600 text-white rounded-2xl text-lg font-bold hover:from-primary-600 hover:to-primary-700 transition-all shadow-lg shadow-primary-500/25 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    <?= $primaryLabel ?>
                </a>
                <?php endif; ?>

                <?php if ($showAmazonSecondary): ?>
                <a href="<?= e($product['amazon_url']) ?>" target="_blank" rel="nofollow noopener" class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-xl text-sm font-bold hover:from-amber-600 hover:to-amber-700 transition-all shadow-sm mb-4 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Ver na Amazon
                </a>
                <?php endif; ?>

                <?php if ($product['store_name'] && $product['store_url'] && !$product['buy_url']): ?>
                <p class="text-sm text-gray-500 mb-6">Vendido por <a href="<?= e($product['store_url']) ?>" target="_blank" class="text-primary-600 hover:underline font-medium"><?= e($product['store_name']) ?></a></p>
                <?php elseif ($product['store_name']): ?>
                <p class="text-sm text-gray-500 mb-6">Vendido por <strong><?= e($product['store_name']) ?></strong></p>
                <?php endif; ?>

                <?php if ($product['pros'] || $product['cons']): ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
                    <?php if ($product['pros']): ?>
                    <div class="bg-green-50 rounded-2xl p-5">
                        <h3 class="font-bold text-green-800 mb-3">Pontos Positivos</h3>
                        <ul class="space-y-2">
                            <?php foreach (explode("\n", $product['pros']) as $pro): if (trim($pro)): ?>
                            <li class="flex items-start gap-2 text-sm text-green-700"><svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg><?= e(trim($pro)) ?></li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                    <?php if ($product['cons']): ?>
                    <div class="bg-red-50 rounded-2xl p-5">
                        <h3 class="font-bold text-red-800 mb-3">Pontos Negativos</h3>
                        <ul class="space-y-2">
                            <?php foreach (explode("\n", $product['cons']) as $con): if (trim($con)): ?>
                            <li class="flex items-start gap-2 text-sm text-red-700"><svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg><?= e(trim($con)) ?></li>
                            <?php endif; endforeach; ?>
                        </ul>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($product['content']): ?>
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Análise Detalhada</h2>
                <div class="prose prose-gray max-w-none text-gray-600 leading-relaxed"><?= nl2br(e($product['content'])) ?></div>
            </div>
            <?php endif; ?>

            <?php if ($relatedCoupons): ?>
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-4">Cupons Relacionados</h2>
                <div class="space-y-3">
                    <?php foreach ($relatedCoupons as $rc): ?>
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl hover:bg-primary-50 transition-colors">
                        <div>
                            <h4 class="font-semibold text-gray-900"><a href="/cupom/<?= e($rc['slug']) ?>" class="hover:text-primary-600"><?= e($rc['title']) ?></a></h4>
                            <?php if ($rc['store_name']): ?><p class="text-xs text-gray-400"><?= e($rc['store_name']) ?></p><?php endif; ?>
                        </div>
                        <?php if ($rc['discount_value']): ?><span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-lg text-sm font-bold"><?= $rc['discount_type'] === 'percentage' ? e($rc['discount_value']) . '%' : 'R$' . e($rc['discount_value']) ?></span><?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
