<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('produk') ?>">Katalog Produk</a></li>
        <?php if (!empty($product['category_name'])): ?>
            <li class="breadcrumb-item"><a href="<?= base_url('produk?kategori=' . $product['category_slug']) ?>"><?= esc($product['category_name']) ?></a></li>
        <?php endif; ?>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($product['name']) ?></li>
    </ol>
</nav>

<!-- Main Detail Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white mb-5">
    <div class="row g-4 g-lg-5">
        <!-- Kolom Gambar Besar -->
        <div class="col-md-5">
            <div class="position-relative rounded-4 overflow-hidden shadow-sm bg-light text-center p-3" style="max-height: 450px;">
                <img src="<?= product_image($product['image'] ?? null) ?>" alt="<?= esc($product['name']) ?>" class="img-fluid rounded-4 w-100" style="object-fit: contain; max-height: 400px;" id="mainProductImage">

                <?php if ($product['is_featured']): ?>
                    <span class="badge-featured position-absolute top-0 start-0 m-3 fs-7">
                        <i class="bi bi-star-fill me-1"></i>Produk Pilihan Unggulan
                    </span>
                <?php endif; ?>
            </div>
        </div>

        <!-- Kolom Informasi Produk & Form Tambah -->
        <div class="col-md-7 d-flex flex-column">
            <!-- Kategori & Rekomendasi Usia -->
            <div class="d-flex flex-wrap gap-2 align-items-center mb-2">
                <?php if (!empty($product['category_name'])): ?>
                    <a href="<?= base_url('produk?kategori=' . $product['category_slug']) ?>" class="badge bg-secondary-subtle text-secondary-emphasis text-decoration-none rounded-pill px-3 py-2">
                        <i class="bi bi-tag-fill me-1"></i><?= esc($product['category_name']) ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($product['age_range'])): ?>
                    <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3 py-2">
                        <i class="bi bi-person-fill me-1"></i>Usia: <?= esc($product['age_range']) ?>
                    </span>
                <?php endif; ?>
            </div>

            <!-- Nama Produk -->
            <h1 class="fw-bold mb-3"><?= esc($product['name']) ?></h1>

            <!-- Harga Produk -->
            <div class="mb-4">
                <span class="fs-1 fw-extrabold text-danger" style="font-family: 'Baloo 2', cursive;">
                    <?= format_rupiah($product['price']) ?>
                </span>
            </div>

            <hr class="text-muted">

            <!-- Ketersediaan Stok -->
            <div class="mb-4">
                <label class="form-label fw-bold text-dark mb-1">Status Ketersediaan:</label>
                <div>
                    <?php if ($product['stock'] <= 0): ?>
                        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                            <i class="bi bi-x-circle-fill me-1"></i>Stok Habis
                        </span>
                    <?php elseif ($product['stock'] <= 5): ?>
                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fs-6">
                            <i class="bi bi-exclamation-circle-fill me-1"></i>Stok Tinggal <?= $product['stock'] ?> unit lagi!
                        </span>
                    <?php else: ?>
                        <span class="badge bg-success rounded-pill px-3 py-2 fs-6">
                            <i class="bi bi-check-circle-fill me-1"></i>Stok Tersedia (<?= $product['stock'] ?> unit)
                        </span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Form Tambah ke Keranjang -->
            <?php if ($product['stock'] > 0): ?>
                <form action="<?= base_url('keranjang/tambah') ?>" method="post" class="mt-2">
                    <?= csrf_field() ?>
                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">

                    <div class="mb-4">
                        <label class="form-label fw-bold mb-2">Jumlah Pembelian:</label>
                        <div class="input-group qty-input-group" style="max-width: 170px;">
                            <button class="btn btn-outline-secondary btn-qty-minus rounded-start-pill px-3" type="button">
                                <i class="bi bi-dash"></i>
                            </button>
                            <input type="number" name="quantity" class="form-control text-center fw-bold" value="1" min="1" max="<?= $product['stock'] ?>" required>
                            <button class="btn btn-outline-secondary btn-qty-plus rounded-end-pill px-3" type="button">
                                <i class="bi bi-plus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <button type="submit" class="btn btn-toy-primary btn-lg px-4 shadow">
                            <i class="bi bi-cart-plus-fill me-2"></i>Tambah ke Keranjang
                        </button>
                        <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                            Lanjut Belanja
                        </a>
                    </div>
                </form>
            <?php else: ?>
                <div class="alert alert-warning rounded-3" role="alert">
                    <i class="bi bi-info-circle-fill me-2"></i>Mohon maaf, stok produk ini saat ini sedang habis. Silakan cek produk sejenis lainnya di bawah.
                </div>
                <div>
                    <a href="<?= base_url('produk') ?>" class="btn btn-toy-primary rounded-pill px-4">
                        Lihat Produk Lainnya
                    </a>
                </div>
            <?php endif; ?>

            <!-- Ringkasan Jaminan Belanja -->
            <div class="mt-auto pt-4">
                <div class="row g-2 border-top pt-3 small text-muted">
                    <div class="col-6"><i class="bi bi-shield-check text-success me-1"></i>100% Produk Berkualitas</div>
                    <div class="col-6"><i class="bi bi-box-seam text-primary me-1"></i>Packing Kardus & Bubble Wrap</div>
                    <div class="col-6"><i class="bi bi-truck text-warning me-1"></i>Pengiriman Seluruh Indonesia</div>
                    <div class="col-6"><i class="bi bi-arrow-repeat text-info me-1"></i>Garansi Cacat Pabrik</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi Lengkap Produk -->
    <div class="mt-5 pt-4 border-top">
        <h4 class="fw-bold mb-3"><i class="bi bi-card-text text-primary me-2"></i>Deskripsi Produk</h4>
        <div class="text-secondary lh-lg" style="white-space: pre-line; font-size: 1.05rem;">
            <?= esc($product['description']) ?>
        </div>
    </div>
</div>

<!-- Produk Terkait -->
<?php if (!empty($relatedProducts)): ?>
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-grid-3x3-gap-fill text-warning me-2"></i>Produk Terkait</h3>
            <p class="text-muted mb-0">Rekomendasi mainan lain dari kategori yang sama</p>
        </div>
        <a href="<?= base_url('produk?kategori=' . $product['category_slug']) ?>" class="text-primary fw-bold text-decoration-none">
            Lihat Kategori Ini <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4">
        <?php foreach ($relatedProducts as $relProduct): ?>
            <div class="col">
                <?= view('partials/product_card', ['product' => $relProduct]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<?= $this->endSection() ?>
