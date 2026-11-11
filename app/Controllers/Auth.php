<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Halaman & Proses Registrasi Akun Pelanggan
     */
    public function register()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to(base_url('/'));
        }

        if ($this->request->is('post')) {
            $rules = [
                'name' => [
                    'label' => 'Nama Lengkap',
                    'rules' => 'required|min_length[3]|max_length[100]',
                    'errors' => [
                        'required'   => '{field} wajib diisi.',
                        'min_length' => '{field} minimal 3 karakter.',
                        'max_length' => '{field} maksimal 100 karakter.',
                    ],
                ],
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email|is_unique[users.email]',
                    'errors' => [
                        'required'    => '{field} wajib diisi.',
                        'valid_email' => 'Format {field} tidak valid.',
                        'is_unique'   => '{field} sudah terdaftar. Silakan gunakan email lain atau masuk.',
                    ],
                ],
                'password' => [
                    'label' => 'Kata Sandi',
                    'rules' => 'required|min_length[8]',
                    'errors' => [
                        'required'   => '{field} wajib diisi.',
                        'min_length' => '{field} minimal 8 karakter.',
                    ],
                ],
                'password_confirm' => [
                    'label' => 'Konfirmasi Kata Sandi',
                    'rules' => 'required|matches[password]',
                    'errors' => [
                        'required' => '{field} wajib diisi.',
                        'matches'  => '{field} tidak cocok dengan kata sandi.',
                    ],
                ],
                'phone' => [
                    'label' => 'Nomor Telepon',
                    'rules' => 'permit_empty|numeric|min_length[10]|max_length[15]',
                    'errors' => [
                        'numeric'    => '{field} hanya boleh berisi angka.',
                        'min_length' => '{field} minimal 10 digit.',
                        'max_length' => '{field} maksimal 15 digit.',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            // Simpan akun baru
            $userData = [
                'name'     => $this->request->getPost('name'),
                'email'    => strtolower(trim($this->request->getPost('email'))),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'phone'    => $this->request->getPost('phone') ?? null,
                'address'  => $this->request->getPost('address') ?? null,
                'role'     => 'customer',
            ];

            $this->userModel->insert($userData);

            return redirect()->to(base_url('masuk'))->with('success', 'Pendaftaran berhasil! Silakan masuk dengan email dan kata sandi Anda.');
        }

        $data = [
            'title' => 'Daftar Akun Baru',
        ];

        return view('auth/register', $data);
    }

    /**
     * Halaman & Proses Masuk (Login)
     */
    public function login()
    {
        if (session()->get('is_logged_in')) {
            if (session()->get('user_role') === 'admin') {
                return redirect()->to(base_url('admin'));
            }
            return redirect()->to(base_url('/'));
        }

        if ($this->request->is('post')) {
            $rules = [
                'email' => [
                    'label' => 'Email',
                    'rules' => 'required|valid_email',
                    'errors' => [
                        'required'    => '{field} wajib diisi.',
                        'valid_email' => 'Format {field} tidak valid.',
                    ],
                ],
                'password' => [
                    'label' => 'Kata Sandi',
                    'rules' => 'required',
                    'errors' => [
                        'required' => '{field} wajib diisi.',
                    ],
                ],
            ];

            if (!$this->validate($rules)) {
                return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
            }

            $email    = strtolower(trim($this->request->getPost('email')));
            $password = (string) $this->request->getPost('password');

            $user = $this->userModel->where('email', $email)->first();

            if (!$user || !password_verify($password, $user['password'])) {
                return redirect()->back()->withInput()->with('error', 'Email atau kata sandi yang Anda masukkan salah.');
            }

            // Regenerasi session ID untuk mencegah session fixation
            session()->regenerate();

            // Set session login
            session()->set([
                'user_id'      => (int) $user['id'],
                'user_name'    => $user['name'],
                'user_email'   => $user['email'],
                'user_role'    => $user['role'],
                'is_logged_in' => true,
            ]);

            // Cek jika ada URL yang dituju sebelumnya
            $redirectUrl = session()->get('redirect_url');
            if (!empty($redirectUrl)) {
                session()->remove('redirect_url');
                return redirect()->to($redirectUrl)->with('success', 'Selamat datang kembali, ' . esc($user['name']) . '!');
            }

            if ($user['role'] === 'admin') {
                return redirect()->to(base_url('admin'))->with('success', 'Selamat datang di Panel Admin ToyTopia.');
            }

            return redirect()->to(base_url('/'))->with('success', 'Selamat datang kembali, ' . esc($user['name']) . '!');
        }

        $data = [
            'title' => 'Masuk ke Akun',
        ];

        return view('auth/login', $data);
    }

    /**
     * Proses Keluar (Logout)
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('masuk'))->with('success', 'Anda telah berhasil keluar dari sistem.');
    }
}

