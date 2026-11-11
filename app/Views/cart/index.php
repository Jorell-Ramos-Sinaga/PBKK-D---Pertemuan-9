<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Keranjang Belanja</li>
    </ol>
</nav>

<h2 class="fw-bold mb-4"><i class="bi bi-cart3 text-primary me-2"></i>Keranjang Belanja Anda</h2>

<?php if (!empty($cartItems)): ?>
    <div class="row g-4">
        <!-- Kolom Tabel Item Keranjang -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" style="min-width: 280px;" class="py-3 ps-4">Produk</th>
                                <th scope="col" class="py-3 text-center">Harga Satuan</th>
                                <th scope="col" class="py-3 text-center" style="min-width: 140px;">Jumlah</th>
                                <th scope="col" class="py-3 text-end">Subtotal</th>
                                <th scope="col" class="py-3 text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cartItems as $item): ?>
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="<?= product_image($item['image']) ?>" alt="<?= esc($item['name']) ?>" class="rounded-3 shadow-sm border" style="width: 65px; height: 65px; object-fit: cover;">
                                            <div>
                                                <a href="<?= base_url('produk/' . $item['slug']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                    <?= esc($item['name']) ?>
                                                </a>
                                                <small class="text-muted">Sisa stok: <?= $item['stock'] ?> unit</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-bold">
                                        <?= format_rupiah($item['price']) ?>
                                    </td>
                                    <td class="text-center">
                                        <!-- Form Ubah Jumlah -->
                                        <form action="<?= base_url('keranjang/ubah') ?>" method="post" class="d-inline-block">
                                            <?= csrf_field() ?>
                                            <input type="hidden" name="cart_id" value="<?= $item['id'] ?>">
                                            <div class="input-group input-group-sm qty-input-group" style="width: 110px; margin: 0 auto;">
                                                <button class="btn btn-outline-secondary btn-qty-minus" type="button"><i class="bi bi-dash"></i></button>
                                                <input type="number" name="quantity" class="form-control text-center fw-bold px-1" value="<?= $item['quantity'] ?>" min="1" max="<?= $item['stock'] ?>" onchange="this.form.submit()">
                                                <button class="btn btn-outline-secondary btn-qty-plus" type="button"><i class="bi bi-plus"></i></button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="text-end fw-extrabold text-danger" style="font-family: 'Baloo 2', cursive; font-size: 1.1rem;">
                                        <?= format_rupiah($item['price'] * $item['quantity']) ?>
                                    </td>
                                    <td class="text-center pe-4">
                                        <form action="<?= base_url('keranjang/hapus/' . $item['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle btn-delete-confirm" data-confirm="Hapus mainan ini dari keranjang?" title="Hapus Item">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-1"></i>Lanjut Pilih Mainan
                </a>
            </div>
        </div>

        <!-- Kolom Ringkasan Belanja (Kanan) -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-lg-top" style="top: 85px;">
                <h5 class="fw-bold mb-4">Ringkasan Pesanan</h5>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Total Belanja (Subtotal)</span>
                    <span class="fw-bold"><?= format_rupiah($subtotal) ?></span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Ongkos Kirim (Flat)</span>
                    <div>
                        <?php if ($shippingCost == 0): ?>
                            <span class="badge bg-success rounded-pill">Gratis Ongkir</span>
                        <?php else: ?>
                            <span class="fw-bold"><?= format_rupiah($shippingCost) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <?php if ($subtotal < $freeShippingMin): ?>
                    <div class="alert alert-warning py-2 px-3 small rounded-3 mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        Tambah belanja <strong><?= format_rupiah($freeShippingMin - $subtotal) ?></strong> lagi untuk mendapatkan <strong>Gratis Ongkir</strong>!
                    </div>
                <?php endif; ?>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5">Total Pembayaran</span>
                    <span class="toy-price fs-4"><?= format_rupiah($total) ?></span>
                </div>

                <a href="<?= base_url('checkout') ?>" class="btn btn-toy-primary btn-lg w-100 shadow">
                    Lanjut ke Checkout <i class="bi bi-arrow-right ms-1"></i>
                </a>

                <div class="text-center mt-3 small text-muted">
                    <i class="bi bi-shield-lock-fill text-success me-1"></i>Transaksi Aman & Terenkripsi
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <!-- Keranjang Kosong -->
    <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
        <i class="bi bi-cart-x text-warning display-1 mb-3"></i>
        <h3 class="fw-bold mb-2">Keranjang Belanja Anda Masih Kosong</h3>
        <p class="text-muted mb-4">Belum ada mainan yang Anda masukkan ke keranjang belanja. Yuk, cari mainan seru sekarang!</p>
        <a href="<?= base_url('produk') ?>" class="btn btn-toy-primary btn-lg rounded-pill px-5 shadow">
            <i class="bi bi-bag-plus-fill me-2"></i>Mulai Belanja Mainan
        </a>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

