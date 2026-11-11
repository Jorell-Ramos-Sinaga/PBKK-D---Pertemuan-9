<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Hero Section -->
<div class="toy-hero shadow-sm mb-5">
    <div class="row align-items-center">
        <div class="col-lg-7 text-center text-lg-start mb-4 mb-lg-0">
            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-3 fs-6">
                🎉 Selamat Datang di ToyTopia
            </span>
            <h1 class="display-4 fw-extrabold text-dark mb-3">
                Dunia Mainan Seru & <span style="color: var(--toy-primary);">Penuh Imajinasi!</span>
            </h1>
            <p class="lead text-secondary mb-4">
                Temukan aneka mainan edukasi, balok susun, figur aksi, dan permainan keluarga terbaik yang aman, berkualitas, dan membuat hari si kecil penuh keceriaan.
            </p>
            <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                <a href="<?= base_url('produk') ?>" class="btn btn-toy-primary btn-lg px-4 shadow">
                    <i class="bi bi-cart-fill me-2"></i>Belanja Sekarang
                </a>
                <a href="#kategori" class="btn btn-outline-dark btn-lg px-4 rounded-pill">
                    Lihat Kategori
                </a>
            </div>
        </div>
        <div class="col-lg-5 text-center">
            <div class="p-3 bg-white rounded-circle d-inline-block shadow-lg" style="max-width: 340px;">
                <img src="<?= file_exists(FCPATH . 'assets/img/hero.jpg') ? base_url('assets/img/hero.jpg') : (file_exists(FCPATH . 'assets/img/hero.png') ? base_url('assets/img/hero.png') : base_url('assets/img/placeholder.png')) ?>" alt="ToyTopia Hero" class="img-fluid rounded-circle shadow-sm" style="width: 280px; height: 280px; object-fit: cover;">
            </div>
        </div>
    </div>
</div>

<!-- Kategori Unggulan -->
<section id="kategori" class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <h3 class="fw-bold mb-1"><i class="bi bi-grid-fill text-warning me-2"></i>Kategori Mainan</h3>
            <p class="text-muted mb-0">Pilih kategori favorit untuk menemukan mainan yang tepat</p>
        </div>
        <a href="<?= base_url('produk') ?>" class="text-primary fw-bold text-decoration-none">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 g-3">
        <?php 
        $icons = [
            'balok-susun'             => 'bi-boxes',
            'boneka-plush'            => 'bi-heart-fill',
            'mobil-kendaraan'         => 'bi-car-front-fill',
            'action-figure'           => 'bi-person-arms-up',
            'puzzle'                  => 'bi-puzzle-fill',
            'mainan-edukasi'          => 'bi-lightbulb-fill',
            'board-game'              => 'bi-dice-5-fill',
            'masak-masakan-pura-pura' => 'bi-cup-hot-fill',
        ];
        ?>
        <?php foreach ($categories as $cat): ?>
            <div class="col">
                <a href="<?= base_url('produk?kategori=' . $cat['slug']) ?>" class="category-bubble-card">
                    <div class="category-icon-circle">
                        <i class="bi <?= $icons[$cat['slug']] ?? 'bi-stars' ?>"></i>
                    </div>
                    <h6 class="fw-bold mb-1"><?= esc($cat['name']) ?></h6>
                    <small class="text-muted">Jelajahi &raquo;</small>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- Produk Unggulan -->
<?php if (!empty($featuredProducts)): ?>
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <span class="badge bg-danger text-white rounded-pill px-3 py-1 mb-2 fw-bold">Paling Disukai</span>
            <h3 class="fw-bold mb-1"><i class="bi bi-star-fill text-warning me-2"></i>Produk Pilihan Unggulan</h3>
            <p class="text-muted mb-0">Mainan rekomendasi terbaik dengan kualitas terjamin</p>
        </div>
        <a href="<?= base_url('produk') ?>" class="text-primary fw-bold text-decoration-none">
            Semua Produk <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col">
                <?= view('partials/product_card', ['product' => $product]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Produk Terbaru -->
<?php if (!empty($latestProducts)): ?>
<section class="mb-5">
    <div class="d-flex justify-content-between align-items-end mb-4">
        <div>
            <span class="badge bg-info text-dark rounded-pill px-3 py-1 mb-2 fw-bold">Baru Masuk</span>
            <h3 class="fw-bold mb-1"><i class="bi bi-sparkles text-warning me-2"></i>Produk Terbaru</h3>
            <p class="text-muted mb-0">Koleksi mainan terbaru yang baru saja mendarat di ToyTopia</p>
        </div>
        <a href="<?= base_url('produk?urut=terbaru') ?>" class="text-primary fw-bold text-decoration-none">
            Lihat Lebih Banyak <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($latestProducts as $product): ?>
            <div class="col">
                <?= view('partials/product_card', ['product' => $product]) ?>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- Keunggulan Toko -->
<section class="py-5 my-4 bg-white rounded-4 shadow-sm px-4">
    <div class="text-center mb-4">
        <h3 class="fw-bold">Mengapa Belanja di <span style="color: var(--toy-primary);">ToyTopia?</span></h3>
        <p class="text-muted">Komitmen kami memberikan kebahagiaan dan keamanan terbaik bagi keluarga Anda</p>
    </div>

    <div class="row g-4 text-center">
        <div class="col-md-3 col-sm-6">
            <div class="p-3">
                <div class="fs-1 text-primary mb-2"><i class="bi bi-shield-check"></i></div>
                <h5 class="fw-bold">100% Aman & SNI</h5>
                <p class="text-muted small">Bahan bebas racun (BPA free) dan aman dimainkan oleh anak berbagai usia.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="p-3">
                <div class="fs-1 text-warning mb-2"><i class="bi bi-truck"></i></div>
                <h5 class="fw-bold">Pengiriman Cepat</h5>
                <p class="text-muted small">Pesanan dipacking dengan bubble wrap tebal dan dikirim cepat ke seluruh Indonesia.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="p-3">
                <div class="fs-1 text-success mb-2"><i class="bi bi-wallet2"></i></div>
                <h5 class="fw-bold">Gratis Ongkir</h5>
                <p class="text-muted small">Nikmati promo bebas biaya kirim untuk pembelanjaan minimal Rp 500.000.</p>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="p-3">
                <div class="fs-1 text-danger mb-2"><i class="bi bi-emoji-smile"></i></div>
                <h5 class="fw-bold">Layanan Ramah</h5>
                <p class="text-muted small">Tim kami siap membantu menjawab pertanyaan Anda dengan sepenuh hati.</p>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
