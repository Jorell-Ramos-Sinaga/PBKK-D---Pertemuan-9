<footer class="toy-footer">
    <div class="container">
        <div class="row g-4 mb-4">
            <!-- Kolom Brand & Deskripsi -->
            <div class="col-lg-4 col-md-6">
                <h4 class="text-white mb-3 d-flex align-items-center gap-2">
                    <i class="bi bi-balloon-heart-fill text-warning"></i>
                    <span>ToyTopia</span>
                </h4>
                <p class="text-light-50 pe-lg-4" style="color: #cbd5e1; font-size: 0.95rem;">
                    Toko mainan online terpercaya penyedia aneka mainan edukatif, balok susun, boneka, dan permainan seru untuk mendukung tumbuh kembang dan imajinasi anak Indonesia.
                </p>
                <div class="d-flex gap-2">
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <!-- Tautan Cepat -->
            <div class="col-lg-2 col-md-6">
                <h5>Jelajahi</h5>
                <ul class="list-unstyled mb-0 d-flex flex-direction-column flex-column gap-2" style="font-size: 0.92rem;">
                    <li><a href="<?= base_url('/') ?>"><i class="bi bi-chevron-right me-1"></i>Beranda</a></li>
                    <li><a href="<?= base_url('produk') ?>"><i class="bi bi-chevron-right me-1"></i>Katalog Produk</a></li>
                    <li><a href="<?= base_url('tentang') ?>"><i class="bi bi-chevron-right me-1"></i>Tentang Kami</a></li>
                    <li><a href="<?= base_url('kontak') ?>"><i class="bi bi-chevron-right me-1"></i>Hubungi Kami</a></li>
                </ul>
            </div>

            <!-- Layanan Pelanggan -->
            <div class="col-lg-3 col-md-6">
                <h5>Layanan Pelanggan</h5>
                <ul class="list-unstyled mb-0 d-flex flex-column gap-2" style="font-size: 0.92rem;">
                    <li><a href="<?= base_url('keranjang') ?>"><i class="bi bi-chevron-right me-1"></i>Keranjang Belanja</a></li>
                    <li><a href="<?= base_url('pesanan') ?>"><i class="bi bi-chevron-right me-1"></i>Status Pesanan</a></li>
                    <li><a href="<?= base_url('tentang') ?>"><i class="bi bi-chevron-right me-1"></i>Kebijakan Pengiriman</a></li>
                    <li><a href="<?= base_url('kontak') ?>"><i class="bi bi-chevron-right me-1"></i>Bantuan & Tanya Jawab</a></li>
                </ul>
            </div>

            <!-- Kontak Toko -->
            <div class="col-lg-3 col-md-6">
                <h5>Kontak Kami</h5>
                <ul class="list-unstyled mb-0 text-light-50 d-flex flex-column gap-2" style="color: #cbd5e1; font-size: 0.92rem;">
                    <li><i class="bi bi-geo-alt-fill text-warning me-2"></i>Jl. Sudirman No. 10, Jakarta Pusat</li>
                    <li><i class="bi bi-telephone-fill text-warning me-2"></i>(021) 555-0199</li>
                    <li><i class="bi bi-envelope-fill text-warning me-2"></i>halo@toytopia.test</li>
                    <li><i class="bi bi-clock-fill text-warning me-2"></i>Senin - Sabtu: 08.00 - 17.00</li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row align-items-center text-center text-md-start" style="font-size: 0.88rem; color: #94a3b8;">
            <div class="col-md-6 mb-2 mb-md-0">
                &copy; <?= date('Y') ?> ToyTopia. Dibuat dengan cinta untuk kebahagiaan anak-anak.
            </div>
            <div class="col-md-6 text-md-end">
                <span>Pembayaran Aman &bull; Pengiriman Cepat &bull; Produk Terpilih</span>
            </div>
        </div>
    </div>
</footer>

