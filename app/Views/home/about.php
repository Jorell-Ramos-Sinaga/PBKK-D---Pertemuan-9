<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tentang Kami</li>
            </ol>
        </nav>

        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-5">
                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold mb-2">Kisah ToyTopia</span>
                <h1 class="fw-bold">Menghadirkan Keceriaan di Setiap Senyuman Anak</h1>
                <p class="lead text-muted mx-auto" style="max-width: 700px;">
                    ToyTopia berawal dari mimpi sederhana: menghadirkan tempat belanja mainan yang mengasyikkan, mendidik, dan terjangkau untuk setiap keluarga Indonesia.
                </p>
            </div>

            <div class="row g-4 align-items-center mb-5">
                <div class="col-md-6">
                    <img src="<?= file_exists(FCPATH . 'assets/img/about.jpg') ? base_url('assets/img/about.jpg') : (file_exists(FCPATH . 'assets/img/about.png') ? base_url('assets/img/about.png') : base_url('assets/img/placeholder.png')) ?>" alt="Tentang ToyTopia" class="img-fluid rounded-4 shadow-sm w-100" style="max-height: 320px; object-fit: cover;">
                </div>
                <div class="col-md-6">
                    <h3 class="fw-bold text-dark mb-3">Visi & Misi Kami</h3>
                    <p class="text-secondary">
                        Kami percaya bahwa bermain adalah cara terbaik bagi anak-anak untuk belajar, mengeksplorasi bakat, serta membangun daya imajinasi dan logika.
                    </p>
                    <ul class="list-unstyled d-flex flex-column gap-2 text-secondary">
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>Kualitas Teruji:</strong> Setiap mainan melalui seleksi ketat mengenai keamanan bahan material.</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>Edukasi Menyenangkan:</strong> Mengembangkan produk yang merangsang kreativitas kognitif dan motorik.</li>
                        <li><i class="bi bi-check-circle-fill text-success me-2"></i><strong>Akses Mudah & Cepat:</strong> Belanja online praktis dari rumah dengan pengiriman terpercaya.</li>
                    </ul>
                </div>
            </div>

            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4">
                        <h2 class="fw-bold text-primary mb-1">5.000+</h2>
                        <p class="text-muted mb-0">Anak Ceria Bersama Mainan Kami</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4">
                        <h2 class="fw-bold text-warning mb-1">100+</h2>
                        <p class="text-muted mb-0">Pilihan Mainan Edukatif</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-light rounded-4">
                        <h2 class="fw-bold text-success mb-1">100%</h2>
                        <p class="text-muted mb-0">Jaminan Keamanan Standar SNI</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

