<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsulanModel;
use App\Models\PemohonModel;

class Tracking extends BaseController
{
    protected $usulanModel;
    protected $pemohonModel;

    public function __construct()
    {
        $this->usulanModel   = new UsulanModel();
        $this->pemohonModel  = new PemohonModel();
    }

    /**
     * Menampilkan halaman form input nomor tiket
     */
    public function index()
    {
        $data = [
            'page' => "tiket"
        ];
        return view('frontend/tiket/index', $data);
    }

    /**
     * API: Cari usulan berdasarkan nomor tiket
     */
    public function lookup()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        $nomorTiket = trim($this->request->getPost('nomor_tiket'));
        if (!$nomorTiket) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nomor tiket tidak boleh kosong.'
            ]);
        }

        // Cari usulan berdasarkan nomor tiket
        $usulan = $this->usulanModel->where('nomor_tiket', $nomorTiket)->first();

        // Jika tidak ditemukan
        if (!$usulan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Nomor tiket tidak ditemukan. Pastikan formatnya benar (contoh: KRK-2025-0001).'
            ]);
        }

        // Ambil data pemohon
        $pemohon = $this->pemohonModel->find($usulan['pemohon_id']);

        // Compose response sesuai data mockData di tiket.js (baris 84-107), namun ambil dari database asalkan ada
        $response = [
            'success' => true,
            'data' => [
                'pemohon_id'         => $usulan['pemohon_id'] ?? null,
                'alamat_lokasi'      => $usulan['alamat_lokasi'] ?? null,
                'kelurahan'          => $usulan['kelurahan'] ?? null,
                'kecamatan'          => $usulan['kecamatan'] ?? null,
                'koordinat_lat'      => $usulan['koordinat_lat'] ?? null,
                'koordinat_lng'      => $usulan['koordinat_lng'] ?? null,
                'luas_tanah'         => isset($usulan['luas_tanah']) ? (string) $usulan['luas_tanah'] : null,
                'zona_rtrw'          => $usulan['zona_rtrw'] ?? null,
                'kdb'                => $usulan['kdb'] ?? null,
                'klb'                => $usulan['klb'] ?? null,
                'jenis_bangunan'     => $usulan['jenis_bangunan'] ?? null,
                'tinggi_bangunan'    => isset($usulan['tinggi_bangunan']) ? (string) $usulan['tinggi_bangunan'] : null,
                'luas_bangunan'      => isset($usulan['luas_bangunan']) ? (string) $usulan['luas_bangunan'] : null,
                'jumlah_lantai'      => isset($usulan['jumlah_lantai']) ? (string) $usulan['jumlah_lantai'] : null,
                'status'             => $usulan['status'] ?? null,
                'catatan_verifikasi' => $usulan['catatan_verifikasi'] ?? null,
                'nomor_tiket'        => $usulan['nomor_tiket'] ?? $nomorTiket,
                'submitted_at'       => isset($usulan['submitted_at']) && $usulan['submitted_at'] ? date('d M Y', strtotime($usulan['submitted_at'])) : null,
                'verified_at'        => isset($usulan['verified_at']) && $usulan['verified_at'] ? date('d M Y', strtotime($usulan['verified_at'])) : null,
                'created_at'         => isset($usulan['created_at']) ? date('d M Y H:i', strtotime($usulan['created_at'])) : null,
                'updated_at'         => isset($usulan['updated_at']) ? date('d M Y H:i', strtotime($usulan['updated_at'])) : null,
            ]
        ];

        return $this->response->setJSON($response);
    }
}