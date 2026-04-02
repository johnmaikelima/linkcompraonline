<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <p class="text-gray-500 text-sm"><?= $total ?> produtos no total</p>
    <a href="/admin/produtos/criar" class="px-5 py-2 bg-primary-600 text-white rounded-xl text-sm font-semibold hover:bg-primary-700 transition shadow-sm flex items-center gap-2">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Novo Produto
    </a>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-100 bg-gray-50/50">
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Produto</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Preço</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Loja</th>
                    <th class="text-left px-5 py-3 font-semibold text-gray-600">Categoria</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600">Views</th>
                    <th class="text-center px-5 py-3 font-semibold text-gray-600">Status</th>
                    <th class="text-right px-5 py-3 font-semibold text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($products as $p): ?>
                <tr class="hover:bg-gray-50/50">
                    <td class="px-5 py-3">
                        <div class="flex items-center gap-3">
                            <?php if ($p['image']): ?>
                            <img src="<?= e($p['image']) ?>" class="w-10 h-10 rounded-lg object-cover">
                            <?php else: ?>
                            <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            </div>
                            <?php endif; ?>
                            <p class="font-medium text-gray-900 line-clamp-1"><?= e($p['title']) ?></p>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <?php if ($p['price']): ?>
                        <span class="font-semibold text-primary-600">R$ <?= e($p['price']) ?></span>
                        <?php if ($p['original_price']): ?>
                        <span class="text-xs text-gray-400 line-through ml-1">R$ <?= e($p['original_price']) ?></span>
                        <?php endif; ?>
                        <?php else: ?>-<?php endif; ?>
                    </td>
                    <td class="px-5 py-3 text-gray-500 text-xs"><?= e($p['store_name'] ?? '') ?: '<span class="text-gray-300">-</span>' ?></td>
                    <td class="px-5 py-3 text-gray-500 text-xs"><?= e($p['category_name'] ?? '-') ?></td>
                    <td class="px-5 py-3 text-center text-gray-600"><?= number_format($p['views']) ?></td>
                    <td class="px-5 py-3 text-center">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium <?= $p['active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                            <?= $p['active'] ? 'Ativo' : 'Inativo' ?>
                        </span>
                    </td>
                    <td class="px-5 py-3 text-right">
                        <div class="flex items-center justify-end gap-2">
                            <a href="/produto/<?= e($p['slug']) ?>" target="_blank" class="p-1.5 text-gray-400 hover:text-blue-600 rounded-lg hover:bg-blue-50 transition" title="Ver no site">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="/admin/produtos/editar/<?= $p['id'] ?>" class="p-1.5 text-gray-400 hover:text-primary-600 rounded-lg hover:bg-primary-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="/admin/produtos/excluir/<?= $p['id'] ?>" onsubmit="return confirm('Excluir este produto?')">
                                <?= csrf_field() ?>
                                <button class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php if (!$products): ?>
    <div class="text-center py-12">
        <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        <p class="text-gray-500">Nenhum produto criado</p>
        <a href="/admin/produtos/criar" class="inline-block mt-3 text-primary-600 font-semibold text-sm">Criar primeiro produto</a>
    </div>
    <?php endif; ?>
</div>
