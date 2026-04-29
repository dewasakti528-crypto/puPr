<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PemohonModel;
use App\Models\UsulanModel;
use App\Models\DokumenModel;
use CodeIgniter\Files\File;

class Usulan extends BaseController
{
    protected $pemohonModel;
    protected $usulanModel;
    protected $dokumenModel;

    public function __construct()
    {
        helper(['form', 'url', 'encryption', 'telegram']);
        $this->pemohonModel = new PemohonModel();
        $this->usulanModel  = new UsulanModel();
        $this->dokumenModel = new DokumenModel();
    }

    /**
     * Menampilkan form usulan (langkah 1)
     */
    public function index()
    {
        return view('frontend/usulan/form');
    }

    /**
     * Menyimpan data usulan (AJAX atau form biasa)
     */
    public function save()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        // --- 1. VALIDASI DATA PEMOHON ---
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'           => 'required|min_length[3]',
            'nik'            => 'required|exact_length[16]|numeric',
            'alamat'         => 'required',
            'telepon'        => 'required|regex_match[/^(\+62|62|0)8[1-9][0-9]{6,9}$/]',
            'email'          => 'required|valid_email',
            'jenis_pemohon'  => 'required|in_list[perorangan,perusahaan,instansi,yayasan]',
            'alamat_lokasi'  => 'required',
            'kelurahan'      => 'required',
            'koordinat'      => 'required',
            'luas_tanah'     => 'required|greater_than[0]',
            'zona'           => 'required',
            'jenis_bangunan' => 'required',
            'tinggi_bangunan'=> 'required|greater_than[0]',
            'luas_bangunan'  => 'required|greater_than[0]',
            'jumlah_lantai'  => 'required|greater_than[0]',
            'kdb'            => 'permit_empty|numeric',
            'klb'            => 'permit_empty|numeric',
            'pernyataan'     => 'required',
            // File validation
            // 'sertifikat'     => 'uploaded[sertifikat]|max_size[sertifikat,5120]|mime_in[sertifikat,image/jpeg,image/png,application/pdf]',
            // 'ktp'            => 'uploaded[ktp]|max_size[ktp,5120]|mime_in[ktp,image/jpeg,image/png]',
            // 'gambar'         => 'uploaded[gambar]|max_size[gambar,5120]|mime_in[gambar,image/jpeg,image/png,application/pdf]',
            // 'lainnya'        => 'max_size[lainnya,5120]|mime_in[lainnya,image/jpeg,image/png,application/pdf]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => $validation->getErrors()
            ]);
        }

        // --- 2. SIMPAN DATA PEMOHON ---
        $db = \Config\Database::connect();

        $pemohonData = [
            'nama'           => $this->request->getPost('nama'),
            'nik'            => $this->request->getPost('nik'),
            'alamat'         => $this->request->getPost('alamat'),
            'no_hp'          => $this->request->getPost('telepon'),
            'email'          => $this->request->getPost('email'),
            'jenis_pemohon'  => $this->request->getPost('jenis_pemohon'),
        ];

        // return $this->response->setJSON($pemohonData);

        try {
            $pemohonId = $this->pemohonModel->insert($pemohonData);
            if (!$pemohonId) {
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal menyimpan data pemohon.',
                    'debug' => $this->pemohonModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            log_message('error', 'Error saving pemohon: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menyimpan data pemohon.',
                'debug' => $e->getMessage()
            ]);
        }

        // --- 3. PARSING KOORDINAT ---
        $koordinat = explode(',', $this->request->getPost('koordinat'));
        $lat = trim($koordinat[0] ?? null);
        $lng = trim($koordinat[1] ?? null);

        // --- 4. SIMPAN DATA USULAN ---
        $nomorTiket = $this->usulanModel->generateNomorTiket();

        $usulanData = [
            'pemohon_id'       => $pemohonId,
            'alamat_lokasi'    => $this->request->getPost('alamat_lokasi'),
            'kelurahan'        => $this->request->getPost('kelurahan'),
            'kecamatan'        => $this->request->getPost('kecamatan'),
            'koordinat_lat'    => is_numeric($lat) ? (float)$lat : null,
            'koordinat_lng'    => is_numeric($lng) ? (float)$lng : null,
            'luas_tanah'       => (float)$this->request->getPost('luas_tanah'),
            'zona_rtrw'        => $this->request->getPost('zona'),
            'kdb'              => $this->request->getPost('kdb') ?: null,
            'klb'              => $this->request->getPost('klb') ?: null,
            'jenis_bangunan'   => $this->request->getPost('jenis_bangunan'),
            'tinggi_bangunan'  => (float)$this->request->getPost('tinggi_bangunan'),
            'luas_bangunan'    => (float)$this->request->getPost('luas_bangunan'),
            'jumlah_lantai'    => (int)$this->request->getPost('jumlah_lantai'),
            'status'           => 'submitted',
            'nomor_tiket'      => $nomorTiket,
            'submitted_at'     => date('Y-m-d H:i:s'),
        ];

        try {
            $usulanId = $this->usulanModel->insert($usulanData);
            if (!$usulanId) {
                // Hapus pemohon jika gagal simpan usulan
                $this->pemohonModel->delete($pemohonId);
                return $this->response->setJSON([
                    'success' => false, 
                    'message' => 'Gagal menyimpan data usulan.',
                    'debug' => $this->usulanModel->errors()
                ]);
            }
        } catch (\Exception $e) {
            // Hapus pemohon jika gagal simpan usulan
            log_message('error', 'Error saving usulan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Terjadi kesalahan saat menyimpan data usulan.',
                'debug' => $e->getMessage()
            ]);
        }

        // return $this->response->setJSON($usulanData);

        // --- 5. UPLOAD DOKUMEN ---
        $uploadPath = WRITEPATH . 'uploads/dokumen/' . $usulanId;
        if (!is_dir($uploadPath)) {
            if (!mkdir($uploadPath, 0755, true)) {
                log_message('error', 'Failed to create upload directory: ' . $uploadPath);
            }
        }

        // Analisa dan perbaikan: Jika file tidak diinput ke database, ada beberapa kemungkinan kesalahan:
        // 1. Form pengiriman file tidak benar (name input tidak cocok dengan daftar $dokumenTypes)
        // 2. $this->request->getFile($type) hanya akan mengembalikan file jika benar-benar ada di request. Jika tidak, proses upload dan insert ke database tidak terjadi.
        // 3. Penulisan kode yang me-return data $usulanData sebelum proses upload file selesai (seharusnya return setelah inserting dokumen selesai).
        // 4. Cek error pada insert mungkin diperlukan.

        $dokumenTypes = ['sertifikat', 'ktp', 'gambar', 'lainnya'];
        $uploadedFiles = [];
        $dokumenErrors = [];

        foreach ($dokumenTypes as $type) {
            $file = $this->request->getFile($type);

            // Cek: file harus ada dan terupload, dan bukan dummy uploaded file kosong
            if ($file && $file->isValid() && !$file->hasMoved()) {
                // Validasi ukuran file (maks 5MB)
                if ($file->getSize() > 5 * 1024 * 1024) {
                    $dokumenErrors[$type] = "File {$type} terlalu besar: {$file->getSize()} bytes";
                    log_message('error', $dokumenErrors[$type]);
                    continue;
                }

                // Validasi tipe file
                $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
                if (!in_array($file->getMimeType(), $allowedTypes)) {
                    $dokumenErrors[$type] = "Tipe file {$type} tidak diizinkan: {$file->getMimeType()}";
                    log_message('error', $dokumenErrors[$type]);
                    continue;
                }

                $newName = $file->getRandomName();
                if ($file->move($uploadPath, $newName)) {
                    $insertDoc = [
                        'usulan_id'     => $usulanId,
                        'tipe_dokumen'  => $type,
                        'filename'      => $newName,
                        'original_name' => $file->getClientName(),
                        'mime_type'     => "",
                        'file_size'     => $file->getSize(),
                    ];

                    // Insert ke DB dan cek jika gagal
                    if ($this->dokumenModel->insert($insertDoc)) {
                        $uploadedFiles[] = $type;
                    } else {
                        $dokumenErrors[$type] = "Gagal insert dokumen ke DB: " . json_encode($this->dokumenModel->errors());
                        log_message('error', $dokumenErrors[$type]);
                    }
                } else {
                    $dokumenErrors[$type] = "Gagal memindahkan file {$type}";
                    log_message('error', $dokumenErrors[$type]);
                }
            }
        }

        // Cek jika ada error dokumen, infokan ke frontend/debug
        if (!empty($dokumenErrors)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Beberapa dokumen gagal diupload/disimpan.',
                'errors' => $dokumenErrors,
            ]);
        }

        // Sukses upload dokumen (atau tidak ada dokumen diupload), lanjut
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data usulan dan dokumen berhasil disimpan.',
            'usulan' => $usulanData,
            'uploaded_files' => $uploadedFiles,
            'nomor_tiket' => $nomorTiket
        ]);

        // return $this->response->setJSON($uploadedFiles);

        // // --- 6. NOTIFIKASI TELEGRAM ---
        // $usulan = $this->usulanModel->withPemohon($this->usulanModel->find($usulanId));
        // $message = "<b>🆕 Usulan Baru Diajukan!</b>\n\n";
        // $message .= "<b>Nomor Tiket:</b> {$usulan['nomor_tiket']}\n";
        // $message .= "<b>Pemohon:</b> {$usulan['nama_pemohon']}\n";
        // $message .= "<b>Jenis Bangunan:</b> {$usulan['jenis_bangunan']}\n";
        // $message .= "<b>Luas Tanah:</b> {$usulan['luas_tanah']} m²\n";
        // $message .= "<b>Luas Bangunan:</b> {$usulan['luas_bangunan']} m²\n";
        // $message .= "<b>Lokasi:</b> {$usulan['kelurahan']}, {$usulan['kecamatan']}\n";
        // $message .= "<b>Status:</b> <i>Menunggu Verifikasi</i>\n";
        // $message .= "\n<a href='" . base_url("admin/usulan/detail/{$usulanId}") . "'>Lihat Detail</a>";

        // if (function_exists('send_telegram_message')) {
        //     send_telegram_message($message);
        // }

        // // --- 7. RESPON SUKSES ---
        // $db->transCommit();
        // $url = base_url("") . "usulan/sukses/" . $nomorTiket;

        // $success_data = [
        //     'success' => true,
        //     'nomor_tiket' => $nomorTiket
        // ];
        // return $this->response->setJSON($success_data);
    }

    public function savetest()
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false, 
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        // --- 1. VALIDASI DATA PEMOHON ---
        $validation = \Config\Services::validation();
        $validation->setRules([
            'nama'           => 'required|min_length[3]',
            'nik'            => 'required|exact_length[16]|numeric',
            'jenis_pemohon'  => 'required|in_list[perorangan,badan_hukum]',
            'alamat'         => 'required|min_length[5]',
            'telepon'          => 'required|min_length[10]',
            'email'          => 'required|valid_email',
        ]);

        $validation->setRules([
            'jenis_bangunan' => 'required',
            'alamat_tanah'   => 'required',
            'luas_tanah'     => 'required|numeric',
            'luas_bangunan'  => 'required|numeric',
            'kelurahan'      => 'required',
            'kecamatan'      => 'required',
            'zona'           => 'required'
        ]);

        $data = [
            'pemohon' => [
                'nama'          => $this->request->getPost('nama'),
                'nik'           => $this->request->getPost('nik'),
                'jenis_pemohon' => $this->request->getPost('jenis_pemohon'),
                'alamat'        => $this->request->getPost('alamat'),
                'telepon'         => $this->request->getPost('telepon'),
                'email'         => $this->request->getPost('email'),
            ],
            'usulan' => [
                'jenis_bangunan'=> $this->request->getPost('jenis_bangunan'),
                'alamat_tanah'  => $this->request->getPost('alamat_tanah'),
                'luas_tanah'    => $this->request->getPost('luas_tanah'),
                'luas_bangunan' => $this->request->getPost('luas_bangunan'),
                'kelurahan'     => $this->request->getPost('kelurahan'),
                'kecamatan'     => $this->request->getPost('kecamatan'),
                'zona'          => $this->request->getPost('zona'),
                'catatan'       => $this->request->getPost('catatan'),
            ],
        ];

        // Validasi ekstra manual untuk file dokumen
        $dokumenTypes = ['sertifikat', 'ktp', 'gambar', 'lainnya'];

        $uploadedFilesStatus = [];
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        foreach ($dokumenTypes as $type) {
            $file = $this->request->getFile($type);
            if ($file && $file->isValid() && $file->getSize() > 0) {
                $mimeType = $file->getMimeType();
                if (in_array($mimeType, $allowedTypes)) {
                    $uploadedFilesStatus[$type] = [
                        'status'         => true,
                        'message'        => 'Valid',
                        'file_name'      => $file->getClientName(),
                        'mime_type'      => $mimeType,
                        'size'           => $file->getSize()
                    ];
                } else {
                    $uploadedFilesStatus[$type] = [
                        'status'  => false,
                        'message' => 'Jenis file tidak diperbolehkan (' . $mimeType . ')'
                    ];
                }
            } else {
                $uploadedFilesStatus[$type] = [
                    'status'  => false,
                    'message' => 'File tidak terupload/invalid'
                ];
            }
        }

        // Jalankan validasi form
        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors'  => $validation->getErrors(),
                'dokumen' => $uploadedFilesStatus,
                'input'   => $data, // tetap balikin input
            ]);
        }

        // Jika lolos semua
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Data valid & dokumen terdeteksi',
            'input'   => $data,
            'dokumen' => $uploadedFilesStatus,
        ]);
    }

    /**
     * Halaman sukses setelah submit
     */
    public function sukses($nomorTiket = null)
    {
        if (!$nomorTiket) {
            return redirect()->to('/usulan');
        }

        // Opsional: validasi apakah tiket benar-benar ada
        $usulan = $this->usulanModel->where('nomor_tiket', $nomorTiket)->first();
        if (!$usulan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Nomor tiket tidak ditemukan.');
        }

        return view('usulan/sukses', ['nomor_tiket' => $nomorTiket]);
    }

    /**
     * Download dokumen
     */
    public function download($filename = null)
    {

        // Ambil data dokumen dari database berdasarkan filename
        $dokumen = $this->dokumenModel->findByFilename($filename);
        if (!$dokumen) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan di database.');
        }
        if (!$filename) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        $filePath = WRITEPATH . 'uploads/dokumen/' .$dokumen['usulan_id'] . '/' . basename($filename);
        if (!file_exists($filePath)) {
            return $this->response->setStatusCode(404)->setBody('File tidak ditemukan.');
        }

        // Jika file ditemukan, lakukan download
        return $this->response->download($filePath, null);
    }

    /**
     * Menampilkan daftar usulan untuk admin
     */
    public function manage()
    {
        $status = $this->request->getGet('status');
        $zona = $this->request->getGet('zona');
        $kelurahan = $this->request->getGet('kelurahan');
        $page = $this->request->getGet('page') ?? 1;

        // Build query
        $query = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.nik as nik, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.email as email_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id', 'left');

        // Apply filters
        if ($status && in_array($status, ['submitted', 'approved', 'rejected'])) {
            $query->where('usulan.status', $status);
        }

        if ($zona) {
            $query->like('usulan.zona_rtrw', $zona);
        }

        if ($kelurahan) {
            $query->like('usulan.kelurahan', $kelurahan);
        }

        // Get data dengan pagination
        $usulan = $query->orderBy('usulan.created_at', 'DESC')
            ->paginate(10, 'default', $page);

        // Fetch dokumen for each usulan
        foreach ($usulan as &$item) {
            $item['dokumen'] = $this->dokumenModel->findByUsulan($item['id']);
        }
        unset($item); // Break reference

        // Get statistics
        $stats = [
            'total' => $this->usulanModel->countAll(),
            'submitted' => $this->usulanModel->where('status', 'submitted')->countAllResults(),
            'approved' => $this->usulanModel->where('status', 'approved')->countAllResults(),
            'rejected' => $this->usulanModel->where('status', 'rejected')->countAllResults(),
        ];

        // Get pager object
        $pager = $this->usulanModel->pager;

        $data = [
            'page_title' => 'Manajemen Usulan - SATRIA',
            'page_header' => 'Manajemen Usulan KRK',
            'usulan' => $usulan,
            'usulanData' => $usulan, // Add explicit usulanData for JavaScript
            'stats' => $stats,
            'current_filter' => [
                'status' => $status,
                'zona' => $zona,
                'kelurahan' => $kelurahan
            ],
            'current_page' => $page,
            'total_pages' => $pager->getPageCount(),
            'per_page' => 10,
            'page' => 'manage-usulan',
            'pager' => $pager
        ];

        return view('backend/usulan/index', $data);
    }

    /**
     * Menampilkan detail usulan
     */
    public function detail($id = null)
    {
        if (!$id) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usulan tidak ditemukan.');
        }

        $usulan = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.email as email_pemohon, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.nik as nik_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id')
            ->find($id);

        if (!$usulan) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Usulan tidak ditemukan.');
        }

        // Get dokumen
        $dokumen = $this->dokumenModel->findByUsulan($id);

        $data = [
            'page_title' => 'Detail Usulan - SATRIA',
            'page_header' => 'Detail Usulan KRK',
            'usulan' => $usulan,
            'pemohon' => [
                'nama' => $usulan['nama_pemohon'],
                'nik' => $usulan['nik_pemohon'],
                'alamat' => $usulan['alamat_pemohon'],
                'no_hp' => $usulan['no_hp_pemohon'],
                'email' => $usulan['email_pemohon'],
                'jenis_pemohon' => $usulan['jenis_pemohon_pemohon']
            ],
            'dokumen' => $dokumen
        ];

        return view('backend/usulan/detail', $data);
    }

    /**
     * Approve usulan
     */
    public function approve($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usulan tidak ditemukan.'
            ]);
        }

        try {
            // Update status
            $this->usulanModel->update($id, [
                'status' => 'approved',
                'verified_at' => date('Y-m-d H:i:s')
            ]);

            // Kirim notifikasi Telegram
            $this->sendTelegramNotification($usulan, 'approved');

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Usulan berhasil disetujui.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error approving usulan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyetujui usulan.'
            ]);
        }
    }

    /**
     * Reject usulan
     */
    public function reject($id = null)
    {
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Metode tidak diizinkan.'
            ]);
        }

        $catatan = $this->request->getPost('catatan');
        if (empty($catatan)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Catatan penolakan wajib diisi.'
            ]);
        }

        $usulan = $this->usulanModel->find($id);
        if (!$usulan) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Usulan tidak ditemukan.'
            ]);
        }

        try {
            // Update status
            $this->usulanModel->update($id, [
                'status' => 'rejected',
                'catatan_verifikasi' => $catatan,
                'verified_at' => date('Y-m-d H:i:s')
            ]);

            // Kirim notifikasi Telegram
            $this->sendTelegramNotification($usulan, 'rejected', $catatan);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Usulan berhasil ditolak.'
            ]);
        } catch (\Exception $e) {
            log_message('error', 'Error rejecting usulan: ' . $e->getMessage());
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menolak usulan.'
            ]);
        }
    }

    /**
     * Get usulan data untuk AJAX
     */
    public function getUsulanData()
    {
        $status = $this->request->getGet('status');
        $zona = $this->request->getGet('zona');
        $kelurahan = $this->request->getGet('kelurahan');
        $page = $this->request->getGet('page') ?? 1;

        // Build query
        $query = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.nik as nik, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.email as email_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id', 'left');

        // Apply filters
        if ($status && in_array($status, ['submitted', 'approved', 'rejected'])) {
            $query->where('usulan.status', $status);
        }

        if ($zona) {
            $query->like('usulan.zona_rtrw', $zona);
        }

        if ($kelurahan) {
            $query->like('usulan.kelurahan', $kelurahan);
        }

        // Get data dengan pagination
        $usulan = $query->orderBy('usulan.created_at', 'DESC')
            ->paginate(10, 'default', $page);

        // Get pager object
        $pager = $this->usulanModel->pager;

        return $this->response->setJSON([
            'data' => $usulan,
            'pagination' => [
                'currentPage' => $pager->getCurrentPage(),
                'totalPages' => $pager->getPageCount(),
                'perPage' => $pager->getPerPage(),
                'total' => $pager->getTotal()
            ]
        ]);
    }

    /**
     * Kirim notifikasi Telegram
     */
    private function sendTelegramNotification($usulan, $action, $catatan = '')
    {
        $statusText = [
            'approved' => 'DISETUJUI',
            'rejected' => 'DITOLAK'
        ];

        // Get complete usulan data with pemohon
        $completeUsulan = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id')
            ->find($usulan['id']);

        if (!$completeUsulan) {
            log_message('error', 'Failed to get usulan data for Telegram notification');
            return;
        }

        $message = "<b>🔄 Status Usulan Diperbarui!</b>\n\n";
        $message .= "<b>Nomor Tiket:</b> {$completeUsulan['nomor_tiket']}\n";
        $message .= "<b>Pemohon:</b> {$completeUsulan['nama_pemohon']}\n";
        $message .= "<b>Status:</b> <i>{$statusText[$action]}</i>\n";

        if ($action === 'rejected' && !empty($catatan)) {
            $message .= "\n<b>Catatan:</b> {$catatan}";
        }

        $message .= "\n\n<a href='" . base_url("admin/usulan/detail/{$completeUsulan['id']}") . "'>Lihat Detail</a>";

        if (function_exists('send_telegram_message')) {
            send_telegram_message($message);
        }
    }

    /**
     * Get usulan data for AJAX requests
     * Returns complete data structure for JavaScript consumption
     */
    public function getdata()
    {
        $status = $this->request->getGet('status');
        $zona = $this->request->getGet('zona');
        $kelurahan = $this->request->getGet('kelurahan');
        $page = $this->request->getGet('page') ?? 1;

        // Build query
        $query = $this->usulanModel
            ->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.nik as nik, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.email as email_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id', 'left');

        // Apply filters
        if ($status && in_array($status, ['submitted', 'approved', 'rejected'])) {
            $query->where('usulan.status', $status);
        }

        if ($zona) {
            $query->like('usulan.zona_rtrw', $zona);
        }

        if ($kelurahan) {
            $query->like('usulan.kelurahan', $kelurahan);
        }

        // Get data dengan pagination
        $usulan = $query->orderBy('usulan.created_at', 'DESC')
            ->paginate(10, 'default', $page);

        // Fetch dokumen for each usulan
        foreach ($usulan as &$item) {
            $item['dokumen'] = $this->dokumenModel->findByUsulan($item['id']);
        }
        unset($item); // Break reference

        // Get pager object
        $pager = $this->usulanModel->pager;

        // Return comprehensive data structure
        return $this->response->setJSON([
            'success' => true,
            'data' => [
                'usulanData' => $usulan,
                'currentPage' => (int)$page,
                'currentFilter' => $status ?? 'all',
                'currentZona' => $zona ?? '',
                'currentKelurahan' => $kelurahan ?? '',
                'baseUrl' => base_url(),
                'totalPages' => $pager->getPageCount(),
                'perPage' => 10,
                'total' => $pager->getTotal()
            ]
        ]);
    }
}