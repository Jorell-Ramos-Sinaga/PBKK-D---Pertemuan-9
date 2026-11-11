<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Detail Pesanan #<?= esc($order['order_code']) ?></h2>
        <span class="text-muted small">Kelola status pesanan dan rincian pengiriman pembeli</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/pesanan') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Pesanan
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Rincian Produk & Status Form -->
    <div class="col-lg-8">
        <!-- Form Update Status Pesanan -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 border-start border-primary border-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-sliders text-primary me-2"></i>Perbarui Status Pesanan</h5>
            <form action="<?= base_url('admin/pesanan/status/' . $order['id']) ?>" method="post" class="row g-3 align-items-center">
                <?= csrf_field() ?>
                
                <div class="col-md-7">
                    <label for="statusSelect" class="form-label small fw-bold text-muted mb-1">Status Saat Ini: <?= status_badge($order['status']) ?></label>
                    <select name="status" id="statusSelect" class="form-select rounded-3">
                        <option value="pending" <?= $order['status'] === 'pending' ? 'selected' : '' ?>>Menunggu Pembayaran (pending)</option>
                        <option value="paid" <?= $order['status'] === 'paid' ? 'selected' : '' ?>>Sudah Dibayar (paid)</option>
                        <option value="processing" <?= $order['status'] === 'processing' ? 'selected' : '' ?>>Sedang Diproses (processing)</option>
                        <option value="shipped" <?= $order['status'] === 'shipped' ? 'selected' : '' ?>>Sedang Dikirim (shipped)</option>
                        <option value="completed" <?= $order['status'] === 'completed' ? 'selected' : '' ?>>Pesanan Selesai (completed)</option>
                        <option value="cancelled" <?= $order['status'] === 'cancelled' ? 'selected' : '' ?>>Dibatalkan (cancelled - kembalikan stok)</option>
                    </select>
                </div>

                <div class="col-md-5 mt-md-4">
                    <button type="submit" class="btn btn-toy-primary rounded-pill px-4 w-100">
                        <i class="bi bi-check2-circle me-1"></i>Simpan Status
                    </button>
                </div>
            </form>
            <div class="mt-2">
                <small class="text-muted"><i class="bi bi-info-circle me-1"></i>Catatan: Mengubah status ke <strong>Dibatalkan</strong> akan otomatis mengembalikan stok mainan ke katalog.</small>
            </div>
        </div>

        <!-- Tabel Item Produk -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0"><i class="bi bi-boxes text-primary me-2"></i>Item Mainan yang Dipesan</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-2">Produk</th>
                            <th class="py-2 text-center">Harga Beli</th>
                            <th class="py-2 text-center">Qty</th>
                            <th class="py-2 text-end pe-4">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= product_image($item['image'] ?? null) ?>" alt="<?= esc($item['product_name']) ?>" class="rounded-3 border" style="width: 50px; height: 50px; object-fit: cover;">
                                        <div>
                                            <span class="fw-bold text-dark d-block"><?= esc($item['product_name']) ?></span>
                                            <small class="text-muted">ID Produk: <?= $item['product_id'] ?? 'Dihapus' ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center small">
                                    <?= format_rupiah($item['price']) ?>
                                </td>
                                <td class="text-center fw-bold">
                                    <?= $item['quantity'] ?>
                                </td>
                                <td class="text-end fw-bold pe-4" style="font-family: 'Baloo 2', cursive;">
                                    <?= format_rupiah($item['subtotal']) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Info Pelanggan & Pengiriman -->
    <div class="col-lg-4">
        <!-- Info Pembeli & Penerima -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-person-lines-fill text-primary me-2"></i>Data Pengiriman</h5>
            
            <div class="small mb-3">
                <span class="text-muted d-block">Akun Pembeli:</span>
                <strong><?= esc($order['user_email'] ?? 'Tamu') ?></strong>
            </div>

            <div class="small mb-3">
                <span class="text-muted d-block">Nama Penerima:</span>
                <strong><?= esc($order['recipient_name']) ?></strong>
            </div>

            <div class="small mb-3">
                <span class="text-muted d-block">Kontak Telepon:</span>
                <strong><?= esc($order['phone']) ?></strong>
            </div>

            <div class="small mb-3">
                <span class="text-muted d-block">Alamat Lengkap:</span>
                <p class="mb-0 text-secondary"><?= esc($order['address']) ?></p>
                <span class="text-muted"><?= esc($order['city']) ?>, <?= esc($order['postal_code']) ?></span>
            </div>

            <?php if (!empty($order['note'])): ?>
                <div class="p-2 bg-light rounded-3 small">
                    <span class="text-muted fw-bold d-block">Catatan:</span>
                    <em><?= esc($order['note']) ?></em>
                </div>
            <?php endif; ?>
        </div>

        <!-- Ringkasan Keuangan Pesanan -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold mb-3"><i class="bi bi-receipt text-primary me-2"></i>Rincian Pembayaran</h5>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Metode</span>
                <span class="badge bg-light text-dark border text-uppercase"><?= $order['payment_method'] === 'transfer' ? 'Transfer Bank' : 'COD' ?></span>
            </div>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Subtotal Produk</span>
                <span class="fw-bold"><?= format_rupiah($order['subtotal']) ?></span>
            </div>

            <div class="d-flex justify-content-between mb-3 small">
                <span class="text-muted">Biaya Kirim</span>
                <span class="fw-bold"><?= $order['shipping_cost'] == 0 ? 'Gratis' : format_rupiah($order['shipping_cost']) ?></span>
            </div>

            <hr>

            <div class="d-flex justify-content-between align-items-center">
                <span class="fw-bold">Total Pembayaran</span>
                <span class="toy-price fs-4"><?= format_rupiah($order['total']) ?></span>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

