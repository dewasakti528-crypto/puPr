<?php

namespace App\Models;

use CodeIgniter\Model;

class PemohonModel extends Model
{
    protected $table            = 'pemohon';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama', 'nik', 'alamat', 'no_hp', 'email', 'jenis_pemohon','created_at','updated_at'];
    protected $useTimestamps    = true;
    protected $updatedField     = 'updated_at';
    protected $createdField     = 'created_at';

    // Enkripsi otomatis sebelum insert/update
    protected function encryptFields(array $data): array
    {
        $sensitive = ['nik', 'no_hp', 'email'];
        foreach ($sensitive as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $data[$field] = encrypt_sensitive($data[$field]);
            }
        }
        return $data;
    }

    // Dekripsi otomatis saat ambil data
    protected function decryptFields(array $data): array
    {
        $sensitive = ['nik', 'no_hp', 'email'];
        foreach ($sensitive as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                $data[$field] = decrypt_sensitive($data[$field]);
            }
        }
        return $data;
    }

    // // Override insert
    // public function insert($data = null, bool $returnID = true)
    // {
    //     if (is_array($data)) {
    //         $data = $this->encryptFields($data);
    //     }
    //     return parent::insert($data, $returnID);
    // }

    // // Override update
    // public function update($id = null, $data = null)
    // {
    //     if (is_array($data)) {
    //         $data = $this->encryptFields($data);
    //     }
    //     return parent::update($id, $data);
    // }

    // // Override find dan findAll untuk dekripsi
    // public function find($id = null)
    // {
    //     $result = parent::find($id);
    //     if ($result === null) return null;
    //     if (is_array($result) && isset($result[$this->primaryKey])) {
    //         return $this->decryptFields($result);
    //     }
    //     if (is_array($result) && !isset($result[$this->primaryKey])) {
    //         foreach ($result as &$row) {
    //             $row = $this->decryptFields($row);
    //         }
    //     }
    //     return $result;
    // }

    // public function findAll(int $limit = 0, int $offset = 0)
    // {
    //     $results = parent::findAll($limit, $offset);
    //     foreach ($results as &$row) {
    //         $row = $this->decryptFields($row);
    //     }
    //     return $results;
    // }
}