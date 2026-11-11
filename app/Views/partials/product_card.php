<?php
/**
 * Partial Kartu Produk
 * Diperlukan variabel: $product (array produk)
 */
$isOutOfStock = ($product['stock'] <= 0);
$isLowStock = ($product['stock'] > 0 && $product['stock'] <= 5);
?>
<div class="toy-card h-100">
    <div class="toy-card-img-wrapper">
        <a href="<?= base_url('produk/' . $product['slug']) ?>">
            <img src="<?= product_image($product['image'] ?? null) ?>" alt="<?= esc($product['name']) ?>" loading="lazy">
        </a>

        <!-- Badges -->
        <div class="toy-card-badges">
            <?php if (!empty($product['is_featured'])): ?>
                <span class="badge-featured"><i class="bi bi-star-fill me-1"></i>Unggulan</span>
            <?php endif; ?>
            <?php if (!empty($product['age_range'])): ?>
                <span class="badge-age"><i class="bi bi-person-fill me-1"></i><?= esc($product['age_range']) ?></span>
            <?php endif; ?>
        </div>

        <?php if ($isOutOfStock): ?>
            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white text-center py-1 fw-bold" style="font-size: 0.8rem; z-index: 2;">
                Stok Habis
            </div>
        <?php elseif ($isLowStock): ?>
            <div class="position-absolute bottom-0 start-0 end-0 bg-warning text-dark text-center py-1 fw-bold" style="font-size: 0.78rem; z-index: 2;">
                Tersisa <?= $product['stock'] ?> unit!
            </div>
        <?php endif; ?>
    </div>

    <div class="card-body">
        <?php if (!empty($product['category_name'])): ?>
            <div class="text-muted small mb-1">
                <i class="bi bi-tag me-1"></i><?= esc($product['category_name']) ?>
            </div>
        <?php endif; ?>

        <a href="<?= base_url('produk/' . $product['slug']) ?>" class="toy-product-title" title="<?= esc($product['name']) ?>">
            <?= esc($product['name']) ?>
        </a>

        <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
            <span class="toy-price"><?= format_rupiah($product['price']) ?></span>
            <a href="<?= base_url('produk/' . $product['slug']) ?>" class="btn btn-sm <?= $isOutOfStock ? 'btn-secondary disabled' : 'btn-toy-outline' ?> px-3">
                <?= $isOutOfStock ? 'Habis' : 'Detail' ?>
            </a>
        </div>
    </div>
</div>

