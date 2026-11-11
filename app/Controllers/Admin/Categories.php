<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Categories extends BaseController
{
    protected CategoryModel $categoryModel;
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        $this->productModel  = new ProductModel();
    }

    /**
     * Daftar Semua Kategori
     */
    public function index()
    {
        $db = \Config\Database::connect();
        $categories = $db->table('categories')
            ->select('categories.*, COUNT(products.id) as total_products')
            ->join('products', 'products.category_id = categories.id', 'left')
            ->groupBy('categories.id')
            ->orderBy('categories.name', 'ASC')
            ->get()
            ->getResultArray();

        $data = [
            'title'      => 'Manajemen Kategori Mainan',
            'categories' => $categories,
        ];

        return view('admin/categories/index', $data);
    }

    /**
     * Form Tambah Kategori Baru
     */
    public function new()
    {
        $data = [
            'title'    => 'Tambah Kategori Mainan',
            'category' => null,
        ];

        return view('admin/categories/form', $data);
    }

    /**
     * Simpan Kategori Baru
     */
    public function create()
    {
        $name = trim($this->request->getPost('name') ?? '');
        $slug = trim($this->request->getPost('slug') ?? '');

        if (empty($slug)) {
            $slug = url_title($name, '-', true);
        }

        // Cek keunikan slug
        $existing = $this->categoryModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $rules = [
            'name' => [
                'label'  => 'Nama Kategori',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                ],
            ],
            'description' => [
                'label' => 'Deskripsi Kategori',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->insert([
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(base_url('admin/kategori'))->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    /**
     * Form Edit Kategori
     */
    public function edit(int $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            throw PageNotFoundException::forPageNotFound('Kategori tidak ditemukan.');
        }

        $data = [
            'title'    => 'Ubah Kategori Mainan',
            'category' => $category,
        ];

        return view('admin/categories/form', $data);
    }

    /**
     * Perbarui Kategori
     */
    public function update(int $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to(base_url('admin/kategori'))->with('error', 'Kategori tidak ditemukan.');
        }

        $name = trim($this->request->getPost('name') ?? '');
        $slug = trim($this->request->getPost('slug') ?? '');

        if (empty($slug)) {
            $slug = url_title($name, '-', true);
        }

        $rules = [
            'name' => [
                'label'  => 'Nama Kategori',
                'rules'  => 'required|min_length[3]|max_length[100]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                ],
            ],
            'slug' => [
                'label'  => 'Slug Kategori',
                'rules'  => 'required|max_length[120]|is_unique[categories.slug,id,' . $id . ']',
                'errors' => [
                    'required'  => '{field} wajib diisi.',
                    'is_unique' => 'Slug sudah digunakan oleh kategori lain.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->categoryModel->update($id, [
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(base_url('admin/kategori'))->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus Kategori (Ditolak bila masih punya produk)
     */
    public function delete(int $id)
    {
        $category = $this->categoryModel->find($id);
        if (!$category) {
            return redirect()->to(base_url('admin/kategori'))->with('error', 'Kategori tidak ditemukan.');
        }

        // Validasi: cek apakah masih ada produk di kategori ini
        $productCount = $this->productModel->where('category_id', $id)->countAllResults();
        if ($productCount > 0) {
            return redirect()->to(base_url('admin/kategori'))->with('error', 'Kategori "' . esc($category['name']) . '" tidak dapat dihapus karena masih memuat ' . $productCount . ' produk mainan.');
        }

        $this->categoryModel->delete($id);

        return redirect()->to(base_url('admin/kategori'))->with('success', 'Kategori berhasil dihapus.');
    }
}

