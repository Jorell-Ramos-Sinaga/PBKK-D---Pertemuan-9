<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Katalog Produk</li>
        <?php if (!empty($activeCategory)): ?>
            <li class="breadcrumb-item active text-primary" aria-current="page"><?= esc($activeCategory['name']) ?></li>
        <?php endif; ?>
    </ol>
</nav>

<div class="row g-4">
    <!-- Sidebar Filter (Kiri) -->
    <div class="col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white sticky-lg-top" style="top: 85px;">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-funnel-fill text-primary me-2"></i>Filter Produk</h5>
                <a href="<?= base_url('produk') ?>" class="btn btn-sm btn-link text-danger text-decoration-none p-0 fw-bold">Reset</a>
            </div>

            <form action="<?= base_url('produk') ?>" method="get">
                <!-- Keep search query if any -->
                <?php if (!empty($keyword)): ?>
                    <input type="hidden" name="q" value="<?= esc($keyword) ?>">
                <?php endif; ?>

                <!-- Filter Kategori -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small text-uppercase">Kategori</label>
                    <div class="d-flex flex-column gap-2" style="max-height: 250px; overflow-y: auto;">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="kategori" id="cat_all" value="" <?= empty($categorySlug) ? 'checked' : '' ?> onchange="this.form.submit()">
                            <label class="form-check-label small" for="cat_all">
                                Semua Kategori
                            </label>
                        </div>
                        <?php foreach ($categories as $cat): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori" id="cat_<?= $cat['id'] ?>" value="<?= esc($cat['slug']) ?>" <?= ($categorySlug === $cat['slug']) ? 'checked' : '' ?> onchange="this.form.submit()">
                                <label class="form-check-label small" for="cat_<?= $cat['id'] ?>">
                                    <?= esc($cat['name']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <hr class="text-muted">

                <!-- Filter Rentang Harga -->
                <div class="mb-4">
                    <label class="form-label fw-bold text-dark small text-uppercase">Rentang Harga (Rp)</label>
                    <div class="mb-2">
                        <input type="number" name="min" class="form-control form-control-sm rounded-3" placeholder="Harga Minimum" value="<?= esc($minPrice ?? '') ?>" min="0">
                    </div>
                    <div class="mb-3">
                        <input type="number" name="maks" class="form-control form-control-sm rounded-3" placeholder="Harga Maksimum" value="<?= esc($maxPrice ?? '') ?>" min="0">
                    </div>
                    <button type="submit" class="btn btn-toy-primary btn-sm w-100 rounded-pill">
                        Terapkan Harga
                    </button>
                </div>

                <!-- Preserve Sort Option -->
                <input type="hidden" name="urut" value="<?= esc($sortBy) ?>">
            </form>
        </div>
    </div>

    <!-- Area Produk (Kanan) -->
    <div class="col-lg-9">
        <!-- Toolbar Atas: Hasil & Sorting -->
        <div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
            <div class="row align-items-center">
                <div class="col-md-6 mb-2 mb-md-0">
                    <span class="text-muted small">
                        Menampilkan <strong><?= count($products) ?></strong> dari <strong><?= $totalItems ?></strong> produk mainan
                        <?php if (!empty($keyword)): ?>
                            untuk pencarian "<em><?= esc($keyword) ?></em>"
                        <?php endif; ?>
                    </span>
                </div>
                <div class="col-md-6 d-flex justify-content-md-end align-items-center gap-2">
                    <label for="sortSelect" class="form-label mb-0 small fw-bold text-nowrap">Urutkan:</label>
                    <form action="<?= base_url('produk') ?>" method="get" id="sortForm" class="d-inline-block">
                        <?php if (!empty($keyword)): ?><input type="hidden" name="q" value="<?= esc($keyword) ?>"><?php endif; ?>
                        <?php if (!empty($categorySlug)): ?><input type="hidden" name="kategori" value="<?= esc($categorySlug) ?>"><?php endif; ?>
                        <?php if (!empty($minPrice)): ?><input type="hidden" name="min" value="<?= esc($minPrice) ?>"><?php endif; ?>
                        <?php if (!empty($maxPrice)): ?><input type="hidden" name="maks" value="<?= esc($maxPrice) ?>"><?php endif; ?>

                        <select name="urut" id="sortSelect" class="form-select form-select-sm rounded-pill" onchange="document.getElementById('sortForm').submit()">
                            <option value="terbaru" <?= $sortBy === 'terbaru' ? 'selected' : '' ?>>Terbaru</option>
                            <option value="termurah" <?= $sortBy === 'termurah' ? 'selected' : '' ?>>Harga Termurah</option>
                            <option value="termahal" <?= $sortBy === 'termahal' ? 'selected' : '' ?>>Harga Termahal</option>
                            <option value="nama-asc" <?= $sortBy === 'nama-asc' ? 'selected' : '' ?>>Nama A - Z</option>
                        </select>
                    </form>
                </div>
            </div>
        </div>

        <!-- Grid Produk -->
        <?php if (!empty($products)): ?>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-4 mb-4">
                <?php foreach ($products as $product): ?>
                    <div class="col">
                        <?= view('partials/product_card', ['product' => $product]) ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination Bootstrap 5 -->
            <div class="d-flex justify-content-center mt-5">
                <?= $pager->links('products', 'default_full') ?>
            </div>
        <?php else: ?>
            <!-- Kosong / Tidak Ada Produk -->
            <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
                <i class="bi bi-emoji-frown text-warning display-1 mb-3"></i>
                <h4 class="fw-bold">Tidak ada produk yang cocok</h4>
                <p class="text-muted mb-4">Coba ubah kata kunci pencarian atau sesuaikan pilihan filter Anda.</p>
                <a href="<?= base_url('produk') ?>" class="btn btn-toy-primary rounded-pill px-4">
                    Reset Semua Filter
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
