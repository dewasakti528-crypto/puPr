<?= $this->extend('backend/template/layout') ?>

<?= $this->section('content') ?>
  <!-- Header Section -->
  <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6">
    <div>
      <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-2">
        Data Usulan Keseluruhan Rencana Kota Tomohon
      </h2>
      <p class="text-gray-600 dark:text-gray-400">
        Kelola dan verifikasi semua usulan pembangunan di wilayah Tomohon Tengah
      </p>
    </div>
    <div class="flex space-x-3 mt-4 md:mt-0">
      <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        <i class="fas fa-download"></i>
        <span>Export Data</span>
      </button>
      <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
        <i class="fas fa-filter"></i>
        <span>Filter Lanjutan</span>
      </button>
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
            <?= isset($stats['total']) ? number_format($stats['total']) : '0' ?>
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

    <!-- Menunggu Verifikasi -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-yellow-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Menunggu Verifikasi</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['pending']) ? number_format($stats['pending']) : '0' ?>
          </h3>
          <p class="text-xs text-yellow-500 mt-2 flex items-center">
            <i class="fas fa-clock mr-1"></i>
            <span>Perlu tindakan</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-hourglass-half text-yellow-600 dark:text-yellow-400 text-xl"></i>
        </div>
      </div>
    </div>

    <!-- Disetujui -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-green-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Disetujui</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['approved']) ? number_format($stats['approved']) : '0' ?>
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

    <!-- Perlu Revisi -->
    <div class="stat-card rounded-xl p-5 shadow-md border-l-red-500 card-hover">
      <div class="flex justify-between items-start">
        <div>
          <p class="text-sm text-gray-500 dark:text-gray-400">Perlu Revisi</p>
          <h3 class="text-2xl font-bold text-gray-800 dark:text-white mt-1">
            <?= isset($stats['rejected']) ? number_format($stats['rejected']) : '0' ?>
          </h3>
          <p class="text-xs text-red-500 mt-2 flex items-center">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <span>Menunggu respon</span>
          </p>
        </div>
        <div class="w-12 h-12 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center">
          <i class="fas fa-exclamation-circle text-red-600 dark:text-red-400 text-xl"></i>
        </div>
      </div>
    </div>
  </div>

  <!-- Filters and Actions -->
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md p-6 mb-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0">
      <div class="flex flex-wrap gap-3">
        <button class="px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-lg font-medium flex items-center space-x-2" onclick="filterUsulan('all')">
          <span>Semua</span>
          <span class="bg-blue-200 dark:bg-blue-800 text-blue-800 dark:text-blue-200 px-2 py-1 rounded-full text-xs">
            <?= isset($stats['total']) ? number_format($stats['total']) : '0' ?>
          </span>
        </button>
        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center space-x-2" onclick="filterUsulan('submitted')">
          <span>Menunggu</span>
          <span class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full text-xs">
            <?= isset($stats['pending']) ? number_format($stats['pending']) : '0' ?>
          </span>
        </button>
        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center space-x-2" onclick="filterUsulan('approved')">
          <span>Disetujui</span>
          <span class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full text-xs">
            <?= isset($stats['approved']) ? number_format($stats['approved']) : '0' ?>
          </span>
        </button>
        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors flex items-center space-x-2" onclick="filterUsulan('rejected')">
          <span>Revisi</span>
          <span class="bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 px-2 py-1 rounded-full text-xs">
            <?= isset($stats['rejected']) ? number_format($stats['rejected']) : '0' ?>
          </span>
        </button>
      </div>

      <div class="flex space-x-3">
        <select class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterByZona(this.value)">
          <option value="">Semua Zona</option>
          <option value="Perumahan">Zona Perumahan</option>
          <option value="Komersial">Zona Komersial</option>
          <option value="Industri">Zona Industri</option>
          <option value="Khusus">Zona Khusus</option>
        </select>

        <select class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" onchange="filterByKelurahan(this.value)">
          <option value="">Semua Kelurahan</option>
          <option value="Tinoor">Tinoor</option>
          <option value="Kamasi">Kamasi</option>
          <option value="Talete">Talete</option>
          <option value="Wailan">Wailan</option>
        </select>
      </div>
    </div>
  </div>

  <!-- Usulan Table -->
  <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md overflow-hidden card-hover">
    <div class="table-container">
      <table class="min-w-full">
        <thead class="bg-gray-50 dark:bg-gray-700 sticky top-0">
          <tr>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">No. Tiket</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Pemohon</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Lokasi</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Zona</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Luas Tanah</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Status</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal</th>
            <th class="text-left py-4 px-6 text-sm font-medium text-gray-500 dark:text-gray-400">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 dark:divide-gray-700" id="usulan-table-body">
          <?php if (isset($usulan) && count($usulan) > 0): ?>
            <?php foreach ($usulan as $usulan): ?>
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <td class="py-4 px-6">
                  <div class="font-mono text-sm font-medium text-gray-800 dark:text-white">
                    <?= esc($usulan['nomor_tiket']) ?>
                  </div>
                </td>
                 <td class="py-4 px-6">
                   <div>
                     <p class="font-medium text-gray-800 dark:text-white">
                       <?= esc($usulan['nama_pemohon']) ?>
                     </p>
                     <p class="text-sm text-gray-500 dark:text-gray-400">
                       <?= esc($usulan['nik'] ?? '-') ?>
                     </p>
                   </div>
                 </td>
                <td class="py-4 px-6">
                  <div>
                    <p class="text-sm text-gray-800 dark:text-white">
                      <?= esc($usulan['alamat_lokasi']) ?>
                    </p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                      <?= esc($usulan['kelurahan']) ?>
                    </p>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <span class="text-sm text-gray-800 dark:text-white">
                    <?= esc($usulan['zona_rtrw']) ?>
                  </span>
                </td>
                <td class="py-4 px-6 text-sm text-gray-800 dark:text-white">
                  <?= number_format($usulan['luas_tanah'], 2, ',', '.') ?> m²
                </td>
                <td class="py-4 px-6">
                  <?php
                  $statusClass = [
                    'submitted' => 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                    'approved' => 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                    'rejected' => 'bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200'
                  ];
                  $statusText = [
                    'submitted' => 'Menunggu',
                    'approved' => 'Disetujui',
                    'rejected' => 'Perlu Revisi'
                  ];
                  $status = $usulan['status'] ?? 'submitted';
                  ?>
                  <span class="status-badge <?= $statusClass[$status] ?>">
                    <?php
                    $icon = [
                      'submitted' => 'fas fa-clock',
                      'approved' => 'fas fa-check-circle',
                      'rejected' => 'fas fa-exclamation-circle'
                    ];
                    ?>
                    <i class="fas <?= $icon[$status] ?>"></i>
                    <?= $statusText[$status] ?>
                  </span>
                </td>
                <td class="py-4 px-6">
                  <div class="text-sm text-gray-600 dark:text-gray-400">
                    <div><?= date('d M Y', strtotime($usulan['created_at'])) ?></div>
                    <div class="text-xs"><?= date('H:i WITA', strtotime($usulan['created_at'])) ?></div>
                  </div>
                </td>
                <td class="py-4 px-6">
                  <div class="action-buttons">
                    <button class="detail-btn px-3 py-1 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded text-xs hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors" onclick="showDetail(<?= $usulan['id'] ?>)">
                      <i class="fas fa-eye mr-1"></i>Detail
                    </button>
                    <?php if ($usulan['status'] === 'submitted'): ?>
                      <button class="px-3 py-1 bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300 rounded text-xs hover:bg-green-200 dark:hover:bg-green-800 transition-colors" onclick="approveUsulan(<?= $usulan['id'] ?>)">
                         <i class="fas fa-check mr-1"></i>Setujui
                      </button>
                      <button class="px-3 py-1 bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300 rounded text-xs hover:bg-red-200 dark:hover:bg-red-800 transition-colors" onclick="rejectUsulan(<?= $usulan['id'] ?>)">
                         <i class="fas fa-times mr-1"></i>Tolak
                      </button>
                    <?php endif; ?>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
              <tr>
                <td colspan="8" class="py-8 text-center text-gray-500 dark:text-gray-400">
                  <i class="fas fa-inbox text-4xl mb-2"></i>
                  <p>Belum ada data usulan</p>
                </td>
              </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="bg-gray-50 dark:bg-gray-700 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
      <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <div class="text-sm text-gray-600 dark:text-gray-400">
          Menampilkan <?= isset($usulan) ? count($usulan) : 0 ?> dari <?= isset($stats['total']) ? number_format($stats['total']) : '0' ?> usulan
        </div>
        <div class="flex space-x-2">
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors" onclick="changePage('prev')">
            <i class="fas fa-chevron-left"></i>
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">
            <?= isset($currentPage) ? $currentPage : 1 ?>
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">
            2
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">
            3
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">
            ...
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg">
            36
          </button>
          <button class="px-3 py-1 bg-gray-200 dark:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-500 transition-colors" onclick="changePage('next')">
            <i class="fas fa-chevron-right"></i>
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Detail Usulan Modal -->
  <div id="detail-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-hidden">
        <!-- Modal Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-800 dark:to-blue-900 px-6 py-4 border-b border-gray-200 dark:border-gray-600">
          <div class="flex justify-between items-center">
            <div class="flex items-center space-x-3">
              <div class="w-10 h-10 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center">
                <i class="fas fa-file-alt text-blue-600 dark:text-blue-400"></i>
              </div>
              <div>
                <h3 class="text-xl font-bold text-white">Detail Usulan KRK</h3>
                <p class="text-blue-100 dark:text-blue-200 text-sm">Informasi lengkap pengajuan perizinan</p>
              </div>
            </div>
            <button id="close-detail-modal" class="text-white hover:text-blue-200 dark:hover:text-blue-300 transition-colors">
              <i class="fas fa-times text-xl"></i>
            </button>
          </div>
        </div>

        <!-- Modal Body -->
        <div class="p-6 overflow-y-auto max-h-[calc(90vh-80px)]">
          <!-- Quick Info Cards -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <!-- Status Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900 dark:to-blue-800 rounded-lg p-4 border border-blue-200 dark:border-blue-700">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-blue-700 dark:text-blue-300">Status</span>
                <i class="fas fa-info-circle text-blue-500"></i>
              </div>
              <div id="detail-status-badge" class="text-lg font-bold text-blue-900 dark:text-blue-100">-</div>
            </div>

            <!-- Nomor Tiket Card -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900 dark:to-green-800 rounded-lg p-4 border border-green-200 dark:border-green-700">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-green-700 dark:text-green-300">No. Tiket</span>
                <i class="fas fa-ticket-alt text-green-500"></i>
              </div>
              <div id="detail-nomor-tiket" class="text-lg font-bold text-green-900 dark:text-green-100 font-mono">-</div>
            </div>

            <!-- Tanggal Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900 dark:to-purple-800 rounded-lg p-4 border border-purple-200 dark:border-purple-700">
              <div class="flex items-center justify-between mb-2">
                <span class="text-sm font-medium text-purple-700 dark:text-purple-300">Tanggal</span>
                <i class="fas fa-calendar text-purple-500"></i>
              </div>
              <div id="detail-submitted-at" class="text-lg font-bold text-purple-900 dark:text-purple-100">-</div>
            </div>
          </div>

          <!-- Data Pemohon Section -->
          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
              <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-user text-blue-600 dark:text-blue-400"></i>
              </div>
              Data Pemohon
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Nama Lengkap</label>
                  <div id="detail-nama" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">NIK</label>
                  <div id="detail-nik" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 font-mono text-gray-800 dark:text-white">-</div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">No. HP</label>
                  <div id="detail-no-hp" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
              </div>
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Email</label>
                  <div id="detail-email" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Pemohon</label>
                  <div id="detail-jenis-pemohon" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat</label>
                  <div id="detail-alamat-pemohon" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Lokasi & Bangunan Section -->
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <!-- Lokasi -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
              <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mr-3">
                  <i class="fas fa-map-marker-alt text-green-600 dark:text-green-400"></i>
                </div>
                Lokasi & Zonasi
              </h4>
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Alamat Lokasi</label>
                  <div id="detail-alamat-lokasi" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kelurahan</label>
                    <div id="detail-kelurahan" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Kecamatan</label>
                    <div id="detail-kecamatan" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                </div>
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Koordinat</label>
                  <div id="detail-koordinat" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 font-mono text-gray-800 dark:text-white">-</div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Luas Tanah</label>
                    <div id="detail-luas-tanah" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Zona RTRW</label>
                    <div id="detail-zona-rtrw" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Rencana Bangunan -->
            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
              <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
                <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mr-3">
                  <i class="fas fa-building text-purple-600 dark:text-purple-400"></i>
                </div>
                Rencana Bangunan
              </h4>
              <div class="space-y-3">
                <div>
                  <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jenis Bangunan</label>
                  <div id="detail-jenis-bangunan" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Luas Bangunan</label>
                    <div id="detail-luas-bangunan" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Tinggi Bangunan</label>
                    <div id="detail-tinggi-bangunan" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                </div>
                <div class="grid grid-cols-3 gap-3">
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">Jumlah Lantai</label>
                    <div id="detail-jumlah-lantai" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">KDB</label>
                    <div id="detail-kdb" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                  <div>
                    <label class="text-sm font-medium text-gray-600 dark:text-gray-400">KLB</label>
                    <div id="detail-klb" class="mt-1 p-3 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 text-gray-800 dark:text-white">-</div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Map Verifikasi -->
          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
              <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-map text-indigo-600 dark:text-indigo-400"></i>
              </div>
              Verifikasi Lokasi
            </h4>
            <div class="map-container" style="height: 400px;">
              <div id="verification-map" class="w-full h-full rounded-lg border border-gray-300 dark:border-gray-600"></div>
            </div>
          </div>

          <!-- Catatan Verifikasi -->
          <div id="catatan-section" class="bg-yellow-50 dark:bg-yellow-900 rounded-lg p-6 mb-6 hidden">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
              <div class="w-8 h-8 bg-yellow-100 dark:bg-yellow-800 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-exclamation-triangle text-yellow-600 dark:text-yellow-400"></i>
              </div>
              Catatan Verifikasi
            </h4>
            <div id="detail-catatan-verifikasi" class="p-4 bg-white dark:bg-gray-800 rounded-lg border border-yellow-200 dark:border-yellow-700 text-gray-800 dark:text-white">-</div>
          </div>

          <!-- Dokumen Pendukung -->
          <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
            <h4 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 flex items-center">
              <div class="w-8 h-8 bg-red-100 dark:bg-red-900 rounded-lg flex items-center justify-center mr-3">
                <i class="fas fa-file-alt text-red-600 dark:text-red-400"></i>
              </div>
              Dokumen Pendukung
            </h4>
            <div id="detail-dokumen" class="space-y-3">-</div>
          </div>
        </div>

        <!-- Action Buttons -->
        <div class="bg-gray-100 dark:bg-gray-800 px-6 py-4 border-t border-gray-200 dark:border-gray-600">
          <div class="flex justify-between items-center">
            <div class="flex space-x-3">
              <button id="close-detail-btn" class="px-6 py-3 bg-gray-500 text-white rounded-lg font-medium hover:bg-gray-600 transition-colors">
                <i class="fas fa-times mr-2"></i>Tutup
              </button>
            </div>
            <div class="flex space-x-3">
              <button class="px-6 py-3 bg-blue-500 text-white rounded-lg font-medium hover:bg-blue-600 transition-colors" onclick="printDetail()">
                <i class="fas fa-print mr-2"></i>Cetak Detail
              </button>
              <button id="approve-btn" class="px-6 py-3 bg-green-500 text-white rounded-lg font-medium hover:bg-green-600 transition-colors hidden">
                <i class="fas fa-check mr-2"></i>Setujui
              </button>
              <button id="reject-btn" class="px-6 py-3 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors hidden">
                <i class="fas fa-times mr-2"></i>Tolak
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Reject Confirmation Modal -->
  <div id="reject-modal" class="fixed inset-0 bg-black bg-opacity-50 z-[60] hidden flex items-center justify-center">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-md w-full mx-4">
      <!-- Modal Header -->
      <div class="bg-gradient-to-r from-red-600 to-red-700 dark:from-red-800 dark:to-red-900 px-6 py-4 rounded-t-xl">
        <div class="flex items-center space-x-3">
          <div class="w-10 h-10 bg-white dark:bg-gray-700 rounded-lg flex items-center justify-center">
            <i class="fas fa-exclamation-triangle text-red-600 dark:text-red-400"></i>
          </div>
          <div>
            <h3 class="text-xl font-bold text-white">Tolak Usulan</h3>
            <p class="text-red-100 dark:text-red-200 text-sm">Masukkan alasan penolakan</p>
          </div>
        </div>
      </div>

      <!-- Modal Body -->
      <div class="p-6">
        <div class="mb-4">
          <label for="reject-reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            Catatan Penolakan <span class="text-red-500">*</span>
          </label>
          <textarea
            id="reject-reason"
            rows="4"
            class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 dark:bg-gray-700 dark:text-white resize-none"
            placeholder="Jelaskan alasan penolakan usulan ini..."
          ></textarea>
          <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
            Catatan ini akan dikirimkan kepada pemohon
          </p>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end space-x-3">
          <button
            id="cancel-reject-btn"
            class="px-6 py-2 bg-gray-500 text-white rounded-lg font-medium hover:bg-gray-600 transition-colors"
          >
            <i class="fas fa-times mr-2"></i>Batal
          </button>
          <button
            id="confirm-reject-btn"
            class="px-6 py-2 bg-red-500 text-white rounded-lg font-medium hover:bg-red-600 transition-colors"
          >
            <i class="fas fa-check mr-2"></i>Tolak Usulan
          </button>
        </div>
      </div>
    </div>
  </div>  
  
<?= $this->endSection() ?>