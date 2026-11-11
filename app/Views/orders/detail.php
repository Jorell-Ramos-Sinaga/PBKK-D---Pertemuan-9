<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item"><a href="<?= base_url('pesanan') ?>">Pesanan Saya</a></li>
        <li class="breadcrumb-item active" aria-current="page"><?= esc($order['order_code']) ?></li>
    </ol>
</nav>

<!-- Order Header Card -->
<div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <span class="text-muted small">Kode Pesanan:</span>
            <h3 class="fw-bold text-primary mb-1"><?= esc($order['order_code']) ?></h3>
            <span class="text-muted small">
                <i class="bi bi-calendar3 me-1"></i>Dipesan pada: <?= date('d F Y, H:i', strtotime($order['created_at'])) ?> WIB
            </span>
        </div>
        <div class="text-md-end">
            <span class="text-muted small d-block mb-1">Status Pesanan:</span>
            <div class="fs-6"><?= status_badge($order['status']) ?></div>
        </div>
    </div>

    <!-- Tombol Batalkan Pesanan (Hanya jika status 'pending') -->
    <?php if ($order['status'] === 'pending'): ?>
        <hr class="my-3">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 bg-light p-3 rounded-3">
            <div class="small text-muted">
                <i class="bi bi-info-circle me-1"></i>Pesanan ini masih berstatus <strong>Menunggu Pembayaran</strong> dan dapat dibatalkan sewaktu-waktu.
            </div>
            <form action="<?= base_url('pesanan/batal/' . $order['order_code']) ?>" method="post" class="d-inline">
                <?= csrf_field() ?>
                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-4 btn-delete-confirm" data-confirm="Apakah Anda yakin ingin membatalkan pesanan ini? Stok mainan akan dikembalikan.">
                    <i class="bi bi-x-circle me-1"></i>Batalkan Pesanan
                </button>
            </form>
        </div>
    <?php endif; ?>
</div>

<div class="row g-4">
    <!-- Kolom Kiri: Rincian Produk yang Dibeli -->
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
            <div class="card-header bg-white py-3 border-0">
                <h5 class="fw-bold mb-0"><i class="bi bi-boxes text-primary me-2"></i>Daftar Barang Belanja</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-2">Produk</th>
                            <th class="py-2 text-center">Harga</th>
                            <th class="py-2 text-center">Jumlah</th>
                            <th class="py-2 text-end pe-4">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td class="ps-4 py-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <img src="<?= product_image($item['image'] ?? null) ?>" alt="<?= esc($item['product_name']) ?>" class="rounded-3 border" style="width: 55px; height: 55px; object-fit: cover;">
                                        <div>
                                            <?php if (!empty($item['slug'])): ?>
                                                <a href="<?= base_url('produk/' . $item['slug']) ?>" class="fw-bold text-dark text-decoration-none d-block">
                                                    <?= esc($item['product_name']) ?>
                                                </a>
                                            <?php else: ?>
                                                <span class="fw-bold text-dark d-block"><?= esc($item['product_name']) ?></span>
                                            <?php endif; ?>
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

        <!-- Instruksi Pembayaran Transfer Bank jika masih pending -->
        <?php if ($order['status'] === 'pending' && $order['payment_method'] === 'transfer'): ?>
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border-start border-warning border-4 mb-4">
                <h5 class="fw-bold mb-2"><i class="bi bi-credit-card-2-front-fill text-warning me-2"></i>Instruksi Pembayaran (Simulasi Transfer)</h5>
                <p class="text-muted small mb-3">Silakan lakukan transfer sejumlah total tagihan ke salah satu rekening resmi ToyTopia berikut:</p>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="badge bg-primary mb-1">Bank BCA</span>
                            <div class="fs-5 fw-bold text-dark">8830-1234-5678</div>
                            <small class="text-muted">a.n. PT ToyTopia Indonesia</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <span class="badge bg-success mb-1">Bank Mandiri</span>
                            <div class="fs-5 fw-bold text-dark">137-00-9876-5432</div>
                            <small class="text-muted">a.n. PT ToyTopia Indonesia</small>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Kolom Kanan: Rincian Pengiriman & Biaya -->
    <div class="col-lg-4">
        <!-- Informasi Penerima -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
            <h5 class="fw-bold mb-3"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Tujuan Pengiriman</h5>
            <div class="small">
                <p class="mb-1 fw-bold"><?= esc($order['recipient_name']) ?></p>
                <p class="mb-2 text-muted"><i class="bi bi-telephone me-1"></i><?= esc($order['phone']) ?></p>
                <p class="mb-2 text-secondary"><?= esc($order['address']) ?></p>
                <p class="mb-0 text-muted"><?= esc($order['city']) ?>, <?= esc($order['postal_code']) ?></p>
                
                <?php if (!empty($order['note'])): ?>
                    <div class="mt-3 p-2 bg-light rounded-3">
                        <small class="text-muted d-block fw-bold">Catatan Pembeli:</small>
                        <em><?= esc($order['note']) ?></em>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Rincian Biaya -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h5 class="fw-bold mb-3"><i class="bi bi-receipt text-primary me-2"></i>Rincian Biaya</h5>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Metode Pembayaran</span>
                <span class="fw-bold text-uppercase"><?= $order['payment_method'] === 'transfer' ? 'Transfer Bank' : 'Cash on Delivery (COD)' ?></span>
            </div>

            <div class="d-flex justify-content-between mb-2 small">
                <span class="text-muted">Subtotal Produk</span>
                <span class="fw-bold"><?= format_rupiah($order['subtotal']) ?></span>
            </div>

            <div class="d-flex justify-content-between mb-3 small">
                <span class="text-muted">Biaya Pengiriman</span>
                <span class="fw-bold"><?= $order['shipping_cost'] == 0 ? '<span class="text-success">Gratis</span>' : format_rupiah($order['shipping_cost']) ?></span>
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

