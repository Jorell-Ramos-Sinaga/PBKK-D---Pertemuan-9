<?php
// Ambil kategori untuk dropdown navbar
$navCategories = (new \App\Models\CategoryModel())->orderBy('name', 'ASC')->findAll();
$session = session();
$isLoggedIn = $session->get('is_logged_in') ?? false;
$userRole = $session->get('user_role');
$userName = $session->get('user_name');
$cartItemsCount = cart_count();
?>
<nav class="navbar navbar-expand-lg toy-navbar sticky-top">
    <div class="container">
        <!-- Logo & Nama Toko -->
        <a class="navbar-brand" href="<?= base_url('/') ?>">
            <i class="bi bi-balloon-heart-fill"></i>
            <span>Toy<span style="color: var(--toy-secondary);">Topia</span></span>
        </a>

        <!-- Tombol Toggler Mobile -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarMain">
            <!-- Kolom Pencarian -->
            <form class="d-flex mx-lg-4 my-2 my-lg-0 flex-grow-1" action="<?= base_url('produk') ?>" method="get" style="max-width: 480px;">
                <div class="input-group">
                    <input type="text" name="q" class="form-control rounded-start-pill ps-3" placeholder="Cari mainan seru di ToyTopia..." value="<?= esc(request()->getGet('q') ?? '') ?>" aria-label="Cari mainan">
                    <button class="btn btn-toy-primary rounded-end-pill px-3" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Menu Navigasi -->
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == '' ? 'active' : '' ?>" href="<?= base_url('/') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= uri_string() == 'produk' ? 'active' : '' ?>" href="<?= base_url('produk') ?>">Katalog Produk</a>
                </li>

                <!-- Dropdown Kategori -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarCategoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori
                    </a>
                    <ul class="dropdown-menu border-0 shadow-sm rounded-3" aria-labelledby="navbarCategoryDropdown">
                        <?php if (!empty($navCategories)): ?>
                            <?php foreach ($navCategories as $cat): ?>
                                <li>
                                    <a class="dropdown-item py-2" href="<?= base_url('produk?kategori=' . $cat['slug']) ?>">
                                        <?= esc($cat['name']) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2 text-primary fw-bold" href="<?= base_url('produk') ?>">Semua Kategori &raquo;</a></li>
                    </ul>
                </li>

                <!-- Keranjang Belanja -->
                <li class="nav-item mx-lg-2 my-2 my-lg-0">
                    <a class="btn btn-light rounded-pill px-3 position-relative d-inline-flex align-items-center" href="<?= base_url('keranjang') ?>" title="Keranjang Belanja">
                        <i class="bi bi-cart3 fs-5 me-1 text-primary"></i>
                        <span class="d-none d-lg-inline fw-bold me-1">Keranjang</span>
                        <span class="badge bg-danger rounded-pill"><?= $cartItemsCount ?></span>
                    </a>
                </li>

                <!-- Menu Akun -->
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="navbarUserDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle fs-5 me-2 text-primary"></i>
                            <span class="fw-bold"><?= esc(character_limiter($userName ?? 'Pengguna', 12)) ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-sm rounded-3" aria-labelledby="navbarUserDropdown">
                            <?php if ($userRole === 'admin'): ?>
                                <li>
                                    <a class="dropdown-item py-2 text-danger fw-bold" href="<?= base_url('admin') ?>">
                                        <i class="bi bi-speedometer2 me-2"></i>Dashboard Admin
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                            <?php endif; ?>
                            <li>
                                <a class="dropdown-item py-2" href="<?= base_url('pesanan') ?>">
                                    <i class="bi bi-box-seam me-2"></i>Pesanan Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item py-2" href="<?= base_url('profil') ?>">
                                    <i class="bi bi-person-gear me-2"></i>Profil Saya
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item py-2 text-danger" href="<?= base_url('keluar') ?>">
                                    <i class="bi bi-box-arrow-right me-2"></i>Keluar
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item ms-lg-2 d-flex gap-2 my-2 my-lg-0">
                        <a class="btn btn-toy-outline btn-sm px-3" href="<?= base_url('masuk') ?>">Masuk</a>
                        <a class="btn btn-toy-primary btn-sm px-3" href="<?= base_url('daftar') ?>">Daftar</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

