<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center py-4">
    <div class="col-md-8 col-lg-6">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white">
            <div class="text-center mb-4">
                <div class="fs-1 text-primary mb-2">
                    <i class="bi bi-person-plus-fill"></i>
                </div>
                <h2 class="fw-bold">Buat Akun Baru</h2>
                <p class="text-muted small">Daftar sekarang untuk mulai berbelanja mainan favorit si kecil!</p>
            </div>

            <form action="<?= base_url('daftar') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3" placeholder="Contoh: Budi Santoso" value="<?= old('name') ?>" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label fw-bold">Alamat Email</label>
                    <input type="email" name="email" id="email" class="form-control rounded-3" placeholder="nama@email.com" value="<?= old('email') ?>" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="password" class="form-label fw-bold">Kata Sandi</label>
                        <input type="password" name="password" id="password" class="form-control rounded-3" placeholder="Min. 8 karakter" required>
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirm" class="form-label fw-bold">Konfirmasi Sandi</label>
                        <input type="password" name="password_confirm" id="password_confirm" class="form-control rounded-3" placeholder="Ulangi sandi" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label fw-bold">Nomor Telepon (WhatsApp)</label>
                    <input type="text" name="phone" id="phone" class="form-control rounded-3" placeholder="08xxxxxxxxxx" value="<?= old('phone') ?>">
                </div>

                <div class="mb-4">
                    <label for="address" class="form-label fw-bold">Alamat Lengkap (Opsional)</label>
                    <textarea name="address" id="address" class="form-control rounded-3" rows="2" placeholder="Alamat rumah pengiriman..."><?= old('address') ?></textarea>
                </div>

                <button type="submit" class="btn btn-toy-primary w-100 py-2 fs-6 shadow-sm mb-3">
                    <i class="bi bi-check2-circle me-1"></i>Daftar Sekarang
                </button>

                <div class="text-center text-muted small">
                    Sudah memiliki akun? <a href="<?= base_url('masuk') ?>" class="text-primary fw-bold text-decoration-none">Masuk di sini</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

