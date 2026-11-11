<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Katalog Produk Mainan</h2>
        <span class="text-muted small">Kelola data seluruh produk mainan, harga, stok, dan gambar</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/produk/baru') ?>" class="btn btn-sm btn-toy-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah Produk Baru
        </a>
    </div>
</div>

<!-- Filter & Pencarian Toolbar -->
<div class="card border-0 shadow-sm rounded-4 p-3 bg-white mb-4">
    <form action="<?= base_url('admin/produk') ?>" method="get" class="row g-2 align-items-center">
        <div class="col-md-5">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" name="q" class="form-control border-start-0" placeholder="Cari nama atau deskripsi mainan..." value="<?= esc($keyword ?? '') ?>">
            </div>
        </div>
        <div class="col-md-4">
            <select name="kategori" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">Semua Kategori Mainan</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($categoryId == $cat['id']) ? 'selected' : '' ?>>
                        <?= esc($cat['name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-sm btn-secondary flex-grow-1">Filter</button>
            <?php if (!empty($keyword) || !empty($categoryId)): ?>
                <a href="<?= base_url('admin/produk') ?>" class="btn btn-sm btn-outline-danger">Reset</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- Tabel Produk -->
<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3" style="width: 70px;">Foto</th>
                    <th class="py-3">Nama Produk</th>
                    <th class="py-3">Kategori</th>
                    <th class="py-3">Harga</th>
                    <th class="py-3 text-center">Stok</th>
                    <th class="py-3 text-center">Status</th>
                    <th class="py-3 text-center pe-4" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $prod): ?>
                        <tr>
                            <td class="ps-4 py-2">
                                <img src="<?= product_image($prod['image'] ?? null) ?>" alt="<?= esc($prod['name']) ?>" class="rounded-3 border" style="width: 50px; height: 50px; object-fit: cover;">
                            </td>
                            <td>
                                <a href="<?= base_url('produk/' . $prod['slug']) ?>" target="_blank" class="fw-bold text-dark text-decoration-none d-block">
                                    <?= esc($prod['name']) ?>
                                </a>
                                <div class="d-flex gap-1 mt-1">
                                    <?php if ($prod['is_featured']): ?>
                                        <span class="badge bg-warning text-dark fs-8 py-0 px-2"><i class="bi bi-star-fill me-1"></i>Unggulan</span>
                                    <?php endif; ?>
                                    <?php if (!empty($prod['age_range'])): ?>
                                        <span class="badge bg-light text-secondary border fs-8 py-0 px-2"><?= esc($prod['age_range']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="small text-muted">
                                <?= esc($prod['category_name'] ?? 'Tanpa Kategori') ?>
                            </td>
                            <td class="fw-bold text-danger" style="font-family: 'Baloo 2', cursive;">
                                <?= format_rupiah($prod['price']) ?>
                            </td>
                            <td class="text-center">
                                <?php if ($prod['stock'] <= 0): ?>
                                    <span class="badge bg-danger rounded-pill">Habis (0)</span>
                                <?php elseif ($prod['stock'] <= 5): ?>
                                    <span class="badge bg-warning text-dark rounded-pill"><?= $prod['stock'] ?> unit</span>
                                <?php else: ?>
                                    <span class="badge bg-success rounded-pill"><?= $prod['stock'] ?> unit</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?= $prod['is_active'] ? '<span class="badge bg-success-subtle text-success">Aktif</span>' : '<span class="badge bg-secondary-subtle text-secondary">Nonaktif</span>' ?>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?= base_url('admin/produk/ubah/' . $prod['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-circle" title="Ubah Produk">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= base_url('admin/produk/hapus/' . $prod['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle btn-delete-confirm" data-confirm="Hapus produk '<?= esc($prod['name']) ?>'?" title="Hapus Produk">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">Tidak ada produk yang cocok dengan pencarian.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pager -->
    <?php if ($pager->getPageCount('admin_products') > 1): ?>
        <div class="card-footer bg-white py-3 d-flex justify-content-center">
            <?= $pager->links('admin_products', 'default_full') ?>
        </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>

