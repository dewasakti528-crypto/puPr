<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
  <!-- Welcome Banner -->
  <div class="gradient-bg rounded-2xl p-6 text-white mb-6 shadow-lg">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
      <div>
        <h2 class="text-2xl font-bold mb-2">Selamat Datang, Admin!</h2>
        <p class="opacity-90">
          Sistem Informasi Geospasial Perencanaan Pembangunan Tomohon Tengah
        </p>
      </div>
      <div class="mt-4 md:mt-0">
        <a href="<?= base_url('usulan') ?>" class="bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white py-2 px-6 rounded-lg transition-colors flex items-center space-x-2">
          <i class="fas fa-plus"></i>
          <span>Usulan Baru</span>
        </a>
      </div>
    </div>
  </div>

  <!-- Stats Overview -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Usulan -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-blue-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Total Usulan</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['total']) ? number_format($stats['total']) : '142' ?>
          </h3>
          <p class="text-xs text-green-500 mt-2 flex items-center">
            <i class="fas fa-arrow-up mr-1"></i>
            <span>12% dari bulan lalu</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-file-alt text-blue-600 dark:text-blue-400 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Usulan Disetujui -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-green-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['approved']) ? number_format($stats['approved']) : '89' ?>
          </h3>
          <p class="text-xs text-green-500 mt-2 flex items-center">
            <i class="fas fa-check-circle mr-1"></i>
            <span>63% approval rate</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-check-circle text-green-600 dark:text-green-400 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Dalam Proses -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-yellow-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Dalam Proses</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['pending']) ? number_format($stats['pending']) : '38' ?>
          </h3>
          <p class="text-xs text-yellow-500 mt-2 flex items-center">
            <i class="fas fa-clock mr-1"></i>
            <span>Rata-rata 5 hari</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Perlu Revisi -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-red-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Perlu Revisi</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['rejected']) ? number_format($stats['rejected']) : '15' ?>
          </h3>
          <p class="text-xs text-red-500 mt-2 flex items-center">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <span>Perlu tindakan</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Charts and Maps Section -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <!-- Chart 1: Usulan per Zona -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Usulan per Zona</h3>
        <select class="bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option>Bulan Ini</option>
          <option>3 Bulan Terakhir</option>
          <option>Tahun Ini</option>
        </select>
      </div>
      <div class="chart-container">
        <canvas id="zonaChart"></canvas>
      </div>
    </div>

    <!-- Progress Overview -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Progress Overview</h3>
      <div class="space-y-5">
        <div>
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
            <span>Zona Perumahan</span>
            <span>75%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill bg-blue-500" style="width: 75%"></div>
          </div>
        </div>

        <div>
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
            <span>Zona Komersial</span>
            <span>60%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill bg-purple-500" style="width: 60%"></div>
          </div>
        </div>

        <div>
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
            <span>Zona Industri</span>
            <span>45%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill bg-red-500" style="width: 45%"></div>
          </div>
        </div>

        <div>
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-2">
            <span>Zona Khusus</span>
            <span>30%</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill bg-green-500" style="width: 30%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Recent Activity and Quick Actions -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Usulan -->
    <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover">
      <div class="flex justify-between items-center mb-6">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Usulan Terbaru</h3>
        <a href="<?= base_url('admin/usulan') ?>" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">Lihat Semua</a>
      </div>
      <div class="table-container">
        <table class="min-w-full">
          <thead>
            <tr class="border-b border-gray-200 dark:border-gray-700">
              <th class="text-left py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Pemohon</th>
              <th class="text-left py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</th>
              <th class="text-left py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
              <th class="text-left py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
              <th class="text-left py-3 text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
            <?php if (isset($recent_usulan) && count($recent_usulan) > 0): ?>
              <?php foreach ($recent_usulan as $usulan): ?>
                <tr>
                  <td class="py-3 text-sm text-gray-800 dark:text-gray-200">
                    <?= esc($usulan['nama_pemohon'] ?? 'Unknown') ?>
                  </td>
                  <td class="py-3 text-sm text-gray-600 dark:text-gray-400">
                    <?= esc($usulan['kelurahan'] ?? '-') ?>
                  </td>
                  <td class="py-3 text-sm text-gray-600 dark:text-gray-400">
                    <?= date('d M Y', strtotime($usulan['created_at'])) ?>
                  </td>
                  <td class="py-3">
                    <?php
                    $statusClass = [
                      'submitted' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                      'approved' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                      'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                    ];
                    $statusText = [
                      'submitted' => 'Proses',
                      'approved' => 'Disetujui',
                      'rejected' => 'Revisi'
                    ];
                    $status = $usulan['status'] ?? 'submitted';
                    ?>
                    <span class="px-2 py-1 <?= $statusClass[$status] ?> text-xs rounded-full">
                      <?= $statusText[$status] ?>
                    </span>
                  </td>
                  <td class="py-3">
                    <a href="<?= base_url('admin/usulan/detail/' . $usulan['id']) ?>" 
                       class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-200">
                      <i class="fas fa-eye"></i>
                    </a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                  <i class="fas fa-inbox text-4xl mb-2"></i>
                  <p>Belum ada data usulan</p>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 card-hover">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-6">Aksi Cepat</h3>
      <div class="space-y-4">
        <a href="<?= base_url('usulan') ?>" 
           class="flex items-center space-x-3 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-300 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors">
          <div class="w-10 h-10 bg-blue-100 dark:bg-blue-800 rounded-lg flex items-center justify-center">
            <i class="fas fa-plus text-blue-600 dark:text-blue-400"></i>
          </div>
          <div>
            <p class="font-medium">Buat Usulan Baru</p>
            <p class="text-sm opacity-75">Formulir KRK</p>
          </div>
        </a>

        <a href="<?= base_url('admin/usulan') ?>" 
           class="flex items-center space-x-3 p-4 bg-purple-50 dark:bg-purple-900/20 text-purple-700 dark:text-purple-300 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
          <div class="w-10 h-10 bg-purple-100 dark:bg-purple-800 rounded-lg flex items-center justify-center">
            <i class="fas fa-list text-purple-600 dark:text-purple-400"></i>
          </div>
          <div>
            <p class="font-medium">Kelola Usulan</p>
            <p class="text-sm opacity-75">Verifikasi data</p>
          </div>
        </a>

        <a href="#" 
           class="flex items-center space-x-3 p-4 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors">
          <div class="w-10 h-10 bg-green-100 dark:bg-green-800 rounded-lg flex items-center justify-center">
            <i class="fas fa-download text-green-600 dark:text-green-400"></i>
          </div>
          <div>
            <p class="font-medium">Export Laporan</p>
            <p class="text-sm opacity-75">Data bulanan</p>
          </div>
        </a>

        <a href="#" 
           class="flex items-center space-x-3 p-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300 rounded-lg hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors">
          <div class="w-10 h-10 bg-red-100 dark:bg-red-800 rounded-lg flex items-center justify-center">
            <i class="fas fa-cog text-red-600 dark:text-red-400"></i>
          </div>
          <div>
            <p class="font-medium">Pengaturan Sistem</p>
            <p class="text-sm opacity-75">Konfigurasi</p>
          </div>
        </a>
      </div>
    </div>
  </div>
<?= $this->endSection() ?>