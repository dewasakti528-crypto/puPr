<!-- Navigation Menu -->
<div class="flex-1 py-4">
  <nav class="space-y-1 px-4">
    <!-- Dashboard -->
    <a
      href="<?= base_url('admin') ?>"
      class="flex items-center space-x-3 py-3 px-4 <?= (uri_string() == 'admin' || uri_string() == '') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> rounded-lg transition-colors"
    >
      <i class="fas fa-tachometer-alt w-5 text-center"></i>
      <span class="sidebar-text font-medium">Dashboard</span>
    </a>

    <!-- Manajemen Usulan -->
    <a
      href="<?= base_url('admin/usulan') ?>"
      class="flex items-center space-x-3 py-3 px-4 <?= (strpos(uri_string(), 'admin/usulan') !== false) ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' ?> rounded-lg transition-colors"
    >
      <i class="fas fa-file-alt w-5 text-center"></i>
      <span class="sidebar-text">Manajemen Usulan</span>
      <?php if (isset($stats) && isset($stats['submitted']) && $stats['submitted'] > 0): ?>
        <span class="ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full sidebar-text">
          <?= $stats['submitted'] ?>
        </span>
      <?php endif; ?>
    </a>

    <!-- Form Usulan (Frontend) -->
    <a
      href="<?= base_url('usulan/form') ?>"
      class="flex items-center space-x-3 py-3 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
      target="_blank"
    >
      <i class="fas fa-map-marked-alt w-5 text-center"></i>
      <span class="sidebar-text">Form Usulan</span>
      <i class="fas fa-external-link-alt text-xs ml-auto sidebar-text"></i>
    </a>

    <!-- Peta Zonasi (Frontend) -->
    <a
      href="<?= base_url('peta') ?>"
      class="flex items-center space-x-3 py-3 px-4 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors"
      target="_blank"
    >
      <i class="fas fa-map w-5 text-center"></i>
      <span class="sidebar-text">Peta Zonasi</span>
      <i class="fas fa-external-link-alt text-xs ml-auto sidebar-text"></i>
    </a>

    <!-- Divider -->
    <div class="border-t border-gray-200 dark:border-gray-700 my-2"></div>

    <!-- Data Bangunan (Coming Soon) -->
    <a
      href="#"
      class="flex items-center space-x-3 py-3 px-4 text-gray-400 dark:text-gray-600 cursor-not-allowed rounded-lg"
      onclick="alert('Fitur ini akan segera hadir'); return false;"
    >
      <i class="fas fa-building w-5 text-center"></i>
      <span class="sidebar-text">Data Bangunan</span>
      <span class="ml-auto text-xs sidebar-text">Soon</span>
    </a>

    <!-- Manajemen User (Coming Soon) -->
    <a
      href="#"
      class="flex items-center space-x-3 py-3 px-4 text-gray-400 dark:text-gray-600 cursor-not-allowed rounded-lg"
      onclick="alert('Fitur ini akan segera hadir'); return false;"
    >
      <i class="fas fa-users w-5 text-center"></i>
      <span class="sidebar-text">Manajemen User</span>
      <span class="ml-auto text-xs sidebar-text">Soon</span>
    </a>

    <!-- Pengaturan (Coming Soon) -->
    <a
      href="#"
      class="flex items-center space-x-3 py-3 px-4 text-gray-400 dark:text-gray-600 cursor-not-allowed rounded-lg"
      onclick="alert('Fitur ini akan segera hadir'); return false;"
    >
      <i class="fas fa-cog w-5 text-center"></i>
      <span class="sidebar-text">Pengaturan</span>
      <span class="ml-auto text-xs sidebar-text">Soon</span>
    </a>
  </nav>

  <!-- Statistics Summary -->
  <?php if (isset($stats)): ?>
  <div class="mt-8 px-4">
    <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-3 sidebar-text">
      Statistik Usulan
    </h3>
    <div class="space-y-2">
      <div class="flex items-center justify-between p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
        <div class="flex items-center space-x-2">
          <i class="fas fa-inbox text-blue-600 dark:text-blue-400 text-sm"></i>
          <span class="text-sm text-gray-700 dark:text-gray-300 sidebar-text">Total</span>
        </div>
        <span class="text-sm font-bold text-blue-600 dark:text-blue-400 sidebar-text">
          <?= $stats['total'] ?? 0 ?>
        </span>
      </div>

      <div class="flex items-center justify-between p-2 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <div class="flex items-center space-x-2">
          <i class="fas fa-clock text-yellow-600 dark:text-yellow-400 text-sm"></i>
          <span class="text-sm text-gray-700 dark:text-gray-300 sidebar-text">Pending</span>
        </div>
        <span class="text-sm font-bold text-yellow-600 dark:text-yellow-400 sidebar-text">
          <?= $stats['submitted'] ?? 0 ?>
        </span>
      </div>

      <div class="flex items-center justify-between p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
        <div class="flex items-center space-x-2">
          <i class="fas fa-check text-green-600 dark:text-green-400 text-sm"></i>
          <span class="text-sm text-gray-700 dark:text-gray-300 sidebar-text">Disetujui</span>
        </div>
        <span class="text-sm font-bold text-green-600 dark:text-green-400 sidebar-text">
          <?= $stats['approved'] ?? 0 ?>
        </span>
      </div>

      <div class="flex items-center justify-between p-2 bg-red-50 dark:bg-red-900/20 rounded-lg">
        <div class="flex items-center space-x-2">
          <i class="fas fa-times text-red-600 dark:text-red-400 text-sm"></i>
          <span class="text-sm text-gray-700 dark:text-gray-300 sidebar-text">Ditolak</span>
        </div>
        <span class="text-sm font-bold text-red-600 dark:text-red-400 sidebar-text">
          <?= $stats['rejected'] ?? 0 ?>
        </span>
      </div>
    </div>
  </div>
  <?php endif; ?>
</div>