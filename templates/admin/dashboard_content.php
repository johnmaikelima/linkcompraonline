<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5 mb-8">
    <?php
    $statCards = [
        ['Cupons Ativos', $stats['active_coupons'], 'bg-gradient-to-br from-indigo-500 to-purple-600', 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
        ['Páginas de Produto', $stats['total_products'], 'bg-gradient-to-br from-emerald-500 to-teal-600', 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
        ['Categorias', $stats['total_categories'], 'bg-gradient-to-br from-amber-500 to-orange-600', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['Total de Cliques', $stats['total_clicks'], 'bg-gradient-to-br from-pink-500 to-rose-600', 'M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122'],
        ['Visualizações', $stats['total_views'], 'bg-gradient-to-br from-cyan-500 to-blue-600', 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z'],
        ['Total de Cupons', $stats['total_coupons'], 'bg-gradient-to-br from-violet-500 to-indigo-600', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
    ];
    foreach ($statCards as $card): ?>
    <div class="<?= $card[2] ?> rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-white/80"><?= $card[0] ?></p>
                <p class="text-3xl font-bold mt-1"><?= number_format($card[1]) ?></p>
            </div>
            <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?= $card[3] ?>"/></svg>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Cupons Recentes</h2>
            <a href="/admin/cupons/criar" class="text-sm text-primary-600 font-semibold hover:text-primary-700">+ Novo</a>
        </div>
        <div class="divide-y divide-gray-50">
            <?php foreach ($recent_coupons as $c): ?>
            <div class="px-5 py-3 flex items-center justify-between hover:bg-gray-50">
                <div>
                    <p class="font-medium text-gray-900 text-sm"><?= e($c['title']) ?></p>
                    <p class="text-xs text-gray-400"><?= e($c['store_name']) ?></p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium <?= $c['active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                        <?= $c['active'] ? 'Ativo' : 'Inativo' ?>
                    </span>
                    <a href="/admin/cupons/editar/<?= $c['id'] ?>" class="text-gray-400 hover:text-primary-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php if (!$recent_coupons): ?>
            <p class="px-5 py-8 text-center text-sm text-gray-400">Nenhum cupom criado ainda</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-5 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Top Cupons (Cliques)</h2>
        </div>
        <div class="divide-y divide-gray-50">
            <?php foreach ($top_coupons as $i => $c): ?>
            <div class="px-5 py-3 flex items-center gap-3 hover:bg-gray-50">
                <span class="w-7 h-7 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold"><?= $i + 1 ?></span>
                <div class="flex-1 min-w-0">
                    <p class="font-medium text-gray-900 text-sm truncate"><?= e($c['title']) ?></p>
                </div>
                <span class="text-sm font-semibold text-gray-600"><?= number_format($c['clicks']) ?> cliques</span>
            </div>
            <?php endforeach; ?>
            <?php if (!$top_coupons): ?>
            <p class="px-5 py-8 text-center text-sm text-gray-400">Sem dados ainda</p>
            <?php endif; ?>
        </div>
    </div>
</div>
