<?php $isEdit = !empty($coupon); ?>

<div class="max-w-4xl">
    <a href="/admin/cupons" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Voltar aos cupons
    </a>

    <form method="POST" action="<?= $isEdit ? '/admin/cupons/editar/' . $coupon['id'] : '/admin/cupons/criar' ?>" enctype="multipart/form-data" class="space-y-6">
        <?= csrf_field() ?>
        <?php if ($isEdit && $coupon['image']): ?>
        <input type="hidden" name="current_image" value="<?= e($coupon['image']) ?>">
        <?php endif; ?>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Informações Básicas</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Título *</label>
                    <input type="text" name="title" required value="<?= e($coupon['title'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome da Loja</label>
                    <input type="text" name="store_name" value="<?= e($coupon['store_name'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Logo da Loja (URL)</label>
                    <input type="url" name="store_logo" value="<?= e($coupon['store_logo'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"><?= e($coupon['description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Cupom & Desconto</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Código do Cupom</label>
                    <input type="text" name="code" value="<?= e($coupon['code'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Tipo de Desconto</label>
                    <select name="discount_type" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="percentage" <?= ($coupon['discount_type'] ?? '') === 'percentage' ? 'selected' : '' ?>>Porcentagem (%)</option>
                        <option value="fixed" <?= ($coupon['discount_type'] ?? '') === 'fixed' ? 'selected' : '' ?>>Valor Fixo (R$)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Valor do Desconto</label>
                    <input type="text" name="discount_value" value="<?= e($coupon['discount_value'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Links & Amazon</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">URL de Afiliado</label>
                    <input type="url" name="affiliate_url" value="<?= e($coupon['affiliate_url'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="https://...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Amazon ASIN</label>
                    <input type="text" name="amazon_asin" value="<?= e($coupon['amazon_asin'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="B0XXXXXXXX">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Data de Expiração</label>
                    <input type="date" name="expiry_date" value="<?= e($coupon['expiry_date'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Mídia & Categoria</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Imagem</label>
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100">
                    <?php if ($isEdit && $coupon['image']): ?>
                    <img src="<?= e($coupon['image']) ?>" class="mt-2 w-20 h-20 rounded-lg object-cover">
                    <?php endif; ?>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Categoria</label>
                    <select name="category_id" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Sem categoria</option>
                        <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>" <?= ($coupon['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>><?= e($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="flex flex-wrap gap-6 pt-2">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="active" value="1" <?= ($coupon['active'] ?? 1) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Ativo</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" <?= ($coupon['is_featured'] ?? 0) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Destaque</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="is_verified" value="1" <?= ($coupon['is_verified'] ?? 0) ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <span class="text-sm text-gray-700">Verificado</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition shadow-sm">
                <?= $isEdit ? 'Atualizar Cupom' : 'Criar Cupom' ?>
            </button>
            <a href="/admin/cupons" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium text-sm">Cancelar</a>
        </div>
    </form>
</div>
