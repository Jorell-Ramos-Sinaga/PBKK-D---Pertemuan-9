<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Beranda</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
    </ol>
</nav>

<div class="row g-4">
    <!-- Sidebar Ringkasan Profil -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white">
            <div class="mx-auto mb-3">
                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px; font-size: 2.5rem;">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <h4 class="fw-bold mb-1"><?= esc($user['name']) ?></h4>
            <p class="text-muted small mb-2"><?= esc($user['email']) ?></p>
            <div>
                <span class="badge bg-secondary rounded-pill px-3 py-1 text-uppercase"><?= esc($user['role']) ?></span>
            </div>

            <hr class="my-4">

            <div class="d-grid gap-2 text-start">
                <a href="<?= base_url('pesanan') ?>" class="btn btn-outline-primary rounded-pill py-2 text-start">
                    <i class="bi bi-box-seam me-2"></i>Lihat Pesanan Saya
                </a>
                <a href="<?= base_url('keranjang') ?>" class="btn btn-outline-secondary rounded-pill py-2 text-start">
                    <i class="bi bi-cart3 me-2"></i>Keranjang Belanja
                </a>
                <a href="<?= base_url('keluar') ?>" class="btn btn-outline-danger rounded-pill py-2 text-start">
                    <i class="bi bi-box-arrow-right me-2"></i>Keluar Akun
                </a>
            </div>
        </div>
    </div>

    <!-- Form Pengaturan Profil & Ganti Password -->
    <div class="col-md-8">
        <!-- Tab Nav -->
        <ul class="nav nav-pills mb-4 gap-2" id="profileTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill px-4 fw-bold" id="info-tab" data-bs-toggle="pill" data-bs-target="#tab-info" type="button" role="tab">
                    <i class="bi bi-person-lines-fill me-1"></i>Biodata & Alamat
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill px-4 fw-bold" id="password-tab" data-bs-toggle="pill" data-bs-target="#tab-password" type="button" role="tab">
                    <i class="bi bi-shield-lock me-1"></i>Ganti Kata Sandi
                </button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabContent">
            <!-- Tab 1: Biodata & Alamat -->
            <div class="tab-pane fade show active" id="tab-info" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Informasi Akun & Pengiriman</h5>
                    
                    <form action="<?= base_url('profil') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control rounded-3" value="<?= old('name', $user['name']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold">Alamat Email</label>
                            <input type="email" id="email" class="form-control rounded-3 bg-light" value="<?= esc($user['email']) ?>" readonly>
                            <small class="text-muted">Email tidak dapat diubah demi keamanan akun.</small>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label fw-bold">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="phone" id="phone" class="form-control rounded-3" placeholder="08xxxxxxxxxx" value="<?= old('phone', $user['phone'] ?? '') ?>">
                        </div>

                        <div class="mb-4">
                            <label for="address" class="form-label fw-bold">Alamat Default Pengiriman</label>
                            <textarea name="address" id="address" class="form-control rounded-3" rows="3" placeholder="Alamat lengkap rumah / kantor..."><?= old('address', $user['address'] ?? '') ?></textarea>
                            <small class="text-muted">Alamat ini akan otomatis digunakan saat proses checkout.</small>
                        </div>

                        <button type="submit" class="btn btn-toy-primary rounded-pill px-4">
                            <i class="bi bi-save me-1"></i>Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab 2: Ganti Password -->
            <div class="tab-pane fade" id="tab-password" role="tabpanel">
                <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
                    <h5 class="fw-bold mb-3">Ubah Kata Sandi</h5>

                    <form action="<?= base_url('profil/password') ?>" method="post">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="current_password" class="form-label fw-bold">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" id="current_password" class="form-control rounded-3" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label fw-bold">Kata Sandi Baru</label>
                            <input type="password" name="new_password" id="new_password" class="form-control rounded-3" placeholder="Minimal 8 karakter" required>
                        </div>

                        <div class="mb-4">
                            <label for="new_password_confirm" class="form-label fw-bold">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" name="new_password_confirm" id="new_password_confirm" class="form-control rounded-3" placeholder="Ulangi kata sandi baru" required>
                        </div>

                        <button type="submit" class="btn btn-toy-secondary rounded-pill px-4">
                            <i class="bi bi-key-fill me-1"></i>Perbarui Kata Sandi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

