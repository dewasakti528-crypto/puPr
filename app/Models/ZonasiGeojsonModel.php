<?php

namespace App\Models;

use CodeIgniter\Model;

class ZonasiGeojsonModel extends Model
{
    protected $table            = 'zonasi_geojson';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['nama_layer', 'path_file', 'is_active'];
    protected $useTimestamps    = true;
    protected $createdField     = 'created_at';

    // Dapatkan layer GeoJSON yang aktif
    public function getActiveLayer(): ?array
    {
        return $this->where('is_active', 1)->first();
    }
}