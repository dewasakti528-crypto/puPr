<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['username', 'password_hash', 'role', 'status', 'created_at', 'updated_at'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function findByEmailOrUsername(string $identity)
    {
        return $this->where('username', $identity)
                     ->first();
    }

    public function verifyPassword(string $plainPassword, string $hash): bool
    {
        return password_verify($plainPassword, $hash);
    }
}