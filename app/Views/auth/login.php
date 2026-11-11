<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center py-4">
    <div class="col-md-7 col-lg-5">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <div class="fs-1 text-primary mb-2">
                    <i class="bi bi-box-arrow-in-right"></i>
                </div>
                <h2 class="fw-bold">Masuk ke ToyTopia</h2>
                <p class="text-muted small">Silakan masukkan email dan kata sandi Anda</p>
            </div>

            <form action="<?= base_url('masuk') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Alamat Email</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-envelope"></i></span>
                        <input type="email" name="email" id="email" class="form-control border-start-0 rounded-end-3" placeholder="nama@email.com" value="<?= old('email') ?>" required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <label for="password" class="form-label fw-bold mb-0">Kata Sandi</label>
                    </div>
                    <div class="input-group mt-1">
                        <span class="input-group-text bg-light border-end-0 rounded-start-3"><i class="bi bi-lock"></i></span>
                        <input type="password" name="password" id="password" class="form-control border-start-0 rounded-end-3" placeholder="Minimal 8 karakter" required>
                    </div>
                </div>

                <button type="submit" class="btn btn-toy-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-box-arrow-in-right me-1"></i>Masuk Sekarang
                </button>

                <div class="text-center text-muted small">
                    Belum punya akun? <a href="<?= base_url('daftar') ?>" class="text-primary fw-bold text-decoration-none">Daftar sekarang</a>
                </div>
            </form>

            <!-- Info Demo Akun -->
            <div class="mt-4 pt-3 border-top text-center">
                <small class="text-muted d-block fw-bold mb-1">Akun Percobaan (Demo):</small>
                <div class="d-flex justify-content-center gap-2 small">
                    <span class="badge bg-light text-dark border">Admin: admin@toytopia.test / admin123</span>
                </div>
                <div class="d-flex justify-content-center gap-2 small mt-1">
                    <span class="badge bg-light text-dark border">Customer: budi@toytopia.test / user12345</span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

