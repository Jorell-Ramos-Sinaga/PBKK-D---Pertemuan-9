<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin Panel') ?> - ToyTopia</title>

    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>⚙️</text></svg>">
    
    <!-- Bootstrap 5.3 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Custom ToyTopia CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body class="bg-light">

    <!-- Top Admin Bar -->
    <header class="navbar navbar-dark bg-dark sticky-top p-2 shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand me-0 fs-5 d-flex align-items-center gap-2" href="<?= base_url('admin') ?>">
                <i class="bi bi-shield-lock-fill text-warning"></i>
                <span class="fw-bold">ToyTopia <span class="badge bg-warning text-dark fs-6 ms-1">Admin</span></span>
            </a>
            <div class="d-flex align-items-center gap-3">
                <a href="<?= base_url('/') ?>" class="btn btn-sm btn-outline-light rounded-pill px-3" target="_blank">
                    <i class="bi bi-shop me-1"></i>Lihat Toko
                </a>
                <span class="text-white-50 d-none d-md-inline">|</span>
                <span class="text-light small d-none d-md-inline">
                    <i class="bi bi-person-circle me-1"></i><?= esc(session()->get('user_name') ?? 'Admin') ?>
                </span>
                <a href="<?= base_url('keluar') ?>" class="btn btn-sm btn-danger rounded-pill px-3">
                    <i class="bi bi-box-arrow-right me-1"></i>Keluar
                </a>
            </div>
        </div>
    </header>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block admin-sidebar collapse show" id="sidebarMenu">
                <div class="position-sticky pt-3">
                    <h6 class="sidebar-heading px-3 mt-1 mb-2 text-muted text-uppercase fs-7 fw-bold">
                        <span>Menu Navigasi</span>
                    </h6>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= uri_string() == 'admin' ? 'active' : '' ?>" href="<?= base_url('admin') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/kategori') ? 'active' : '' ?>" href="<?= base_url('admin/kategori') ?>">
                                <i class="bi bi-grid"></i> Kategori Mainan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/produk') ? 'active' : '' ?>" href="<?= base_url('admin/produk') ?>">
                                <i class="bi bi-box-seam"></i> Produk Mainan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/pesanan') ? 'active' : '' ?>" href="<?= base_url('admin/pesanan') ?>">
                                <i class="bi bi-cart-check"></i> Pesanan Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= str_starts_with(uri_string(), 'admin/pelanggan') ? 'active' : '' ?>" href="<?= base_url('admin/pelanggan') ?>">
                                <i class="bi bi-people"></i> Daftar Pelanggan
                            </a>
                        </li>
                    </ul>

                    <h6 class="sidebar-heading px-3 mt-4 mb-2 text-muted text-uppercase fs-7 fw-bold">
                        <span>Tautan Luar</span>
                    </h6>
                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/') ?>" target="_blank">
                                <i class="bi bi-box-arrow-up-right"></i> Kunjungi Toko
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="<?= base_url('keluar') ?>">
                                <i class="bi bi-power"></i> Keluar Sistem
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content Area -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                <!-- Flash Alerts -->
                <?= $this->include('partials/flash') ?>

                <!-- Konten Halaman Admin -->
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Bootstrap 5.3 JS Bundle CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <!-- Custom App JS -->
    <script src="<?= base_url('assets/js/app.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>
</body>
</html>

