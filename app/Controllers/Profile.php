<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profile extends BaseController
{
    protected UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    /**
     * Tampilan Profil Pengguna
     */
    public function index()
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to(base_url('keluar'));
        }

        $data = [
            'title' => 'Profil Saya',
            'user'  => $user,
        ];

        return view('profile/index', $data);
    }

    /**
     * Update Biodata & Alamat Pengguna
     */
    public function update()
    {
        $userId = session()->get('user_id');

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
            'phone' => [
                'label' => 'Nomor Telepon',
                'rules' => 'permit_empty|numeric|min_length[10]|max_length[15]',
                'errors' => [
                    'numeric'    => '{field} hanya boleh berisi angka.',
                    'min_length' => '{field} minimal 10 digit.',
                    'max_length' => '{field} maksimal 15 digit.',
                ],
            ],
            'address' => [
                'label' => 'Alamat Pengiriman',
                'rules' => 'permit_empty',
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'    => $this->request->getPost('name'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
        ];

        $this->userModel->update($userId, $updateData);

        // Perbarui nama di sesi
        session()->set('user_name', $updateData['name']);

        return redirect()->to(base_url('profil'))->with('success', 'Data profil Anda berhasil diperbarui.');
    }

    /**
     * Ganti Kata Sandi
     */
    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user   = $this->userModel->find($userId);

        $rules = [
            'current_password' => [
                'label' => 'Kata Sandi Saat Ini',
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                ],
            ],
            'new_password' => [
                'label' => 'Kata Sandi Baru',
                'rules' => 'required|min_length[8]',
                'errors' => [
                    'required'   => '{field} wajib diisi.',
                    'min_length' => '{field} minimal 8 karakter.',
                ],
            ],
            'new_password_confirm' => [
                'label' => 'Konfirmasi Kata Sandi Baru',
                'rules' => 'required|matches[new_password]',
                'errors' => [
                    'required' => '{field} wajib diisi.',
                    'matches'  => '{field} tidak cocok dengan kata sandi baru.',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $currentPassword = (string) $this->request->getPost('current_password');

        if (!password_verify($currentPassword, $user['password'])) {
            return redirect()->back()->with('error', 'Kata sandi saat ini yang Anda masukkan salah.');
        }

        $this->userModel->update($userId, [
            'password' => password_hash($this->request->getPost('new_password'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to(base_url('profil'))->with('success', 'Kata sandi berhasil diganti.');
    }
}

