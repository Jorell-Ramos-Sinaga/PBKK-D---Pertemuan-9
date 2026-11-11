<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('keranjang') ?>">Keranjang Belanja</a></li>
        <li class="breadcrumb-item active" aria-current="page">Checkout Pesanan</li>
    </ol>
</nav>

<h2 class="fw-bold mb-4"><i class="bi bi-bag-check-fill text-primary me-2"></i>Pengiriman & Checkout</h2>

<form action="<?= base_url('checkout/proses') ?>" method="post">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Kolom Kiri: Form Data Pengiriman & Metode Pembayaran -->
        <div class="col-lg-7">
            <!-- Data Penerima & Alamat -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat Pengiriman</h5>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="recipient_name" class="form-label fw-bold">Nama Penerima</label>
                        <input type="text" name="recipient_name" id="recipient_name" class="form-control rounded-3" value="<?= old('recipient_name', $user['name'] ?? '') ?>" required>
                    </div>

                    <div class="col-md-6">
                        <label for="phone" class="form-label fw-bold">Nomor Telepon / WA</label>
                        <input type="text" name="phone" id="phone" class="form-control rounded-3" placeholder="08xxxxxxxxxx" value="<?= old('phone', $user['phone'] ?? '') ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label fw-bold">Alamat Lengkap</label>
                        <textarea name="address" id="address" class="form-control rounded-3" rows="3" placeholder="Nama jalan, nomor rumah, RT/RW, kelurahan, kecamatan..." required><?= old('address', $user['address'] ?? '') ?></textarea>
                    </div>

                    <div class="col-md-8">
                        <label for="city" class="form-label fw-bold">Kota / Kabupaten</label>
                        <input type="text" name="city" id="city" class="form-control rounded-3" placeholder="Contoh: Jakarta Selatan" value="<?= old('city') ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label for="postal_code" class="form-label fw-bold">Kode Pos</label>
                        <input type="text" name="postal_code" id="postal_code" class="form-control rounded-3" placeholder="5 digit angka" maxlength="5" value="<?= old('postal_code') ?>" required>
                    </div>

                    <div class="col-12">
                        <label for="note" class="form-label fw-bold">Catatan untuk Penjual (Opsional)</label>
                        <input type="text" name="note" id="note" class="form-control rounded-3" placeholder="Contoh: Tolong bungkus dengan kertas kado, atau titip di pos satpam" value="<?= old('note') ?>">
                    </div>
                </div>
            </div>

            <!-- Pilihan Metode Pembayaran -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h5 class="fw-bold mb-3"><i class="bi bi-wallet2 text-primary me-2"></i>Metode Pembayaran</h5>
                <p class="text-muted small">Silakan pilih metode pembayaran yang Anda inginkan (Disimulasikan):</p>

                <div class="d-flex flex-column gap-3">
                    <label class="card p-3 border rounded-3 cursor-pointer">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input me-3" type="radio" name="payment_method" id="pay_transfer" value="transfer" <?= old('payment_method', 'transfer') === 'transfer' ? 'checked' : '' ?>>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1"><i class="bi bi-bank text-primary me-2"></i>Transfer Bank Manual</h6>
                                <small class="text-muted">Transfer ke rekening BCA / Mandiri / BNI Toko Topia.</small>
                            </div>
                        </div>
                    </label>

                    <label class="card p-3 border rounded-3 cursor-pointer">
                        <div class="form-check d-flex align-items-center">
                            <input class="form-check-input me-3" type="radio" name="payment_method" id="pay_cod" value="cod" <?= old('payment_method') === 'cod' ? 'checked' : '' ?>>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1"><i class="bi bi-cash-coin text-success me-2"></i>Bayar di Tempat (COD)</h6>
                                <small class="text-muted">Bayar tunai kepada kurir saat paket mainan sampai di rumah Anda.</small>
                            </div>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Ringkasan Pesanan Belanja -->
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white sticky-lg-top" style="top: 85px;">
                <h5 class="fw-bold mb-3">Pesanan Anda (<?= count($cartItems) ?> Barang)</h5>

                <!-- List Item Ringkas -->
                <div class="d-flex flex-column gap-3 mb-3" style="max-height: 280px; overflow-y: auto;">
                    <?php foreach ($cartItems as $item): ?>
                        <div class="d-flex align-items-center gap-3 border-bottom pb-2">
                            <img src="<?= product_image($item['image']) ?>" alt="<?= esc($item['name']) ?>" class="rounded-3 border" style="width: 50px; height: 50px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-0 small fw-bold text-truncate" style="max-width: 220px;" title="<?= esc($item['name']) ?>">
                                    <?= esc($item['name']) ?>
                                </h6>
                                <small class="text-muted"><?= $item['quantity'] ?> x <?= format_rupiah($item['price']) ?></small>
                            </div>
                            <span class="small fw-bold text-nowrap"><?= format_rupiah($item['price'] * $item['quantity']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal Produk</span>
                    <span class="fw-bold"><?= format_rupiah($subtotal) ?></span>
                </div>

                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Ongkos Kirim</span>
                    <div>
                        <?php if ($shippingCost == 0): ?>
                            <span class="badge bg-success rounded-pill">Gratis Ongkir</span>
                        <?php else: ?>
                            <span class="fw-bold"><?= format_rupiah($shippingCost) ?></span>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <span class="fw-bold fs-5">Total Tagihan</span>
                    <span class="toy-price fs-4"><?= format_rupiah($total) ?></span>
                </div>

                <button type="submit" class="btn btn-toy-primary btn-lg w-100 shadow">
                    <i class="bi bi-check-circle-fill me-1"></i>Buat Pesanan Sekarang
                </button>

                <div class="text-center mt-3 small text-muted">
                    Dengan membuat pesanan, Anda menyetujui syarat & ketentuan belanja di ToyTopia.
                </div>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

