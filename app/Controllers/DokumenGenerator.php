<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\TemplateProcessor;
use CodeIgniter\Files\File;

class DokumenGenerator extends BaseController
{
    /**
     * Generate dokumen usulan dalam format DOCX dan/atau PDF
     */
    public function generate($usulanId = null)
    {
        if (!$usulanId) {
            return $this->response->setJSON(['error' => 'ID usulan diperlukan']);
        }

        // Ambil data usulan + pemohon
        $usulanModel = new \App\Models\UsulanModel();
        $pemohonModel = new \App\Models\PemohonModel();
        $usulan = $usulanModel->find($usulanId);
        if (!$usulan) {
            return $this->response->setJSON(['error' => 'Usulan tidak ditemukan']);
        }
        $pemohon = $pemohonModel->find($usulan['pemohon_id']);

        // Data untuk placeholder
        $data = [
            'nama_lengkap'    => $pemohon['nama'],
            'nik'             => $pemohon['nik'],
            'alamat'          => $pemohon['alamat'],
            'alamat_lokasi'   => $usulan['alamat_lokasi'],
            'kelurahan'       => $usulan['kelurahan'],
            'koordinat'       => $usulan['koordinat_lat'] . ', ' . $usulan['koordinat_lng'],
            'luas_tanah'      => number_format($usulan['luas_tanah'], 2, ',', '.'),
            'luas_bangunan'   => number_format($usulan['luas_bangunan'], 2, ',', '.'),
        ];

        // Path template
        $templatePath = WRITEPATH . 'templates/surat_usulan_template.docx';
        if (!file_exists($templatePath)) {
            return $this->response->setJSON(['error' => 'Template dokumen tidak ditemukan']);
        }

        try {
            // Load template
            $template = new TemplateProcessor($templatePath);

            // Ganti placeholder {key} → value
            foreach ($data as $key => $value) {
                $template->setValue($key, $value ?? '-');
            }

            // Cari gambar untuk placeholder #tanda_tangan#
            $ttdPath = WRITEPATH . 'uploads/signatures/ttd_' . $usulanId . '.png';
            if (file_exists($ttdPath)) {
                $template->setImageValue('tanda_tangan', [
                    'path' => $ttdPath,
                    'width' => 150,
                    'height' => 80,
                ]);
            } else {
                // Jika tidak ada gambar, ganti dengan teks
                $template->setValue('tanda_tangan', '[Tanda Tangan]');
            }

            // Simpan hasil ke writable/outputs/
            $outputDir = WRITEPATH . 'outputs/';
            if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);

            $docxPath = $outputDir . 'surat_usulan_' . $usulanId . '.docx';
            $template->saveAs($docxPath);

            // ✅ Opsi: Konversi ke PDF via LibreOffice (jika tersedia)
            $pdfPath = null;
            if (shell_exec('which soffice')) {
                $command = "soffice --headless --convert-to pdf --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($docxPath);
                exec($command, $output, $returnVar);
                if ($returnVar === 0) {
                    $pdfPath = $outputDir . 'surat_usulan_' . $usulanId . '.pdf';
                }
            }

            // Kirim response
            $response = [
                'success' => true,
                'docx_url' => base_url('dokumen/download/' . basename($docxPath)),
            ];
            if ($pdfPath && file_exists($pdfPath)) {
                $response['pdf_url'] = base_url('dokumen/download/' . basename($pdfPath));
            }

            return $this->response->setJSON($response);

        } catch (\Exception $e) {
            log_message('error', 'DokumenGenerator error: ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Gagal membuat dokumen: ' . $e->getMessage()]);
        }
    }

    /**
     * Endpoint aman untuk download file dari writable/outputs/
     */
    public function download($filename = null)
    {
        if (!$filename || !preg_match('/^[a-zA-Z0-9_-]+\.(docx|pdf)$/', $filename)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        $filePath = WRITEPATH . 'outputs/' . $filename;
        if (!file_exists($filePath)) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException();
        }

        return $this->response->download($filePath, null, true);
    }

    public function generatortest($usulanId = null)
    {
        try {
            if (!$usulanId) {
                return $this->response->setJSON(['error' => 'ID usulan diperlukan.']);
            }

            // Ambil model
            $usulanModel   = new \App\Models\UsulanModel();
            $pemohonModel  = new \App\Models\PemohonModel();
            $dokumenModel  = new \App\Models\DokumenModel();

            // Ambil data usulan, pemohon, dokumen
            $usulan  = $usulanModel->find($usulanId);
            if (!$usulan) {
                return $this->response->setJSON(['error' => 'Data usulan tidak ditemukan.']);
            }
            $pemohon = $pemohonModel->find($usulan['pemohon_id'] ?? 0);
            $dokumen = $dokumenModel->findByUsulan($usulanId);

            // Path template
            $templatePath = FCPATH . 'template/krk_template.docx';
            if (!file_exists($templatePath)) {
                return $this->response->setJSON(['error' => 'Template dokumen tidak ditemukan.']);
            }

            // Instansiasi template processor (gunakan PhpOffice\PhpWord\TemplateProcessor)
            $template = new \PhpOffice\PhpWord\TemplateProcessor($templatePath);

            // Tulis isian template (ubah/isi sesuai field di template)
            $template->setValue('nomor_tiket', htmlspecialchars($usulan['nomor_tiket'] ?? ''));
            $template->setValue('nama_pemohon', htmlspecialchars($pemohon['nama'] ?? ''));
            $template->setValue('alamat_pemohon', htmlspecialchars($pemohon['alamat'] ?? ''));
            $template->setValue('telepon_pemohon', htmlspecialchars($pemohon['telepon'] ?? ''));
            $template->setValue('email_pemohon', htmlspecialchars($pemohon['email'] ?? ''));
            $template->setValue('jenis_pemohon', htmlspecialchars($pemohon['jenis_pemohon'] ?? ''));

            // Data usulan spesifik
            $template->setValue('alamat_lokasi', htmlspecialchars($usulan['alamat_lokasi'] ?? ''));
            $template->setValue('kecamatan', htmlspecialchars($usulan['kecamatan'] ?? ''));
            $template->setValue('kelurahan', htmlspecialchars($usulan['kelurahan'] ?? ''));
            $template->setValue('koordinat', htmlspecialchars($usulan['koordinat'] ?? ''));
            $template->setValue('luas_tanah', htmlspecialchars($usulan['luas_tanah'] ?? ''));
            $template->setValue('zona', htmlspecialchars($usulan['zona'] ?? ''));
            $template->setValue('jenis_bangunan', htmlspecialchars($usulan['jenis_bangunan'] ?? ''));
            $template->setValue('tinggi_bangunan', htmlspecialchars($usulan['tinggi_bangunan'] ?? ''));
            $template->setValue('luas_bangunan', htmlspecialchars($usulan['luas_bangunan'] ?? ''));
            $template->setValue('jumlah_lantai', htmlspecialchars($usulan['jumlah_lantai'] ?? ''));
            $template->setValue('kdb', htmlspecialchars($usulan['kdb'] ?? ''));
            $template->setValue('klb', htmlspecialchars($usulan['klb'] ?? ''));

            // Simpan sebagai .docx sementara
            $outputDir = WRITEPATH . 'outputs/';
            if (!is_dir($outputDir)) mkdir($outputDir, 0755, true);

            $docxPath = $outputDir . 'krk_usulan_' . $usulanId . '.docx';
            $template->saveAs($docxPath);

            // Konversi ke PDF lewat LibreOffice (tanpa tanda tangan, artinya langsung dari template)
            $pdfPath = null;
            if (shell_exec('which soffice')) {
                $command = "soffice --headless --convert-to pdf --outdir " . escapeshellarg($outputDir) . " " . escapeshellarg($docxPath);
                exec($command, $output, $retvar);
                if ($retvar === 0) {
                    $pdfPath = $outputDir . 'krk_usulan_' . $usulanId . '.pdf';
                }
            }

            // Kirim response (pdf saja, tidak ada ttd)
            $response = [
                'success' => true,
            ];
            if ($pdfPath && file_exists($pdfPath)) {
                $response['pdf_url'] = base_url('dokumen/download/' . basename($pdfPath));
            } else {
                $response['warn'] = 'File PDF gagal dibuat, pastikan server mendukung LibreOffice.';
            }

            return $this->response->setJSON($response);

        } catch (\Exception $e) {
            log_message('error', '[generatortest] ' . $e->getMessage());
            return $this->response->setJSON(['error' => 'Gagal generate: ' . $e->getMessage()]);
        }
    }
}