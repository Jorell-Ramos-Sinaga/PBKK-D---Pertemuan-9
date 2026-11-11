<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($product);
$actionUrl = $isEdit ? base_url('admin/produk/perbarui/' . $product['id']) : base_url('admin/produk/simpan');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1"><?= $isEdit ? 'Ubah Data Produk Mainan' : 'Tambah Produk Mainan Baru' ?></h2>
        <span class="text-muted small">Kelola informasi katalog, harga, ketersediaan stok, dan foto mainan</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/produk') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
        </a>
    </div>
</div>

<form action="<?= $actionUrl ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>

    <div class="row g-4">
        <!-- Kolom Kiri: Informasi Utama -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Produk Mainan</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3" placeholder="Contoh: Balok Susun Kota Metropolitan 500 Pcs" value="<?= old('name', $product['name'] ?? '') ?>" required autofocus>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="category_id" class="form-label fw-bold">Kategori</label>
                        <select name="category_id" id="category_id" class="form-select rounded-3" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= old('category_id', $product['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                    <?= esc($cat['name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="age_range" class="form-label fw-bold">Rekomendasi Usia (Opsional)</label>
                        <input type="text" name="age_range" id="age_range" class="form-control rounded-3" placeholder="Contoh: 3+ tahun / 6-12 tahun" value="<?= old('age_range', $product['age_range'] ?? '') ?>">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="price" class="form-label fw-bold">Harga Produk (Rupiah)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light">Rp</span>
                            <input type="number" name="price" id="price" class="form-control rounded-end-3" placeholder="Contoh: 125000" min="0" step="1" value="<?= old('price', $product['price'] ?? '') ?>" required>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-bold">Jumlah Stok Fisik</label>
                        <input type="number" name="stock" id="stock" class="form-control rounded-3" placeholder="Contoh: 20" min="0" value="<?= old('stock', $product['stock'] ?? 0) ?>" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Deskripsi Lengkap Produk</label>
                    <textarea name="description" id="description" class="form-control rounded-3" rows="7" placeholder="Jelaskan spesifikasi bahan, ukuran, manfaat edukatif, dan kelengkapan di dalam kotak mainan..." required><?= old('description', $product['description'] ?? '') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Foto & Status -->
        <div class="col-lg-4">
            <!-- Upload Foto -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4 text-center">
                <h6 class="fw-bold text-start mb-3">Foto Mainan</h6>

                <div class="mb-3">
                    <img id="productImagePreview" src="<?= product_image($product['image'] ?? null) ?>" alt="Preview Foto" class="img-fluid rounded-4 border shadow-sm" style="max-height: 220px; object-fit: cover; width: 100%;">
                </div>

                <div class="mb-2">
                    <input type="file" name="image" id="imageInput" class="form-control form-control-sm image-upload-preview" data-preview-target="productImagePreview" accept="image/png, image/jpeg, image/jpg, image/webp">
                </div>
                <small class="text-muted d-block text-start">Format: JPG, PNG, WEBP. Maksimal 2 MB.</small>
            </div>

            <!-- Opsi Status -->
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white mb-4">
                <h6 class="fw-bold mb-3">Opsi Tampilan</h6>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_featured" id="is_featured" value="1" <?= old('is_featured', $product['is_featured'] ?? 0) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold small" for="is_featured">
                        Jadikan Produk Unggulan
                    </label>
                    <small class="text-muted d-block">Tampil di seksi Produk Unggulan di Beranda.</small>
                </div>

                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="is_active" value="1" <?= old('is_active', $product['is_active'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label fw-bold small" for="is_active">
                        Status Produk Aktif
                    </label>
                    <small class="text-muted d-block">Jika nonaktif, produk tidak akan muncul di katalog publik.</small>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-toy-primary btn-lg rounded-pill shadow-sm">
                    <i class="bi bi-save me-1"></i><?= $isEdit ? 'Simpan Perubahan' : 'Terbitkan Produk' ?>
                </button>
                <a href="<?= base_url('admin/produk') ?>" class="btn btn-outline-secondary rounded-pill">
                    Batal
                </a>
            </div>
        </div>
    </div>
</form>

<?= $this->endSection() ?>

