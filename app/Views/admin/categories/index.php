<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1">Kategori Mainan</h2>
        <span class="text-muted small">Kelola klasifikasi dan jenis produk toko online ToyTopia</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/kategori/baru') ?>" class="btn btn-sm btn-toy-primary shadow-sm">
            <i class="bi bi-plus-circle me-1"></i>Tambah Kategori Baru
        </a>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="ps-4 py-3" style="width: 60px;">#</th>
                    <th class="py-3">Nama Kategori</th>
                    <th class="py-3">Slug</th>
                    <th class="py-3">Deskripsi</th>
                    <th class="py-3 text-center">Jumlah Produk</th>
                    <th class="py-3 text-center pe-4" style="width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($categories)): ?>
                    <?php $no = 1; foreach ($categories as $cat): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $no++ ?></td>
                            <td class="fw-bold text-dark">
                                <?= esc($cat['name']) ?>
                            </td>
                            <td>
                                <code><?= esc($cat['slug']) ?></code>
                            </td>
                            <td class="small text-muted" style="max-width: 300px;">
                                <?= esc($cat['description'] ?? '-') ?>
                            </td>
                            <td class="text-center">
                                <span class="badge bg-primary rounded-pill px-3 py-1">
                                    <?= $cat['total_products'] ?> produk
                                </span>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="<?= base_url('admin/kategori/ubah/' . $cat['id']) ?>" class="btn btn-sm btn-outline-secondary rounded-circle" title="Ubah">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="<?= base_url('admin/kategori/hapus/' . $cat['id']) ?>" method="post" class="d-inline">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle btn-delete-confirm" data-confirm="Hapus kategori '<?= esc($cat['name']) ?>'?" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Belum ada data kategori.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>

