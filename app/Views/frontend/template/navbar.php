<!-- Navbar -->
    <nav
      class="navbar fixed top-0 w-full z-50 bg-white/90 dark:bg-slate-900/90 shadow-md transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <i class="fas fa-globe-asia text-2xl text-blue-600"></i>
            <span class="text-xl font-bold text-gray-800 dark:text-white"
              >SATRIA – DISPUPR</span
            >
          </div>

          <!-- Menu Desktop -->
          <div class="hidden md:flex space-x-8">
            <a
              href="#beranda"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Beranda</a
            >
            <a
              href="#peta"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Peta Zonasi</a
            >
            <a
              href="<?=base_url('tiket')?>"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Cari Tiket</a
            >
            <a
              href="#kontak"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Kontak</a
            >
            <a
              href="<?=base_url('usulan')?>"
              class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition-colors font-semibold"
              >Buat Usulan</a
            >
          </div>

          <!-- Toggle Theme & Mobile Menu -->
          <div class="flex items-center space-x-4">
            <!-- Toggle Theme -->
            <button
              id="theme-toggle"
              class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"
            >
              <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
              <i class="fas fa-moon text-blue-300 hidden dark:block"></i>
            </button>

            <!-- Mobile Menu Button -->
            <button
              id="mobile-menu-button"
              class="md:hidden p-2 rounded-md bg-gray-200 dark:bg-gray-700"
            >
              <i class="fas fa-bars text-gray-700 dark:text-gray-300"></i>
            </button>
          </div>
        </div>

        <!-- Mobile Menu -->
        <div
          id="mobile-menu"
          class="hidden md:hidden py-4 border-t border-gray-200 dark:border-gray-700"
        >
          <div class="flex flex-col space-y-4">
            <a
              href="#beranda"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Beranda</a
            >
            <a
              href="#peta"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Peta Zonasi</a
            >
            <a
              href="<?=base_url('tiket')?>"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Cari Tiket</a
            >
            <a
              href="#kontak"
              class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
              >Kontak</a
            >
            <a
              href="<?=base_url('usulan')?>"
              class="text-gray-700 dark:text-gray-300 hover:text-green-600 dark:hover:text-green-400 transition-colors font-semibold"
              >Buat Usulan</a
            >
          </div>
        </div>
      </div>
    </nav>