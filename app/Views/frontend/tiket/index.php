
<?=$this->extend('frontend/template/layout') ?>
<?=$this->section('content') ?>
<!-- Main Content -->
    <section
      class="pt-24 pb-16 min-h-screen bg-gray-50 dark:bg-gray-900 transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
          <!-- Header Section -->
          <div class="text-center mb-10">
            <h1 class="text-3xl font-bold mb-4 text-gray-800 dark:text-white">
              Pencarian Data Usulan
            </h1>
            <p class="text-lg text-gray-600 dark:text-gray-300">
              Cari data usulan pembangunan berdasarkan nomor tiket
            </p>
          </div>

          <!-- Search Form -->
          <div
            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 mb-8 transition-all"
          >
            <form id="search-form" class="space-y-4">
              <div class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                  <label
                    for="nomor_tiket"
                    class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                  >
                    Nomor Tiket
                  </label>
                  <input
                    type="text"
                    id="nomor_tiket"
                    name="nomor_tiket"
                    class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg dark:bg-gray-700 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nomor tiket (contoh: 12345)"
                    required
                  />
                </div>
                <div class="flex items-end">
                  <button
                    type="submit"
                    class="btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg w-full md:w-auto"
                  >
                    <i class="fas fa-search mr-2"></i>Cari Data
                  </button>
                </div>
              </div>
              <div class="text-sm text-gray-500 dark:text-gray-400">
                <p>
                  💡 <strong>Tips:</strong> Gunakan nomor tiket
                  <code>12345</code>, <code>demo</code>, atau
                  <code>valid</code> untuk testing
                </p>
              </div>
            </form>
          </div>

          <!-- Results Section -->
          <div
            id="results-section"
            class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 transition-all"
          >
            <h2 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">
              Data Usulan Ditemukan
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
              <!-- Left Column -->
              <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                  <h3
                    class="text-lg font-semibold mb-4 text-gray-800 dark:text-white flex items-center"
                  >
                    <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                    Informasi Dasar
                  </h3>
                  <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Nomor Tiket:</span
                      >
                      <span
                        id="nomor_tiket_result"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Pemohon ID:</span
                      >
                      <span
                        id="pemohon_id"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Status:</span
                      >
                      <span
                        id="status"
                        class="px-2 py-1 rounded-full text-xs font-medium"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Tanggal Pengajuan:</span
                      >
                      <span
                        id="submitted_at"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Tanggal Verifikasi:</span
                      >
                      <span
                        id="verified_at"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                  </div>
                </div>

                <!-- Location Information -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                  <h3
                    class="text-lg font-semibold mb-4 text-gray-800 dark:text-white flex items-center"
                  >
                    <i class="fas fa-map-marker-alt mr-2 text-red-500"></i>
                    Informasi Lokasi
                  </h3>
                  <div class="space-y-3">
                    <div>
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Alamat:</span
                      >
                      <p
                        id="alamat_lokasi"
                        class="text-gray-800 dark:text-white"
                      >
                        -
                      </p>
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Kelurahan:</span
                      >
                      <span id="kelurahan" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Kecamatan:</span
                      >
                      <span id="kecamatan" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Koordinat:</span
                      >
                      <span id="koordinat" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Column -->
              <div class="space-y-6">
                <!-- Zoning Information -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                  <h3
                    class="text-lg font-semibold mb-4 text-gray-800 dark:text-white flex items-center"
                  >
                    <i class="fas fa-draw-polygon mr-2 text-purple-500"></i>
                    Informasi Zonasi
                  </h3>
                  <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Zona RTRW:</span
                      >
                      <span id="zona_rtrw" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >KDB:</span
                      >
                      <span id="kdb" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >KLB:</span
                      >
                      <span id="klb" class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Luas Tanah:</span
                      >
                      <span
                        id="luas_tanah"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                  </div>
                </div>

                <!-- Building Information -->
                <div class="bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                  <h3
                    class="text-lg font-semibold mb-4 text-gray-800 dark:text-white flex items-center"
                  >
                    <i class="fas fa-building mr-2 text-green-500"></i>
                    Informasi Bangunan
                  </h3>
                  <div class="space-y-3">
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Jenis Bangunan:</span
                      >
                      <span
                        id="jenis_bangunan"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Tinggi Bangunan:</span
                      >
                      <span
                        id="tinggi_bangunan"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Luas Bangunan:</span
                      >
                      <span
                        id="luas_bangunan"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                    <div class="grid grid-cols-2 gap-2">
                      <span class="text-gray-600 dark:text-gray-300 font-medium"
                        >Jumlah Lantai:</span
                      >
                      <span
                        id="jumlah_lantai"
                        class="text-gray-800 dark:text-white"
                        >-</span
                      >
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Verification Notes -->
            <div class="mt-6 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
              <h3
                class="text-lg font-semibold mb-4 text-gray-800 dark:text-white flex items-center"
              >
                <i class="fas fa-sticky-note mr-2 text-yellow-500"></i>
                Catatan Verifikasi
              </h3>
              <p id="catatan_verifikasi" class="text-gray-800 dark:text-white">
                -
              </p>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-end">
              <button
                id="print-button"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors"
              >
                <i class="fas fa-print mr-2"></i>Cetak Data
              </button>
              <button
                id="new-search-button"
                class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg transition-colors"
              >
                <i class="fas fa-search mr-2"></i>Cari Lagi
              </button>
            </div>
          </div>

          <!-- No Results Section -->
          <div
            id="no-results-section"
            class="hidden bg-white dark:bg-gray-800 rounded-xl shadow-lg p-8 text-center transition-all"
          >
            <div class="mb-4">
              <i class="fas fa-search text-5xl text-gray-400 mb-4"></i>
              <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">
                Data Tidak Ditemukan
              </h3>
              <p class="text-gray-600 dark:text-gray-300">
                Tidak ada data usulan yang sesuai dengan nomor tiket yang
                dimasukkan.
              </p>
              <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                Coba dengan: <code>12345</code>, <code>demo</code>, atau
                <code>valid</code>
              </p>
            </div>
            <button
              id="try-again-button"
              class="btn-gradient text-white font-bold py-2 px-6 rounded-lg shadow-lg"
            >
              <i class="fas fa-redo mr-2"></i>Coba Lagi
            </button>
          </div>
        </div>
      </div>
    </section>

<?=$this->endSection()?>