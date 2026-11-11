<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Pesanan Saya</li>
    </ol>
</nav>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1"><i class="bi bi-box-seam-fill text-primary me-2"></i>Daftar Pesanan Saya</h2>
        <p class="text-muted mb-0">Pantau status pengiriman dan riwayat pembelian mainan Anda</p>
    </div>
    <a href="<?= base_url('produk') ?>" class="btn btn-toy-outline rounded-pill px-4">
        <i class="bi bi-bag-plus me-1"></i>Belanja Lagi
    </a>
</div>

<?php if (!empty($orders)): ?>
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4 py-3">Kode Pesanan</th>
                        <th class="py-3">Tanggal</th>
                        <th class="py-3">Penerima</th>
                        <th class="py-3">Metode Bayar</th>
                        <th class="py-3">Total Belanja</th>
                        <th class="py-3 text-center">Status</th>
                        <th class="py-3 text-center pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-primary">
                                <a href="<?= base_url('pesanan/' . $order['order_code']) ?>" class="text-decoration-none">
                                    <?= esc($order['order_code']) ?>
                                </a>
                            </td>
                            <td class="small text-muted">
                                <?= date('d M Y, H:i', strtotime($order['created_at'])) ?>
                            </td>
                            <td class="small">
                                <strong><?= esc($order['recipient_name']) ?></strong><br>
                                <span class="text-muted"><?= esc($order['city']) ?></span>
                            </td>
                            <td class="small">
                                <span class="badge bg-light text-dark border">
                                    <?= $order['payment_method'] === 'transfer' ? 'Transfer Bank' : 'COD' ?>
                                </span>
                            </td>
                            <td class="fw-bold text-danger" style="font-family: 'Baloo 2', cursive;">
                                <?= format_rupiah($order['total']) ?>
                            </td>
                            <td class="text-center">
                                <?= status_badge($order['status']) ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= base_url('pesanan/' . $order['order_code']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Detail <i class="bi bi-chevron-right ms-1"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php else: ?>
    <!-- Pesanan Kosong -->
    <div class="text-center py-5 bg-white rounded-4 shadow-sm p-4">
        <i class="bi bi-inbox text-warning display-1 mb-3"></i>
        <h4 class="fw-bold mb-2">Anda Belum Pernah Melakukan Pesanan</h4>
        <p class="text-muted mb-4">Temukan aneka mainan seru dan hadiah terbaik untuk anak di katalog kami sekarang.</p>
        <a href="<?= base_url('produk') ?>" class="btn btn-toy-primary rounded-pill px-5 shadow">
            Jelajahi Produk Mainan
        </a>
    </div>
<?php endif; ?>

<?= $this->endSection() ?>

