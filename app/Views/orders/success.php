<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="row justify-content-center py-4">
    <div class="col-md-9 col-lg-7">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white text-center">
            <!-- Icon Sukses -->
            <div class="mx-auto mb-3">
                <div class="rounded-circle bg-success bg-opacity-10 text-success d-inline-flex align-items-center justify-content-center" style="width: 85px; height: 85px; font-size: 3rem;">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>

            <h2 class="fw-bold text-dark mb-2">Terima Kasih atas Pesanan Anda!</h2>
            <p class="text-muted mb-4">
                Pesanan Anda telah berhasil dibuat dan segera diproses oleh tim ToyTopia.
            </p>

            <!-- Box Kode Pesanan -->
            <div class="p-3 bg-light rounded-4 mb-4 border border-dashed">
                <small class="text-muted d-block text-uppercase fw-bold">Nomor Kode Pesanan</small>
                <div class="fs-3 fw-bold text-primary" style="font-family: 'Baloo 2', cursive;">
                    <?= esc($order['order_code']) ?>
                </div>
                <small class="text-muted">Simpan kode pesanan ini untuk melacak paket Anda.</small>
            </div>

            <!-- Petunjuk Pembayaran jika Transfer -->
            <?php if ($order['payment_method'] === 'transfer'): ?>
                <div class="card border-warning border-2 rounded-4 p-4 mb-4 bg-warning bg-opacity-10 text-start">
                    <h5 class="fw-bold mb-2 text-dark"><i class="bi bi-wallet2 text-warning me-2"></i>Instruksi Pembayaran Transfer Bank:</h5>
                    <p class="small text-muted mb-3">
                        Total tagihan yang harus ditransfer adalah <strong class="text-danger fs-5"><?= format_rupiah($order['total']) ?></strong> ke salah satu rekening kami:
                    </p>

                    <div class="p-3 bg-white rounded-3 border mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-primary me-2">BCA</span>
                                <strong class="fs-5">8830-1234-5678</strong>
                            </div>
                            <small class="text-muted">a.n. PT ToyTopia Indonesia</small>
                        </div>
                    </div>

                    <div class="p-3 bg-white rounded-3 border">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <span class="badge bg-success me-2">Mandiri</span>
                                <strong class="fs-5">137-00-9876-5432</strong>
                            </div>
                            <small class="text-muted">a.n. PT ToyTopia Indonesia</small>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info rounded-4 text-start p-3 mb-4">
                    <h6 class="fw-bold mb-1"><i class="bi bi-cash-coin me-2"></i>Metode Bayar di Tempat (COD)</h6>
                    <small>Mohon siapkan uang tunai pas sejumlah <strong><?= format_rupiah($order['total']) ?></strong> saat kurir mengantarkan pesanan Anda ke alamat tujuan.</small>
                </div>
            <?php endif; ?>

            <!-- Aksi Tombol -->
            <div class="d-flex flex-wrap gap-3 justify-content-center">
                <a href="<?= base_url('pesanan/' . $order['order_code']) ?>" class="btn btn-toy-primary btn-lg rounded-pill px-4 shadow">
                    <i class="bi bi-box-seam me-2"></i>Lihat Status Pesanan
                </a>
                <a href="<?= base_url('produk') ?>" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                    Belanja Mainan Lainnya
                </a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

