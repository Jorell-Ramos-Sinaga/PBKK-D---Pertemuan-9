<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Dashboard Ikhtisar</h2>
        <span class="text-muted small">Ringkasan operasional dan transaksi toko online ToyTopia</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/produk/baru') ?>" class="btn btn-sm btn-toy-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah Produk Baru
        </a>
    </div>
</div>

<!-- Kartu Statistik -->
<div class="row g-3 mb-4">
    <!-- Total Produk -->
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card border-start border-primary border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Mainan</h6>
                    <h3 class="fw-bold mb-0"><?= $totalProducts ?></h3>
                </div>
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary p-3 fs-3">
                    <i class="bi bi-box-seam"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <a href="<?= base_url('admin/produk') ?>" class="text-decoration-none text-primary fw-bold">Kelola Produk &raquo;</a>
            </div>
        </div>
    </div>

    <!-- Total Pesanan -->
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card border-start border-info border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Pesanan</h6>
                    <h3 class="fw-bold mb-0"><?= $totalOrders ?></h3>
                </div>
                <div class="rounded-circle bg-info bg-opacity-10 text-info p-3 fs-3">
                    <i class="bi bi-cart-check"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <a href="<?= base_url('admin/pesanan') ?>" class="text-decoration-none text-info fw-bold">Lihat Semua Pesanan &raquo;</a>
            </div>
        </div>
    </div>

    <!-- Pesanan Menunggu Pembayaran -->
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card border-start border-warning border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Menunggu Bayar</h6>
                    <h3 class="fw-bold mb-0 text-warning"><?= $pendingOrders ?></h3>
                </div>
                <div class="rounded-circle bg-warning bg-opacity-10 text-warning p-3 fs-3">
                    <i class="bi bi-clock-history"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <a href="<?= base_url('admin/pesanan?status=pending') ?>" class="text-decoration-none text-warning fw-bold">Cek Pesanan Pending &raquo;</a>
            </div>
        </div>
    </div>

    <!-- Total Pendapatan Selesai -->
    <div class="col-sm-6 col-xl-3">
        <div class="admin-stat-card border-start border-success border-4">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-muted small text-uppercase fw-bold mb-1">Total Omset Selesai</h6>
                    <h4 class="fw-bold mb-0 text-success" style="font-family: 'Baloo 2', cursive; font-size: 1.35rem;"><?= format_rupiah($totalRevenue) ?></h4>
                </div>
                <div class="rounded-circle bg-success bg-opacity-10 text-success p-3 fs-3">
                    <i class="bi bi-cash-stack"></i>
                </div>
            </div>
            <div class="mt-3 small">
                <span class="text-muted">Dari pesanan berstatus selesai</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Tabel 5 Pesanan Terbaru -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-cart3 text-primary me-2"></i>5 Pesanan Terbaru</h6>
                <a href="<?= base_url('admin/pesanan') ?>" class="small text-primary fw-bold text-decoration-none">Semua Pesanan &raquo;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="ps-3">Kode</th>
                            <th>Penerima</th>
                            <th>Total</th>
                            <th class="text-center">Status</th>
                            <th class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if (!empty($recentOrders)): ?>
                            <?php foreach ($recentOrders as $ro): ?>
                                <tr>
                                    <td class="ps-3 fw-bold text-primary">
                                        <a href="<?= base_url('admin/pesanan/' . $ro['id']) ?>" class="text-decoration-none">
                                            <?= esc($ro['order_code']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($ro['recipient_name']) ?></td>
                                    <td class="fw-bold"><?= format_rupiah($ro['total']) ?></td>
                                    <td class="text-center"><?= status_badge($ro['status']) ?></td>
                                    <td class="text-center pe-3">
                                        <a href="<?= base_url('admin/pesanan/' . $ro['id']) ?>" class="btn btn-sm btn-outline-primary py-0 px-2 rounded-pill">
                                            Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada pesanan masuk.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Daftar Stok Menipis (Stok <= 5) -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0 text-danger"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Peringatan Stok Menipis (Stok &le; 5)</h6>
                <a href="<?= base_url('admin/produk') ?>" class="small text-danger fw-bold text-decoration-none">Kelola &raquo;</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light small">
                        <tr>
                            <th class="ps-3">Nama Mainan</th>
                            <th class="text-center">Sisa Stok</th>
                            <th class="text-center pe-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        <?php if (!empty($lowStockProducts)): ?>
                            <?php foreach ($lowStockProducts as $lp): ?>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-truncate" style="max-width: 180px;" title="<?= esc($lp['name']) ?>">
                                            <?= esc($lp['name']) ?>
                                        </div>
                                        <span class="text-muted fs-8"><?= esc($lp['category_name']) ?></span>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($lp['stock'] <= 0): ?>
                                            <span class="badge bg-danger rounded-pill">Habis (0)</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning text-dark rounded-pill"><?= $lp['stock'] ?> unit</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center pe-3">
                                        <a href="<?= base_url('admin/produk/ubah/' . $lp['id']) ?>" class="btn btn-sm btn-outline-secondary py-0 px-2 rounded-pill" title="Update Stok">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Semua stok produk aman di atas 5 unit.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

