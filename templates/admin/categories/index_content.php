<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Formulário de nova categoria -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
            <h2 class="font-bold text-gray-900 text-lg mb-4">Nova Categoria</h2>
            <form method="POST" action="/admin/categorias/criar" class="space-y-4">
                <?= csrf_field() ?>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome *</label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone</label>
                    <input type="text" name="icon" value="tag" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Ex: tag, laptop, home">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cor</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="#6366f1" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer">
                        <span class="text-xs text-gray-400">Clique para escolher</span>
                    </div>
                </div>
                <button type="submit" class="w-full py-2.5 bg-primary-600 text-white rounded-xl text-sm font-semibold hover:bg-primary-700 transition">
                    Criar Categoria
                </button>
            </form>
        </div>
    </div>

    <!-- Lista de categorias -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="divide-y divide-gray-50">
                <?php foreach ($categories as $cat): ?>
                <div class="px-5 py-4 hover:bg-gray-50/50 flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0" style="background: <?= e($cat['color']) ?>20; color: <?= e($cat['color']) ?>">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-semibold text-gray-900"><?= e($cat['name']) ?></h3>
                        <p class="text-xs text-gray-400"><?= $cat['coupon_count'] ?> cupons &middot; <?= e($cat['slug']) ?></p>
                        <?php if ($cat['description']): ?>
                        <p class="text-xs text-gray-500 mt-0.5 truncate"><?= e($cat['description']) ?></p>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center gap-2 flex-shrink-0">
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium <?= $cat['active'] ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                            <?= $cat['active'] ? 'Ativa' : 'Inativa' ?>
                        </span>
                        <?php if ($cat['article']): ?>
                        <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Artigo</span>
                        <?php endif; ?>
                        <a href="/admin/categorias/editar/<?= $cat['id'] ?>" class="p-1.5 text-gray-400 hover:text-primary-600 rounded-lg hover:bg-primary-50 transition" title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        </a>
                        <form method="POST" action="/admin/categorias/excluir/<?= $cat['id'] ?>" onsubmit="return confirm('Excluir categoria?')" class="inline">
                            <?= csrf_field() ?>
                            <button class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg hover:bg-red-50 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (!$categories): ?>
            <div class="text-center py-12">
                <p class="text-gray-500">Nenhuma categoria criada</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
