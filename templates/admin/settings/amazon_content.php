<div class="max-w-3xl space-y-6">
    <div class="bg-gradient-to-r from-amber-500 to-orange-500 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex items-center gap-4">
            <div class="w-14 h-14 bg-white/20 rounded-2xl flex items-center justify-center">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
            </div>
            <div>
                <h2 class="text-xl font-bold">Amazon Product Advertising API</h2>
                <p class="text-white/80 text-sm">Configure sua integração com o programa de Associados da Amazon</p>
            </div>
        </div>
    </div>

    <form method="POST" action="/admin/configuracoes/amazon" class="space-y-6">
        <?= csrf_field() ?>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-5">
            <h2 class="font-bold text-gray-900 text-lg">Credenciais da API</h2>
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-700">
                <strong>Importante:</strong> Para usar a API da Amazon, você precisa de uma conta no
                <strong>Amazon Associates</strong> (Programa de Associados). As credenciais são obtidas no
                painel do programa após aprovação.
            </div>

            <div class="grid grid-cols-1 gap-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Access Key</label>
                    <input type="text" name="amazon_access_key" value="<?= e($settings['amazon_access_key'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono" placeholder="AKIAIOSFODNN7EXAMPLE">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Secret Key</label>
                    <input type="password" name="amazon_secret_key" value="<?= e($settings['amazon_secret_key'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent font-mono" placeholder="wJalrXUtnFEMI/K7MDENG/bPxRfiCYEXAMPLEKEY">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Partner Tag (Tag de Associado)</label>
                    <input type="text" name="amazon_partner_tag" value="<?= e($settings['amazon_partner_tag'] ?? '') ?>" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent" placeholder="seunome-20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Região</label>
                    <select name="amazon_region" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="BR" <?= ($settings['amazon_region'] ?? '') === 'BR' ? 'selected' : '' ?>>Brasil (amazon.com.br)</option>
                        <option value="US" <?= ($settings['amazon_region'] ?? '') === 'US' ? 'selected' : '' ?>>Estados Unidos (amazon.com)</option>
                        <option value="ES" <?= ($settings['amazon_region'] ?? '') === 'ES' ? 'selected' : '' ?>>Espanha (amazon.es)</option>
                        <option value="PT" <?= ($settings['amazon_region'] ?? '') === 'PT' ? 'selected' : '' ?>>Portugal (amazon.pt)</option>
                    </select>
                </div>
            </div>

            <label class="flex items-center gap-3 cursor-pointer pt-2">
                <input type="hidden" name="amazon_api_enabled" value="0">
                <input type="checkbox" name="amazon_api_enabled" value="1" <?= ($settings['amazon_api_enabled'] ?? '0') === '1' ? 'checked' : '' ?> class="w-5 h-5 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <div>
                    <span class="text-sm font-medium text-gray-700">Ativar API da Amazon</span>
                    <p class="text-xs text-gray-400">Habilita buscas automáticas de produtos e preços</p>
                </div>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="px-8 py-3 bg-primary-600 text-white rounded-xl font-semibold hover:bg-primary-700 transition shadow-sm">
                Salvar Configurações
            </button>
        </div>
    </form>

    <!-- Botão de teste -->
    <form method="POST" action="/admin/configuracoes/amazon/testar" class="inline">
        <?= csrf_field() ?>
        <button type="submit" class="px-6 py-2.5 bg-amber-500 text-white rounded-xl text-sm font-semibold hover:bg-amber-600 transition shadow-sm flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Testar Conexão
        </button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-bold text-gray-900 text-lg mb-4">Como Configurar</h2>
        <ol class="space-y-3 text-sm text-gray-600">
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">1</span>
                Crie uma conta no <strong>Programa de Associados da Amazon</strong> (associados.amazon.com.br)
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">2</span>
                Após aprovação, acesse <strong>Ferramentas > Product Advertising API</strong>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">3</span>
                Gere suas credenciais (Access Key e Secret Key)
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">4</span>
                Cole as credenciais nos campos acima e sua <strong>Tag de Associado</strong>
            </li>
            <li class="flex gap-3">
                <span class="w-6 h-6 bg-primary-100 text-primary-700 rounded-lg flex items-center justify-center text-xs font-bold flex-shrink-0">5</span>
                Clique em <strong>Testar Conexão</strong> para verificar se tudo está funcionando
            </li>
        </ol>
    </div>
</div>
