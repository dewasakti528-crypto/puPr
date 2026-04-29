<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsulanModel;
use App\Models\PemohonModel;
use App\Models\DokumenModel;

class ManageUsulanController extends BaseController
{
    protected $usulanModel;
    protected $pemohonModel;
    protected $dokumenModel;

    public function __construct()
    {
        helper(['url', 'telegram']);
        $this->usulanModel   = new UsulanModel();
        $this->pemohonModel  = new PemohonModel();
        $this->dokumenModel  = new DokumenModel();
    }

    /**
     * Menampilkan daftar usulan (web view)
     */
    public function index()
    {
        $status = $this->request->getGet('status');
        $query = $this->usulanModel->orderBy('created_at', 'DESC');
        if ($status && in_array($status, ['draft', 'submitted', 'approved', 'rejected'])) {
            $query = $query->where('status', $status);
        }
        $data = [
            'usulan' => $query->paginate(10),
            'pager'  => $this->usulanModel->pager,
            'status_filter' => $status
        ];
        return view('admin/manage_usulan', $data);
    }

    /**
     * Menampilkan detail usulan (web view)
     */
    public function show($id = null)
    {
        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usulan tidak ditemukan.');
        }

        $usulan['pemohon'] = $this->pemohonModel->find($usulan['pemohon_id']);
        $usulan['dokumen'] = $this->dokumenModel->findByUsulan($id);

        return view('admin/usulan_detail', $usulan);
    }

    /**
     * Mengembalikan data usulan dalam format JSON (API)
     */
    public function getJson($id = null)
    {
        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Usulan tidak ditemukan.']);
        }

        $usulan['pemohon'] = $this->pemohonModel->find($usulan['pemohon_id']);
        $usulan['dokumen'] = $this->dokumenModel->findByUsulan($id);

        // Jangan kirim path file sensitif
        foreach ($usulan['dokumen'] as &$doc) {
            unset($doc['filename']);
        }

        return $this->response->setJSON($usulan);
    }

    /**
     * Approve usulan
     */
    public function approve($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Metode tidak diizinkan.']);
        }

        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usulan tidak ditemukan.']);
        }

        if ($this->usulanModel->update($id, [
            'status' => 'approved',
            'verified_at' => date('Y-m-d H:i:s')
        ])) {
            // Notifikasi Telegram
            $usulan = $this->usulanModel->withPemohon($this->usulanModel->find($id));
            $message = "✅ Usulan <b>{$usulan['nomor_tiket']}</b> telah <b>DISETUJUI</b> oleh admin.";
            if (function_exists('send_telegram_message')) {
                send_telegram_message($message);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Usulan berhasil disetujui.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status.']);
    }

    /**
     * Reject usulan
     */
    public function reject($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON(['success' => false, 'message' => 'Metode tidak diizinkan.']);
        }

        $catatan = $this->request->getPost('catatan');
        if (empty($catatan)) {
            return $this->response->setJSON(['success' => false, 'message' => 'Catatan penolakan wajib diisi.']);
        }

        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            return $this->response->setJSON(['success' => false, 'message' => 'Usulan tidak ditemukan.']);
        }

        if ($this->usulanModel->update($id, [
            'status' => 'rejected',
            'catatan_verifikasi' => $catatan,
            'verified_at' => date('Y-m-d H:i:s')
        ])) {
            // Notifikasi Telegram
            $usulan = $this->usulanModel->withPemohon($this->usulanModel->find($id));
            $message = "❌ Usulan <b>{$usulan['nomor_tiket']}</b> <b>DITOLAK</b>.\nCatatan: {$catatan}";
            if (function_exists('send_telegram_message')) {
                send_telegram_message($message);
            }

            return $this->response->setJSON(['success' => true, 'message' => 'Usulan berhasil ditolak.']);
        }

        return $this->response->setJSON(['success' => false, 'message' => 'Gagal memperbarui status.']);
    }
}