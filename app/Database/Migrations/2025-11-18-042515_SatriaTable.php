<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSatriaTables extends Migration
{
    public function up()
    {
        // Tabel users (admin/petugas)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'username' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'role' => [
                'type' => 'ENUM("admin","petugas")',
                'default' => 'petugas',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('username');
        $this->forge->createTable('users', true);

        // Tabel pemohon (data sensitif akan dienkripsi di aplikasi)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'nik' => [
                'type' => 'TEXT', // dienkripsi → bisa lebih panjang
            ],
            'alamat' => [
                'type' => 'TEXT',
            ],
            'no_hp' => [
                'type' => 'TEXT', // dienkripsi
            ],
            'email' => [
                'type' => 'TEXT', // dienkripsi
            ],
            'jenis_pemohon' => [
                'type' => 'ENUM("perorangan","perusahaan","instansi","yayasan","lainnya")',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('pemohon', true);

        // Tabel usulan
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'pemohon_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'alamat_lokasi' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'kelurahan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'kecamatan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'default' => 'Tomohon Tengah',
            ],
            'koordinat_lat' => [
                'type' => 'DECIMAL',
                'constraint' => '10,7',
                'null' => true,
            ],
            'koordinat_lng' => [
                'type' => 'DECIMAL',
                'constraint' => '10,7',
                'null' => true,
            ],
            'luas_tanah' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'zona_rtrw' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => true,
            ],
            'kdb' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'klb' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'jenis_bangunan' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'tinggi_bangunan' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
            ],
            'luas_bangunan' => [
                'type' => 'DECIMAL',
                'constraint' => '12,2',
                'null' => true,
            ],
            'jumlah_lantai' => [
                'type' => 'TINYINT',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM("draft","submitted","approved","rejected","lainnya")',
                'default' => 'draft',
            ],
            'catatan_verifikasi' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'nomor_tiket' => [
                'type' => 'VARCHAR',
                'constraint' => 30,
                'null' => true,
            ],
            'submitted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('nomor_tiket');
        $this->forge->addForeignKey('pemohon_id', 'pemohon', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('usulan', true);

        // Tabel dokumen
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'usulan_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
            ],
            'tipe_dokumen' => [
                'type' => 'ENUM("ktp","sertifikat","gambar","lainnya")',
            ],
            'filename' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'original_name' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'mime_type' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'file_size' => [
                'type' => 'INT',
                'unsigned' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usulan_id', 'usulan', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('dokumen', true);

        // Tabel zonasi_geojson (opsional — untuk manajemen layer via admin)
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nama_layer' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'path_file' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
            ],
            'is_active' => [
                'type' => 'TINYINT',
                'default' => 0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('zonasi_geojson', true);
    }

    public function down()
    {
        $this->forge->dropTable('zonasi_geojson', true);
        $this->forge->dropTable('dokumen', true);
        $this->forge->dropTable('usulan', true);
        $this->forge->dropTable('pemohon', true);
        $this->forge->dropTable('users', true);
    }
}