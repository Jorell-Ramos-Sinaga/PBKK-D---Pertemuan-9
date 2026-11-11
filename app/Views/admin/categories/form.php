<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>

<?php
$isEdit = !empty($category);
$actionUrl = $isEdit ? base_url('admin/kategori/perbarui/' . $category['id']) : base_url('admin/kategori/simpan');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-2 pb-3 mb-4 border-bottom">
    <div>
        <h2 class="h3 fw-bold mb-1"><?= $isEdit ? 'Ubah Kategori Mainan' : 'Tambah Kategori Baru' ?></h2>
        <span class="text-muted small">Kelola informasi nama dan slug kategori</span>
    </div>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="<?= base_url('admin/kategori') ?>" class="btn btn-sm btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <form action="<?= $actionUrl ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="name" class="form-label fw-bold">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control rounded-3" placeholder="Contoh: Balok Susun" value="<?= old('name', $category['name'] ?? '') ?>" required autofocus>
                    <small class="text-muted">Slug URL akan dibuat otomatis dari nama kategori bila dikosongkan.</small>
                </div>

                <div class="mb-3">
                    <label for="slug" class="form-label fw-bold">Slug URL (Opsional)</label>
                    <input type="text" name="slug" id="slug" class="form-control rounded-3" placeholder="contoh: balok-susun" value="<?= old('slug', $category['slug'] ?? '') ?>">
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold">Deskripsi Kategori</label>
                    <textarea name="description" id="description" class="form-control rounded-3" rows="4" placeholder="Jelaskan jenis mainan yang termasuk dalam kategori ini..."><?= old('description', $category['description'] ?? '') ?></textarea>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-toy-primary rounded-pill px-4">
                        <i class="bi bi-save me-1"></i><?= $isEdit ? 'Simpan Perubahan' : 'Tambah Kategori' ?>
                    </button>
                    <a href="<?= base_url('admin/kategori') ?>" class="btn btn-outline-secondary rounded-pill px-4">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

