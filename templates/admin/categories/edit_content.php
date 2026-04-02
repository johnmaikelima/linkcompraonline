<div class="max-w-4xl">
    <a href="/admin/categorias" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-primary-600 mb-6">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Voltar às categorias
    </a>

    <form method="POST" action="/admin/categorias/editar/<?= $category['id'] ?>" class="space-y-6">
        <?= csrf_field() ?>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Informações Básicas</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome *</label>
                    <input type="text" name="name" required value="<?= e($category['name']) ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Ícone</label>
                    <input type="text" name="icon" value="<?= e($category['icon']) ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="tag, laptop, home...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Cor</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="color" value="<?= e($category['color']) ?>" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer">
                        <span class="text-sm text-gray-500"><?= e($category['color']) ?></span>
                    </div>
                </div>
            </div>
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="active" value="1" <?= $category['active'] ? 'checked' : '' ?> class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <span class="text-sm text-gray-700">Categoria ativa</span>
            </label>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Descrição & SEO</h2>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição da Categoria</label>
                <p class="text-xs text-gray-400 mb-2">Texto curto que aparece no topo da página da categoria</p>
                <textarea name="description" rows="3" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="Descreva esta categoria para seus visitantes..."><?= e($category['description'] ?? '') ?></textarea>
            </div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900 text-lg">Artigo da Categoria</h2>
                    <p class="text-xs text-gray-400 mt-1">Conteúdo HTML que será exibido abaixo dos cupons na página da categoria. Aceita tags HTML para formatação rica.</p>
                </div>
            </div>
            <div>
                <textarea name="article" rows="18" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono" placeholder="<h2>Guia Completo de Cupons de Tecnologia</h2>
<p>Aqui você encontra os melhores cupons...</p>
<h3>Como usar nossos cupons</h3>
<p>Basta clicar no botão...</p>"><?= e($category['article'] ?? '') ?></textarea>
            </div>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-700">
                <strong>Dica:</strong> Use tags HTML como <code class="bg-amber-100 px-1 rounded">&lt;h2&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;h3&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;p&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;ul&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;ol&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;strong&gt;</code>, <code class="bg-amber-100 px-1 rounded">&lt;a href="..."&gt;</code> para formatar o conteúdo. O artigo aparecerá com estilização automática do Tailwind.
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition shadow-sm">
                Salvar Categoria
            </button>
            <a href="/admin/categorias" class="px-6 py-3 text-gray-600 hover:text-gray-800 font-medium text-sm">Cancelar</a>
        </div>
    </form>
</div>
