<?php

namespace App\Models;

use CodeIgniter\Model;

class UsulanModel extends Model
{
    protected $table            = 'usulan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = [
        'pemohon_id', 'alamat_lokasi', 'kelurahan', 'kecamatan',
        'koordinat_lat', 'koordinat_lng', 'luas_tanah', 'zona_rtrw',
        'kdb', 'klb', 'jenis_bangunan', 'tinggi_bangunan',
        'luas_bangunan', 'jumlah_lantai', 'status',
        'catatan_verifikasi', 'nomor_tiket', 'submitted_at', 'verified_at','created_at','updated_at'
    ];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';
    protected $updatedField     = 'updated_at';

    // Generate nomor tiket unik: KRK-YYYY-0001
    public function generateNomorTiket(): string
    {
        $year = date('Y');
        $last = $this->select('nomor_tiket')
                     ->like('nomor_tiket', "KRK-{$year}-", 'after')
                     ->orderBy('id', 'DESC')
                     ->first();

        $lastNumber = 0;
        if ($last) {
            $parts = explode('-', $last['nomor_tiket']);
            $lastNumber = (int) end($parts);
        }

        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        return "KRK-{$year}-{$newNumber}";
    }

    // Relasi: dapatkan pemohon dari usulan
    public function withPemohon(array $usulan): array
    {
        $pemohonModel = new PemohonModel();
        $pemohon = $pemohonModel->find($usulan['pemohon_id']);
        if ($pemohon) {
            $usulan['pemohon'] = $pemohon;
            $usulan['nama_pemohon'] = $pemohon['nama'];
            $usulan['nik'] = $pemohon['nik'];
            $usulan['alamat'] = $pemohon['alamat'];
            $usulan['no_hp'] = $pemohon['no_hp'];
            $usulan['email'] = $pemohon['email'];
            $usulan['jenis_pemohon'] = $pemohon['jenis_pemohon'];
        }
        return $usulan;
    }

    // Get usulan dengan relasi pemohon
    public function getWithPemohon($id = null)
    {
        $query = $this->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.nik as nik, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.email as email_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id', 'left');
        
        if ($id) {
            return $query->find($id);
        }
        
        return $query;
    }

    // Get all usulan dengan relasi pemohon untuk pagination
    public function getAllWithPemohon($limit = 10, $offset = 0)
    {
        return $this->select('usulan.*, pemohon.nama as nama_pemohon, pemohon.nik as nik, pemohon.alamat as alamat_pemohon, pemohon.no_hp as no_hp_pemohon, pemohon.email as email_pemohon, pemohon.jenis_pemohon as jenis_pemohon_pemohon')
            ->join('pemohon', 'pemohon.id = usulan.pemohon_id', 'left')
            ->orderBy('usulan.created_at', 'DESC')
            ->findAll($limit, $offset);
    }
}