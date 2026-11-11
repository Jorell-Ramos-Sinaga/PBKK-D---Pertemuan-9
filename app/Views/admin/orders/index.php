<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Pesanan Masuk</h2>
        <span class="text-muted small">Kelola seluruh transaksi pembelian dan update status pengiriman mainan</span>
    </div>
</div>

<!-- Filter Status Tabs -->
<div class="mb-4">
    <div class="d-flex flex-wrap gap-2">
        <?php
        $statuses = [
            ''           => 'Semua Pesanan',
            'pending'    => 'Menunggu Bayar',
            'paid'       => 'Sudah Dibayar',
            'processing' => 'Diproses',
            'shipped'    => 'Dikirim',
            'completed'  => 'Selesai',
            'cancelled'  => 'Dibatalkan',
        ];
        ?>
        <?php foreach ($statuses as $val => $lbl): ?>
            <a href="<?= base_url('admin/pesanan' . ($val !== '' ? '?status=' . $val : '')) ?>" class="btn btn-sm <?= ($statusFilter === $val || (empty($statusFilter) && $val === '')) ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-3">
                <?= $lbl ?>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<!-- Tabel Pesanan -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3">Kode Pesanan</th>
                    <th class="py-3">Waktu Pemesanan</th>
                    <th class="py-3">Penerima & Alamat</th>
                    <th class="py-3">Metode Bayar</th>
                    <th class="py-3">Total Belanja</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-center pe-4" style="width: 100px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($orders)): ?>
                    <?php foreach ($orders as $ord): ?>
                        <tr>
                            <td class="ps-4 py-3 fw-bold text-primary">
                                <a href="<?= base_url('admin/pesanan/' . $ord['id']) ?>" class="text-decoration-none">
                                    <?= esc($ord['order_code']) ?>
                                </a>
                            </td>
                            <td class="small text-muted">
                                <?= date('d/m/Y H:i', strtotime($ord['created_at'])) ?> WIB
                            </td>
                            <td class="small">
                                <strong class="d-block text-dark"><?= esc($ord['recipient_name']) ?></strong>
                                <span class="text-muted"><?= esc($ord['city']) ?></span>
                            </td>
                            <td class="small">
                                <span class="badge bg-light text-dark border">
                                    <?= $ord['payment_method'] === 'transfer' ? 'Transfer Bank' : 'COD' ?>
                                </span>
                            </td>
                            <td class="fw-bold text-danger" style="font-family: 'Baloo 2', cursive;">
                                <?= format_rupiah($ord['total']) ?>
                            </td>
                            <td class="text-center">
                                <?= status_badge($ord['status']) ?>
                            </td>
                            <td class="text-center pe-4">
                                <a href="<?= base_url('admin/pesanan/' . $ord['id']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">Tidak ada data pesanan pada filter ini.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pager -->
    <?php if ($pager->getPageCount('admin_orders') > 1): ?>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            <?= $pager->links('admin_orders', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

