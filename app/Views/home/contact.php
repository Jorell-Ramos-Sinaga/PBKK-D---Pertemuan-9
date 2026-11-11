<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Hubungi Kami</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-5">
                <span class="badge bg-primary text-white px-3 py-2 rounded-pill fw-bold mb-2">Bantuan Pelanggan</span>
                <h1 class="fw-bold">Kami Siap Mendengar & Membantu Anda!</h1>
                <p class="text-muted">Punya pertanyaan seputar produk, stok, atau pengiriman? Jangan ragu untuk menghubungi kami.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-5">
                    <div class="p-4 rounded-4 bg-light h-100">
                        <h4 class="fw-bold mb-4">Informasi Kontak</h4>
                        
                        <div class="d-flex mb-3 align-items-start">
                            <div class="fs-4 text-primary me-3"><i class="bi bi-geo-alt-fill"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Alamat Gudang & Kantor</h6>
                                <p class="text-muted small mb-0">Jl. Sudirman No. 10, Jakarta Pusat, DKI Jakarta 10220</p>
                            </div>
                        </div>

                        <div class="d-flex mb-3 align-items-start">
                            <div class="fs-4 text-success me-3"><i class="bi bi-whatsapp"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">WhatsApp Customer Service</h6>
                                <p class="text-muted small mb-0">+62 812-9876-5432 (Fast Response)</p>
                            </div>
                        </div>

                        <div class="d-flex mb-3 align-items-start">
                            <div class="fs-4 text-warning me-3"><i class="bi bi-envelope-fill"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Email Resmi</h6>
                                <p class="text-muted small mb-0">halo@toytopia.test / cs@toytopia.test</p>
                            </div>
                        </div>

                        <div class="d-flex align-items-start">
                            <div class="fs-4 text-danger me-3"><i class="bi bi-clock-fill"></i></div>
                            <div>
                                <h6 class="fw-bold mb-1">Jam Operasional</h6>
                                <p class="text-muted small mb-0">Senin - Sabtu: 08:00 - 17:00 WIB<br>Minggu & Libur Nasional: Tutup</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="p-4 rounded-4 border">
                        <h4 class="fw-bold mb-3">Kirim Pesan Cepat</h4>
                        <p class="text-muted small mb-4">Isi formulir di bawah ini, tim customer care kami akan merespons dalam 1x24 jam kerja.</p>

                        <form onsubmit="event.preventDefault(); alert('Terima kasih! Pesan Anda telah terkirim.'); this.reset();">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Lengkap</label>
                                <input type="text" class="form-control rounded-3" placeholder="Contoh: Budi Santoso" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Alamat Email</label>
                                <input type="email" class="form-control rounded-3" placeholder="nama@email.com" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Pesan / Pertanyaan</label>
                                <textarea class="form-control rounded-3" rows="4" placeholder="Tuliskan pesan Anda di sini..." required></textarea>
                            </div>
                            <button type="submit" class="btn btn-toy-primary px-4">
                                <i class="bi bi-send-fill me-1"></i>Kirim Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

