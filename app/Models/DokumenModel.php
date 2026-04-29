<?php

namespace App\Models;

use CodeIgniter\Model;

class DokumenModel extends Model
{
    protected $table            = 'dokumen';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['usulan_id', 'tipe_dokumen', 'filename', 'original_name', 'mime_type', 'file_size'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';

    // Dapatkan semua dokumen untuk usulan tertentu
    public function findByUsulan(int $usulanId): array
    {
        return $this->where('usulan_id', $usulanId)->findAll();
    }

    // Cari data dokumen berdasarkan filename
    public function findByFilename(string $filename): ?array
    {
        return $this->where('filename', $filename)->first();
    }
}