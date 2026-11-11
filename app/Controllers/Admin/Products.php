<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;
use App\Models\ProductModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Products extends BaseController
{
    protected ProductModel $productModel;
    protected CategoryModel $categoryModel;

    public function __construct()
    {
        $this->productModel  = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Daftar Semua Produk untuk Admin dengan Pencarian & Pagination
     */
    public function index()
    {
        $keyword    = trim($this->request->getGet('q') ?? '');
        $categoryId = $this->request->getGet('kategori');

        $builder = $this->productModel
            ->select('products.*, categories.name as category_name')
            ->join('categories', 'categories.id = products.category_id', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('products.name', $keyword)
                ->orLike('products.description', $keyword)
                ->groupEnd();
        }

        if (!empty($categoryId)) {
            $builder->where('products.category_id', (int) $categoryId);
        }

        $products = $builder->orderBy('products.id', 'DESC')->paginate(15, 'admin_products');
        $pager    = $this->productModel->pager;

        $data = [
            'title'      => 'Manajemen Produk Mainan',
            'products'   => $products,
            'pager'      => $pager,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
            'keyword'    => $keyword,
            'categoryId' => $categoryId,
        ];

        return view('admin/products/index', $data);
    }

    /**
     * Form Tambah Produk Baru
     */
    public function new()
    {
        $data = [
            'title'      => 'Tambah Produk Mainan Baru',
            'product'    => null,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('admin/products/form', $data);
    }

    /**
     * Simpan Produk Baru
     */
    public function create()
    {
        $rules = [
            'category_id' => [
                'label'  => 'Kategori Mainan',
                'rules'  => 'required|is_not_unique[categories.id]',
                'errors' => [
                    'required'      => '{field} wajib dipilih.',
                    'is_not_unique' => '{field} tidak valid.',
                ],
            ],
            'name' => [
                'label'  => 'Nama Produk',
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                ],
            ],
            'price' => [
                'label'  => 'Harga Satuan',
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required'     => '{field} wajib diisi.',
                    'numeric'      => '{field} harus berupa angka.',
                    'greater_than' => '{field} harus lebih dari 0.',
                ],
            ],
            'stock' => [
                'label'  => 'Jumlah Stok',
                'rules'  => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => '{field} wajib diisi.',
                    'integer'               => '{field} harus berupa bilangan bulat.',
                    'greater_than_equal_to' => '{field} tidak boleh minus.',
                ],
            ],
            'description' => [
                'label'  => 'Deskripsi Produk',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ],
            ],
            'image' => [
                'label'  => 'Foto Mainan',
                'rules'  => 'permit_empty|uploaded[image]|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2 MB.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus berupa JPG, PNG, atau WEBP.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Penanganan upload gambar
        $imageName = null;
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            $imageName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $imageName);
        }

        // Slug
        $name = trim($this->request->getPost('name'));
        $slug = url_title($name, '-', true);
        $existing = $this->productModel->where('slug', $slug)->first();
        if ($existing) {
            $slug .= '-' . time();
        }

        $productData = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name'        => $name,
            'slug'        => $slug,
            'description' => $this->request->getPost('description'),
            'price'       => (float) $this->request->getPost('price'),
            'stock'       => (int) $this->request->getPost('stock'),
            'age_range'   => $this->request->getPost('age_range') ?: null,
            'image'       => $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->productModel->insert($productData);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk mainan baru berhasil ditambahkan.');
    }

    /**
     * Form Edit Produk
     */
    public function edit(int $id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            throw PageNotFoundException::forPageNotFound('Produk tidak ditemukan.');
        }

        $data = [
            'title'      => 'Ubah Produk Mainan',
            'product'    => $product,
            'categories' => $this->categoryModel->orderBy('name', 'ASC')->findAll(),
        ];

        return view('admin/products/form', $data);
    }

    /**
     * Perbarui Data Produk
     */
    public function update(int $id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        $rules = [
            'category_id' => [
                'label'  => 'Kategori Mainan',
                'rules'  => 'required|is_not_unique[categories.id]',
                'errors' => [
                    'required'      => '{field} wajib dipilih.',
                    'is_not_unique' => '{field} tidak valid.',
                ],
            ],
            'name' => [
                'label'  => 'Nama Produk',
                'rules'  => 'required|min_length[3]|max_length[150]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 3 karakter.',
                ],
            ],
            'price' => [
                'label'  => 'Harga Satuan',
                'rules'  => 'required|numeric|greater_than[0]',
                'errors' => [
                    'required'     => '{field} wajib diisi.',
                    'numeric'      => '{field} harus berupa angka.',
                    'greater_than' => '{field} harus lebih dari 0.',
                ],
            ],
            'stock' => [
                'label'  => 'Jumlah Stok',
                'rules'  => 'required|integer|greater_than_equal_to[0]',
                'errors' => [
                    'required'              => '{field} wajib diisi.',
                    'integer'               => '{field} harus berupa bilangan bulat.',
                    'greater_than_equal_to' => '{field} tidak boleh minus.',
                ],
            ],
            'description' => [
                'label'  => 'Deskripsi Produk',
                'rules'  => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ],
            ],
            'image' => [
                'label'  => 'Foto Mainan',
                'rules'  => 'permit_empty|max_size[image,2048]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]',
                'errors' => [
                    'max_size' => 'Ukuran foto maksimal 2 MB.',
                    'is_image' => 'File yang diunggah harus berupa gambar.',
                    'mime_in'  => 'Format gambar harus berupa JPG, PNG, atau WEBP.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $imageName = $product['image'];
        $imageFile = $this->request->getFile('image');
        if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
            // Hapus gambar lama jika ada
            if ($imageName && file_exists(FCPATH . 'uploads/products/' . $imageName)) {
                unlink(FCPATH . 'uploads/products/' . $imageName);
            }

            $imageName = $imageFile->getRandomName();
            $imageFile->move(FCPATH . 'uploads/products', $imageName);
        }

        $productData = [
            'category_id' => (int) $this->request->getPost('category_id'),
            'name'        => trim($this->request->getPost('name')),
            'description' => $this->request->getPost('description'),
            'price'       => (float) $this->request->getPost('price'),
            'stock'       => (int) $this->request->getPost('stock'),
            'age_range'   => $this->request->getPost('age_range') ?: null,
            'image'       => $imageName,
            'is_featured' => $this->request->getPost('is_featured') ? 1 : 0,
            'is_active'   => $this->request->getPost('is_active') ? 1 : 0,
        ];

        $this->productModel->update($id, $productData);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Data produk mainan berhasil diperbarui.');
    }

    /**
     * Hapus Produk
     */
    public function delete(int $id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            return redirect()->to(base_url('admin/produk'))->with('error', 'Produk tidak ditemukan.');
        }

        // Hapus file foto produk jika ada
        if ($product['image'] && file_exists(FCPATH . 'uploads/products/' . $product['image'])) {
            unlink(FCPATH . 'uploads/products/' . $product['image']);
        }

        $this->productModel->delete($id);

        return redirect()->to(base_url('admin/produk'))->with('success', 'Produk mainan berhasil dihapus.');
    }
}

