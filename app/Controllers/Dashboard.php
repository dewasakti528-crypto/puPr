<?php 

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UsulanModel;
use App\Models\PemohonModel;

class Dashboard extends BaseController
{
    protected $usulanModel;
    protected $pemohonModel;

    public function __construct()
    {
        $this->usulanModel = new UsulanModel();
        $this->pemohonModel = new PemohonModel();
    }

    /**
     * Menampilkan dashboard admin
     */
    public function index()
    {
        // Get statistics
        $stats = [
            'total' => $this->usulanModel->countAll(),
            'approved' => $this->usulanModel->where('status', 'approved')->countAllResults(),
            'pending' => $this->usulanModel->where('status', 'submitted')->countAllResults(),
            'rejected' => $this->usulanModel->where('status', 'rejected')->countAllResults(),
        ];

        // Get recent submissions with pemohon data
        $recentUsulan = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id')
            ->orderBy('usulan.created_at', 'DESC')
            ->limit(5)
            ->find();

        $data = [
            'page' => 'dashboard',
            'page_title' => 'Dashboard - SATRIA',
            'page_header' => 'Dashboard Overview',
            'stats' => $stats,
            'recent_usulan' => $recentUsulan
        ];

        return view('backend/dashboard/index', $data);
    }
}
