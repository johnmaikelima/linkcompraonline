<?php $isEdit = !empty($product); ?>

<div class="max-w-4xl">
    <a href="/admin/produtos" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Voltar aos produtos
    </a>

    <form method="POST" action="<?= $isEdit ? '/admin/produtos/editar/' . $product['id'] : '/admin/produtos/criar' ?>" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        <?php if ($isEdit && $product['image']): ?>
        <input type="hidden" name="current_image" value="<?= e($product['image']) ?>">
        <?php endif; ?>

        <!-- Informações Básicas -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Informações do Produto</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Título *</label>
                    <input type="text" name="title" required value="<?= e($product['title'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição Curta</label>
                    <textarea name="description" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"><?= e($product['description'] ?? '') ?></textarea>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Conteúdo / Análise Detalhada</label>
                    <textarea name="content" rows="8" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"><?= e($product['content'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Preço -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Preço & Avaliação</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Preço Atual (R$)</label>
                    <input type="text" name="price" value="<?= e($product['price'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="99,90">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Preço Original (R$)</label>
                    <input type="text" name="original_price" value="<?= e($product['original_price'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="149,90">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Avaliação (0-5)</label>
                    <input type="number" name="rating" min="0" max="5" step="0.1" value="<?= e($product['rating'] ?? '0') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <!-- Loja & Link de Compra -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div>
                <h2 class="font-bold text-gray-900 text-lg">Loja & Link de Compra</h2>
                <p class="text-xs text-gray-400 mt-1">Configure de onde o produto será comprado. Pode ser Amazon, Mercado Livre, Shopee, Kabum, ou qualquer outra loja.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome da Loja</label>
                    <input type="text" name="store_name" value="<?= e($product['store_name'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Ex: Amazon, Mercado Livre, Shopee, Kabum...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Site da Loja (opcional)</label>
                    <input type="url" name="store_url" value="<?= e($product['store_url'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="https://www.nomedaLoja.com.br">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Link de Compra / Afiliado</label>
                    <p class="text-xs text-gray-400 mb-2">Cole aqui o link de afiliado de qualquer loja. Este será o botão principal "Comprar" na página do produto.</p>
                    <input type="url" name="buy_url" value="<?= e($product['buy_url'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="https://link-de-afiliado.com/produto...">
                </div>
            </div>
        </div>

        <!-- Amazon (opcional) -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                </div>
                <div>
                    <h2 class="font-bold text-gray-900 text-lg">Amazon (Opcional)</h2>
                    <p class="text-xs text-gray-400">Se o produto for da Amazon, preencha estes campos adicionais para integração com a API</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">URL da Amazon</label>
                    <input type="url" name="amazon_url" value="<?= e($product['amazon_url'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="https://amazon.com.br/dp/...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Amazon ASIN</label>
                    <input type="text" name="amazon_asin" value="<?= e($product['amazon_asin'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="B0XXXXXXXX">
                </div>
            </div>
            <div class="bg-gray-50 rounded-xl p-3 text-xs text-gray-500">
                <strong>Dica:</strong> Se preencher o "Link de Compra" acima E a "URL da Amazon", o botão principal usará o Link de Compra. A URL da Amazon será usada como link secundário.
            </div>
        </div>

        <!-- Prós & Contras -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Prós & Contras</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pontos Positivos (um por linha)</label>
                    <textarea name="pros" rows="5" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Boa qualidade&#10;Preço acessível&#10;Entrega rápida"><?= e($product['pros'] ?? '') ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Pontos Negativos (um por linha)</label>
                    <textarea name="cons" rows="5" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Poderia ser menor&#10;Sem garantia estendida"><?= e($product['cons'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Mídia, Categoria & SEO -->
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Mídia, Categoria & SEO</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Imagem</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <?php if ($isEdit && $product['image']): ?>
                    <img src="<?= e($product['image']) ?>" class="mt-2 w-20 h-20 rounded-lg object-cover">
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria</label>
                    <select name="category_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Título SEO</label>
                    <input type="text" name="seo_title" value="<?= e($product['seo_title'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição SEO</label>
                    <input type="text" name="seo_description" value="<?= e($product['seo_description'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>

            <label class="flex items-center gap-2 cursor-pointer pt-2">
                <input type="checkbox" name="active" value="1" <?= ($product['active'] ?? 1) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="text-sm text-gray-700">Ativo</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition shadow-sm">
                <?= $isEdit ? 'Atualizar Produto' : 'Criar Produto' ?>
            </button>
            <a href="/admin/produtos" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium text-sm">Cancelar</a>
        </div>
    </form>
</div>
