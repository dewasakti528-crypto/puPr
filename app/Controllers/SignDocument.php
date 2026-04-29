<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class SignDocument extends BaseController
{
    /**
     * Menampilkan form upload tanda tangan (opsional, bisa di dashboard)
     */
    public function index()
    {
        return view('admin/sign_document');
    }

    /**
     * Menangani upload tanda tangan
     */
    public function upload()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        $usulanId = $this->request->getPost('usulan_id');
        if (!$usulanId || !is_numeric($usulanId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'ID usulan tidak valid.'
            ]);
        }

        $file = $this->request->getFile('signature');
        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'File tanda tangan tidak valid atau tidak ditemukan.'
            ]);
        }

        // Validasi tipe file
        $allowedTypes = ['image/png', 'image/jpeg', 'image/jpg'];
        if (!in_array($file->getMimeType(), $allowedTypes)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Hanya file PNG atau JPG yang diizinkan.'
            ]);
        }

        // Validasi ukuran (maks 2 MB)
        if ($file->getSize() > 2 * 1024 * 1024) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Ukuran file maksimal 2 MB.'
            ]);
        }

        // Buat folder jika belum ada
        $uploadPath = WRITEPATH . 'uploads/signatures/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Nama file: ttd_{usulan_id}.png
        $newName = "ttd_{$usulanId}.png"; // selalu simpan sebagai PNG untuk transparansi

        // Hapus file lama jika ada
        if (file_exists($uploadPath . $newName)) {
            unlink($uploadPath . $newName);
        }

        // Pindahkan & konversi ke PNG (opsional, tapi disarankan)
        if ($file->getMimeType() !== 'image/png') {
            // Konversi ke PNG menggunakan GD (jika tersedia)
            $image = null;
            if ($file->getMimeType() === 'image/jpeg') {
                $image = imagecreatefromjpeg($file->getTempName());
            }
            if ($image) {
                imagepng($image, $uploadPath . $newName);
                imagedestroy($image);
            } else {
                // Jika gagal konversi, tetap simpan asli (fallback)
                $file->move($uploadPath, $newName);
            }
        } else {
            $file->move($uploadPath, $newName);
        }

        return $this->response->setJSON([
            'success' => true,
            'message' => 'Tanda tangan berhasil diunggah.',
            'file_url' => base_url('admin/signature/preview/' . $usulanId)
        ]);
    }

    /**
     * Preview tanda tangan (akses aman via route)
     */
    public function preview($usulanId = null)
    {
        if (!is_numeric($usulanId)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $filePath = WRITEPATH . "uploads/signatures/ttd_{$usulanId}.png";
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('Tanda tangan tidak ditemukan.');
        }

        // Kirim sebagai gambar
        return $this->response
            ->setContentType('image/png')
            ->setBody(file_get_contents($filePath));
    }
}