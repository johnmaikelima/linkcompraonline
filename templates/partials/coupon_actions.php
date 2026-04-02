<?php
/**
 * Partial: Coupon code + action buttons
 * Expects $coupon array with: id, code, affiliate_url
 * Shows masked code that reveals on click + redirects to affiliate
 */
$redirectUrl = $coupon['affiliate_url'] ? '/redirect/' . $coupon['id'] : '';
?>
<div class="flex items-center gap-3">
    <?php if ($coupon['code']): ?>
    <button onclick="revealCoupon('<?= e($coupon['code']) ?>', '<?= e($redirectUrl) ?>', this)"
        class="flex-1 coupon-code px-4 py-2.5 rounded-xl text-center text-sm font-bold text-primary-700 hover:bg-primary-100 transition-colors cursor-pointer relative group">
        <span class="flex items-center justify-center gap-2">
            <svg class="w-4 h-4 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            <?= e(mask_code($coupon['code'])) ?>
        </span>
    </button>
    <?php elseif ($coupon['affiliate_url']): ?>
    <a href="/redirect/<?= $coupon['id'] ?>" target="_blank" rel="nofollow noopener"
        class="flex-1 px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-semibold hover:from-primary-700 hover:to-primary-800 transition-all shadow-sm text-center">
        Ir à Loja
    </a>
    <?php endif; ?>
    <?php if ($coupon['code'] && $coupon['affiliate_url']): ?>
    <a href="/redirect/<?= $coupon['id'] ?>" target="_blank" rel="nofollow noopener"
        class="px-5 py-2.5 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-xl text-sm font-semibold hover:from-primary-700 hover:to-primary-800 transition-all shadow-sm whitespace-nowrap">
        Ir à Loja
    </a>
    <?php endif; ?>
</div>
