<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;

class AuthSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'admin',
                'password_hash' => password_hash('@Super#25', PASSWORD_DEFAULT),
                'role'     => 'admin',
            ],
            [
                'username' => 'petugas',
                'password_hash' => password_hash('@Admin1#25', PASSWORD_DEFAULT),
                'role'     => 'petugas',
            ],
        ];

        // insert batch ke tabel users
        $this->db->table('users')->insertBatch($data);
    }
}
