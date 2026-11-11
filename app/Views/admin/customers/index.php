<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Daftar Pelanggan Terdaftar</h2>
        <span class="text-muted small">Informasi akun pengguna dan riwayat transaksi pelanggan ToyTopia (Read-Only)</span>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3" style="width: 50px;">#</th>
                    <th class="py-3">Nama Lengkap</th>
                    <th class="py-3">Email</th>
                    <th class="py-3">No. Telepon</th>
                    <th class="py-3">Alamat Default</th>
                    <th class="py-3 text-center">Total Pesanan</th>
                    <th class="py-3 text-end">Total Belanja</th>
                    <th class="py-3 text-center pe-4">Bergabung</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($customers)): ?>
                    <?php $no = 1; foreach ($customers as $c): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $no++ ?></td>
                            <td class="fw-bold text-dark">
                                <i class="bi bi-person-circle text-primary me-1"></i>
                                <?= esc($c['name']) ?>
                            </td>
                            <td class="small">
                                <a href="mailto:<?= esc($c['email']) ?>" class="text-decoration-none">
                                    <?= esc($c['email']) ?>
                                </a>
                            </td>
                            <td class="small text-muted">
                                <?= esc($c['phone'] ?? '-') ?>
                            </td>
                            <td class="small text-muted" style="max-width: 250px;">
                                <?= esc(character_limiter($c['address'] ?? '-', 50)) ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-info-subtle text-info-emphasis rounded-pill px-3">
                                    <?= $c['total_orders'] ?> pesanan
                                </span>
                            </td>
                            <td class="text-end fw-bold text-success" style="font-family: 'Baloo 2', cursive;">
                                <?= format_rupiah($c['total_spent']) ?>
                            </td>
                            <td class="text-center small text-muted pe-4">
                                <?= date('d M Y', strtotime($c['created_at'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">Belum ada pelanggan terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

