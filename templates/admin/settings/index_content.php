<form method="POST" action="/admin/configuracoes" class="max-w-3xl space-y-6">
    <?= csrf_field() ?>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <h2 class="font-bold text-gray-900 text-lg">Configurações Gerais</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Nome do Site</label>
                <input type="text" name="site_name" value="<?= e($settings['site_name'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Descrição do Site</label>
                <textarea name="site_description" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"><?= e($settings['site_description'] ?? '') ?></textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Palavras-chave (SEO)</label>
                <input type="text" name="site_keywords" value="<?= e($settings['site_keywords'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <h2 class="font-bold text-gray-900 text-lg">Aparência</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Título do Hero</label>
                <input type="text" name="hero_title" value="<?= e($settings['hero_title'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Subtítulo do Hero</label>
                <textarea name="hero_subtitle" rows="2" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent"><?= e($settings['hero_subtitle'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Cor Primária</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="primary_color" value="<?= e($settings['primary_color'] ?? '#6366f1') ?>" class="w-10 h-10 rounded-lg border border-gray-200 cursor-pointer">
                    <span class="text-sm text-gray-500"><?= e($settings['primary_color'] ?? '#6366f1') ?></span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
        <h2 class="font-bold text-gray-900 text-lg">Rodapé & Analytics</h2>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Texto do Rodapé</label>
            <input type="text" name="footer_text" value="<?= e($settings['footer_text'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Código Analytics (Google Analytics, etc)</label>
            <textarea name="analytics_code" rows="4" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono text-xs" placeholder="<script>...</script>"><?= e($settings['analytics_code'] ?? '') ?></textarea>
        </div>
    </div>

    <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition shadow-sm">
        Salvar Configurações
    </button>
</form>
