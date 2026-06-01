<?=$this->extend('frontend/template/layout') ?>
<?=$this->section('content') ?>
<!-- Hero Section -->
    <section id="beranda" class="hero-bg pt-24 pb-20 text-white">
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center" data-aos="fade-up">
          <h1 class="text-4xl md:text-5xl font-bold mb-6">
            SATRIA
          </h1>
          <h1 class="text-4xl md:text-5xl font-bold mb-6">
            <span>
              <span class="text-red-500 text-5xl drop-shadow font-extrabold">S</span>istem 
              <span class="text-sky-400 text-5xl drop-shadow font-extrabold">A</span>kuntabilitas 
              <span class="text-red-500 text-5xl drop-shadow font-extrabold">T</span>ata 
              <span class="text-sky-400 text-5xl drop-shadow font-extrabold">R</span>uang 
              <span class="text-red-500 text-5xl drop-shadow font-extrabold">I</span>novatif 
              <span class="text-sky-400 text-5xl drop-shadow font-extrabold">A</span>daptif
            </span>
          </h1>
          <p class="text-xl mb-10 opacity-90">
            Sistem Akuntabilitas Tata Ruang yang dikembangkan oleh DPUPRD Kota Tomohon sebagai sistem informasi tata ruang yang memungkinkan masyarakat, pelaku usaha, arsitek, perencana, dan pemerintah daerah .
          </p>
          <div class="flex flex-col sm:flex-row justify-center gap-4">
            <a
              href="<?=base_url('usulan')?>"
              class="btn-gradient text-white font-bold py-3 px-8 rounded-lg shadow-lg"
              >Buat Usulan</a
            >
            <a
              href="#tentang"
              class="bg-white/20 text-white font-bold py-3 px-8 rounded-lg shadow-lg backdrop-blur-sm hover:bg-white/30 transition-colors"
              >Pelajari Sistem</a
            >
          </div>
        </div>
      </div>
    </section>

    <!-- About Section -->
    <section
      id="tentang"
      class="py-16 bg-white dark:bg-gray-800 transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-16" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
            Tentang Sistem
          </h2>
          <p class="text-lg text-gray-600 dark:text-gray-300">
          SATRIA adalah aplikasi/web yang dikembangkan oleh DPUPRD Kota Tomohon untuk mempermudah masyarakat dan pelaku pembangunan dalam melakukan pengecekan tata ruang serta pengurusan Keterangan Rencana Kota (KRK) secara digital.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Feature 1 -->
          <div
            class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-md text-center transition-all hover:shadow-lg"
            data-aos="zoom-in"
            data-aos-delay="100"
          >
            <div
              class="w-16 h-16 mx-auto mb-6 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center"
            >
              <i
                class="fas fa-map text-2xl text-blue-600 dark:text-blue-400"
              ></i>
            </div>
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
              Visualisasi Peta Dinamis
            </h3>
            <p class="text-gray-600 dark:text-gray-300">
              Tampilkan data zonasi wilayah dalam peta interaktif dengan
              informasi detail setiap zona.
            </p>
          </div>

          <!-- Feature 2 -->
          <div
            class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-md text-center transition-all hover:shadow-lg"
            data-aos="zoom-in"
            data-aos-delay="200"
          >
            <div
              class="w-16 h-16 mx-auto mb-6 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center"
            >
              <i
                class="fas fa-calculator text-2xl text-purple-600 dark:text-purple-400"
              ></i>
            </div>
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
              Perhitungan Bangunan Otomatis
            </h3>
            <p class="text-gray-600 dark:text-gray-300">
              Hitung luas maksimum bangunan yang diizinkan berdasarkan koefisien
              dasar bangunan (KDB).
            </p>
          </div>

          <!-- Feature 3 -->
          <div
            class="bg-gray-50 dark:bg-gray-700 p-8 rounded-xl shadow-md text-center transition-all hover:shadow-lg"
            data-aos="zoom-in"
            data-aos-delay="300"
          >
            <div
              class="w-16 h-16 mx-auto mb-6 rounded-full bg-red-100 dark:bg-red-900 flex items-center justify-center"
            >
              <i
                class="fas fa-database text-2xl text-red-600 dark:text-red-400"
              ></i>
            </div>
            <h3 class="text-xl font-bold mb-4 text-gray-800 dark:text-white">
              Manajemen Data Spasial Aman
            </h3>
            <p class="text-gray-600 dark:text-gray-300">
              Kelola data spasial dengan aman melalui sistem admin yang
              terintegrasi.
            </p>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4">
        <div class="mt-12 flex flex-col md:flex-row gap-8">
          <!-- Informasi Fitur -->
          <div class="flex-1 space-y-6">
            <div class="flex items-start gap-4">
              <span class="flex-shrink-0 rounded-full bg-blue-100 dark:bg-blue-900 p-3">
                <i class="fas fa-map-marker-alt text-blue-600 dark:text-blue-400"></i>
              </span>
              <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Pengecekan Peruntukan Ruang Mandiri</h4>
                <p class="text-gray-600 dark:text-gray-300">
                  Melakukan pengecekan peruntukan ruang secara mandiri menggunakan peta interaktif pola ruang yang dilengkapi fitur pencarian berdasarkan titik koordinat.
                </p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <span class="flex-shrink-0 rounded-full bg-yellow-100 dark:bg-yellow-900 p-3">
                <i class="fas fa-info-circle text-yellow-600 dark:text-yellow-400"></i>
              </span>
              <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Akses Informasi KUZ</h4>
                <p class="text-gray-600 dark:text-gray-300">
                  Mengakses informasi Ketentuan Umum Zonasi (KUZ) pada setiap zona tata ruang, termasuk KDB, KLB, KDH dan ketentuan teknis lainnya.
                </p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <span class="flex-shrink-0 rounded-full bg-green-100 dark:bg-green-900 p-3">
                <i class="fas fa-ruler-combined text-green-600 dark:text-green-400"></i>
              </span>
              <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Hitung Luas Bangunan Otomatis</h4>
                <p class="text-gray-600 dark:text-gray-300">
                  Menghitung perkiraan luas bangunan langsung melalui peta interaktif.
                </p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <span class="flex-shrink-0 rounded-full bg-purple-100 dark:bg-purple-900 p-3">
                <i class="fas fa-file-upload text-purple-600 dark:text-purple-400"></i>
              </span>
              <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Permohonan KRK Online</h4>
                <p class="text-gray-600 dark:text-gray-300">
                  Mengajukan permohonan KRK (Keterangan Rencana Kota) secara online dengan mengisi data diri, data kepemilikan lahan, dan mengunggah berkas persyaratan (pdf/jpg).
                </p>
              </div>
            </div>
            <div class="flex items-start gap-4">
              <span class="flex-shrink-0 rounded-full bg-red-100 dark:bg-red-900 p-3">
                <i class="fas fa-ticket-alt text-red-600 dark:text-red-400"></i>
              </span>
              <div>
                <h4 class="text-lg font-semibold text-gray-800 dark:text-white">Pelacakan Tiket & Hasil KRK</h4>
                <p class="text-gray-600 dark:text-gray-300">
                  Setelah berkas dikirim, permohonan KRK akan diproses oleh DPUPR. Pemohon memperoleh kode tiket pelacakan, dan hasil KRK bisa didapatkan dalam bentuk softcopy maupun fisik setelah ditandatangani secara elektronik.
                </p>
              </div>
            </div>
          </div>
          <!-- Gambar Peta -->
          <div class="flex-1 flex items-center justify-center">
            <img 
              src="<?= base_url('assets/img/mapping.png') ?>"
              alt="Gambar Peta Zonasi"
              class="rounded-xl shadow-lg w-full max-w-md object-cover bg-gray-200 dark:bg-gray-700 cursor-zoom-in transition duration-200"
              loading="lazy"
              id="peta-image"
              style="aspect-ratio: 16/9;"
              tabindex="0"
              onclick="showPetaModal()"
            />
          </div>
          <!-- Modal for full screen map image -->
          <div id="peta-modal" class="fixed inset-0 bg-black/80 z-50 flex items-center justify-center hidden">
            <span class="absolute top-5 right-7 text-white text-4xl cursor-pointer z-60" onclick="closePetaModal()" id="peta-modal-close">&times;</span>
            <img
              src="<?= base_url('assets/img/mapping.png') ?>"
              alt="Full Gambar Peta Zonasi"
              class="max-h-[90vh] max-w-[95vw] mx-auto rounded shadow-2xl object-contain"
              style="display: block;"
            />
          </div>
        </div>
      </div>
    
    </section>

    <!-- Map Section -->
    <section
      id="peta"
      class="py-16 bg-gray-100 dark:bg-gray-900 transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-white">
            Peta Zonasi Wilayah dan Bangunan
          </h2>
          <p class="text-lg text-gray-600 dark:text-gray-300">
            Klik pada peta untuk melihat informasi zonasi dan perhitungan luas
            bangunan yang diizinkan
          </p>
        </div>

        <div
          class="relative rounded-xl overflow-hidden shadow-xl"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <!-- Map Container -->
          <div id="map" class="map-container"></div>

          <!-- fullscreen button -->
          <button id="map-fullscreen-btn" onclick="toggleMapFullscreen()"
            style="position:absolute;top:10px;left:10px;z-index:1001;background:white;border:none;
                  border-radius:4px;padding:6px 10px;cursor:pointer;box-shadow:0 1px 4px rgba(0,0,0,0.2);
                  font-size:14px;" title="Fullscreen">
            <i class="fas fa-expand" id="map-fullscreen-icon"></i>
          </button>

          <!-- Sidebar Controls -->
          <div class="sidebar">
            <h3 class="text-lg font-bold mb-4 text-gray-800 dark:text-white">
              Kontrol Peta
            </h3>

            <div class="mb-4">
              <label
                class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                >Koordinat Manual</label
              >
              <div class="flex space-x-2">
                <input
                  type="text"
                  id="lat-input"
                  placeholder="Latitude"
                  class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white"
                />
                <input
                  type="text"
                  id="lng-input"
                  placeholder="Longitude"
                  class="w-full p-2 border border-gray-300 dark:border-gray-600 rounded dark:bg-gray-700 dark:text-white"
                />
              </div>
              <button
                id="go-to-coords"
                class="w-full mt-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors"
              >
                Tampilkan
              </button>
            </div>

            <div class="mb-4">
              <label
                class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300"
                >Layer Zonasi</label
              >
              <div class="space-y-2">
                <label class="flex items-center">
                  <input
                    type="checkbox"
                    id="zona-residential"
                    class="mr-2"
                    checked
                  />
                  <span class="text-sm text-gray-700 dark:text-gray-300"
                    >Zona Perumahan</span
                  >
                </label>
                <label class="flex items-center">
                  <input
                    type="checkbox"
                    id="zona-commercial"
                    class="mr-2"
                    checked
                  />
                  <span class="text-sm text-gray-700 dark:text-gray-300"
                    >Zona Komersial</span
                  >
                </label>
                <label class="flex items-center">
                  <input
                    type="checkbox"
                    id="zona-industrial"
                    class="mr-2"
                    checked
                  />
                  <span class="text-sm text-gray-700 dark:text-gray-300"
                    >Zona Industri</span
                  >
                </label>
              </div>
            </div>

            <div class="flex space-x-2">
              <button
                id="calculate-area"
                class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded transition-colors"
              >
                Hitung Luas
              </button>
              <button
                id="reset-map"
                class="flex-1 bg-gray-600 hover:bg-gray-700 text-white py-2 px-4 rounded transition-colors"
              >
                Reset
              </button>
            </div>
          </div>

          <!-- Info Panel -->
          <div id="info-panel" class="info-panel hidden">
            <h3 class="text-lg font-bold mb-2 text-gray-800 dark:text-white">
              Informasi Zona
            </h3>
            <div id="zone-info" class="text-sm">
              <p>Klik pada peta untuk melihat informasi zona</p>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Zoning Info Section -->
    <section id="aturan" class="py-16 bg-white dark:bg-gray-800 transition-all">
      <div class="container mx-auto px-4">
        <div class="text-center mb-10" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-white">
            Informasi Zonasi
          </h2>
          <p class="text-lg text-gray-600 dark:text-gray-300">
            Aturan koefisien dasar bangunan (KDB) dan luas maksimum yang
            diizinkan
          </p>
        </div>

        <div
          class="overflow-x-auto rounded-lg shadow-md"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <table class="min-w-full table-auto">
            <thead class="bg-gray-200 dark:bg-gray-700">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider"
                >
                  <i class="fas fa-map-marker-alt mr-2"></i> Kategori Kawasan
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider"
                >
                  <i class="fas fa-list mr-2"></i> Sub Kategori / Jenis
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-700 dark:text-gray-300 uppercase tracking-wider"
                >
                  <i class="fas fa-info-circle mr-2"></i> Keterangan
                </th>
              </tr>
            </thead>
            <tbody
              class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700"
            >
              <!-- KAWASAN LINDUNG -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-700 dark:text-green-300">
                  <b>Kawasan Lindung</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  hutan lindung, resapan air, mangrove, sempadan danau, CA (cagar alam)
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Kawasan yang berfungsi menjaga kelestarian lingkungan, termasuk hutan lindung, area resapan air, vegetasi mangrove, kawasan sekitar danau, dan cagar alam yang dilindungi sesuai aturan zonasi.
                </td>
              </tr>
              <!-- KAWASAN BUDIDAYA -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-amber-800 dark:text-yellow-300">
                  <b>Kawasan Budidaya</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  industri, pertambangan, peternakan, floriculture, kaw budidaya LB, kaw budidaya LK, kaw budidaya TT, PLTP, PT PGE LHD
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Zona yang digunakan untuk kegiatan produktif seperti industri, budidaya tanaman, peternakan, tambang, serta pengembangan energi panas bumi.
                </td>
              </tr>
              <!-- KAWASAN INFRASTRUKTUR & UTILITAS -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-blue-700 dark:text-blue-300">
                  <b>Kawasan Infrastruktur & Utilitas</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  terminal, SPBU, TPA, jalan arteri, jalan kolektor, jembatan, resting area, kantor AP2B
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Kawasan untuk sarana prasarana transportasi, jaringan jalan, fasilitas energi, utilitas publik, dan pengelolaan sampah.
                </td>
              </tr>
              <!-- KAWASAN SOSIAL & PELAYANAN UMUM -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-pink-700 dark:text-pink-300">
                  <b>Kawasan Sosial & Pelayanan Umum</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  gereja, pendidikan, perkantoran, perdagangan, RS, peribadatan, pus info GG
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Wilayah untuk pelayanan masyarakat seperti peribadatan, sekolah, perkantoran, fasilitas kesehatan, dan pusat informasi.
                </td>
              </tr>
              <!-- KAWASAN KHUSUS / ALAM / GEOWISATA -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-purple-700 dark:text-purple-300">
                  <b>Kawasan Khusus / Alam / Geowisata</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  amphitheater, cagar budaya, danau, kawah, solfatara, kolam
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Daerah yang memiliki nilai wisata alam, budaya, geologi, dan rekreasi. Termasuk cagar budaya, kawah vulkanik, area solfatara, dan kolam rekreasi.
                </td>
              </tr>
              <!-- KAWASAN PERMUKIMAN & UMUM -->
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-sky-700 dark:text-sky-300">
                  <b>Kawasan Permukiman & Umum</b>
                </td>
                <td class="px-6 py-4 text-sm text-gray-800 dark:text-gray-200">
                  permukiman, kampung, kampung hindu, makam, pemakaman, perkuburan, taman kota, RTH, lapangan
                </td>
                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300">
                  Kawasan permukiman masyarakat dan ruang terbuka publik seperti taman kota, RTH, lapangan, serta area pemakaman.
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </section>

    <!-- SOP (Standard Operating Procedure) Section -->
    <section
      id="sop"
      class="py-16 bg-white dark:bg-gray-800 transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-6 text-gray-800 dark:text-white">
            Alur SOP Layanan KRK
          </h2>
          <p class="text-lg text-gray-600 dark:text-gray-300">
            Berikut adalah prosedur/SOP pengajuan Keterangan Rencana Kota (KRK) melalui Sistem SATRIA.<br>
            Silakan simak gambar alur berikut:
          </p>
        </div>

        

<div class="flow-wrap">

  <!-- Phase: Pemohon -->
  <div class="phase-sep">Fase 1</div>

  <div class="step">
    <div class="step-num teal">1</div>
    <div class="step-body teal">
      <h3>Pemohon Memasaukan Berkas di DPUPR</h3>
      <p>Berkas yang di masukkan berupa : Formulir Permohonana, Fc/Scan KTP, Dokumen Lahan, Sketsa Denah Lokasi, Titik Kordinat dan Bukti Lunas PBB </p>
    </div>
  </div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-line" style="margin:0 auto"></div></div></div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-arrow"></div></div></div>

  <div class="step">
    <div class="step-num teal">2</div>
    <div class="step-body teal">
      <h3>Berkas/Data Masuk di DPUPRD Pada Bidang Tata Ruang</h3>
      <p>Setelah itu tim persiapan untuk survey lokasi</p>
    </div>
  </div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-line" style="margin:0 auto"></div></div></div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-arrow"></div></div></div>

  <!-- Phase: Sistem -->
  <div class="phase-sep">Fase 2</div>

  <div class="step">
    <div class="step-num purple">3</div>
    <div class="step-body purple">
      <h3>Survey Lokasi</h3>
      <p>Tim PUPR bidang tata ruang survey lokasi untuk pemgambilan titik koordinat lahan dan dokumentasi kondisi eksisting</p>
    </div>
  </div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-line" style="margin:0 auto"></div></div></div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-arrow"></div></div></div>

  <div class="step">
    <div class="step-num purple">4</div>
    <div class="step-body purple">
      <h3>Buat KRK</h3>
      <p>Tim PUPR bidang tata ruang memebuat peta hasil survey dan membuat dokumen KRK</p>
    </div>
  </div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-line" style="margin:0 auto"></div></div></div>
  <div class="connector"><div class="conn-dot-col"><div class="conn-arrow"></div></div></div>

  <!-- Phase: Pengajuan -->
  <div class="phase-sep">Fase 3</div>

  <div class="step">
    <div class="step-num teal">5</div>
    <div class="step-body teal">
      <h3>KRK Selesai</h3>
      <p>KRK Selesai dibuat dan diserahkan kepada pemohon secara fisik atau dikirim pdf.</p>
    </div>
  </div>

        <div class="flex justify-center mb-10" data-aos="zoom-in" data-aos-delay="100">
          <div class="w-full max-w-xl md:max-w-2xl lg:max-w-3xl rounded-lg overflow-hidden shadow-lg bg-white dark:bg-gray-900">


            <img
              src="<?=base_url('assets/img/satria-sop.jpeg')?>"
              alt="Alur SOP Layanan KRK"
              class="w-full max-h-[500px] md:max-h-[400px] object-contain mx-auto cursor-zoom-in transition duration-200"
              style="aspect-ratio: 16/9;"
              loading="lazy"
              id="sop-image"
              onclick="showSopModal()"
              tabindex="0"
            />
          </div>
        </div>
        <!-- Modal for full screen image -->
        <div id="sop-modal" class="fixed inset-0 bg-black/80 z-50 items-center justify-center hidden">
          <span class="absolute top-5 right-7 text-white text-4xl cursor-pointer z-60" onclick="closeSopModal()" id="sop-modal-close">&times;</span>
          <img
            src="<?=base_url('assets/img/satria-sop.jpeg')?>"
            alt="Alur SOP Layanan KRK Full"
            class="max-h-[90vh] max-w-[95vw] mx-auto rounded shadow-2xl object-contain"
            style="display: block;"
          />
        </div>

        <div class="flex flex-col items-center">
          <div class="mt-6 flex justify-center" data-aos="fade-up" data-aos-delay="400">
            <a
              href="<?=base_url('assets/img/satria-sop.jpeg')?>"
              target="_blank"
              class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg transition-transform duration-200 gap-3"
              download
            >
              <i class="fas fa-download text-lg"></i>
              Unduh Gambar SOP
            </a>
          </div>
        </div>
      </div>
    </section>

    <!-- Contact Section -->
    <section
      id="kontak"
      class="py-16 bg-gradient-to-r from-blue-500 to-purple-600 text-white"
    >
      <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto text-center mb-12" data-aos="fade-up">
          <h2 class="text-3xl font-bold mb-6">Kontak & Dukungan</h2>
          <p class="text-lg opacity-90">
            Hubungi kami untuk informasi lebih lanjut tentang sistem GIS dan
            perencanaan pembangunan
          </p>
        </div>

        <div
          class="grid grid-cols-1 md:grid-cols-2 gap-8 max-w-4xl mx-auto"
          data-aos="fade-up"
          data-aos-delay="200"
        >
          <!-- Contact Info -->
          <div class="bg-white/10 backdrop-blur-sm p-8 rounded-xl">
            <h3 class="text-xl font-bold mb-6">Informasi Kontak</h3>

            <div class="space-y-4">
              <div class="flex items-start">
                <i class="fas fa-map-marker-alt mt-1 mr-4 text-blue-300"></i>
                <div>
                  <h4 class="font-medium">Alamat Kantor</h4>
                  <p class="opacity-90">
                    8R65+FGJ, Woloan Satu, Kec. Tomohon Bar., Kota Tomohon, Sulawesi Utara
                  </p>
                </div>
              </div>

              <div class="flex items-start">
                <i class="fas fa-phone mt-1 mr-4 text-blue-300"></i>
                <div>
                  <h4 class="font-medium">Telepon</h4>
                  <p class="opacity-90">(0431) 123-456</p>
                </div>
              </div>

              <div class="flex items-start">
                <i class="fab fa-whatsapp mt-1 mr-4 text-blue-300"></i>
                <div>
                  <h4 class="font-medium">WhatsApp</h4>
                  <p class="opacity-90">+62 812 3456 7890</p>
                </div>
              </div>
            </div>

            <div class="mt-8">
              <h4 class="font-medium mb-4">Ikuti Kami</h4>
              <div class="flex space-x-4">
                <a
                  href="#"
                  class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors"
                >
                  <i class="fab fa-facebook-f"></i>
                </a>
                <a
                  href="#"
                  class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors"
                >
                  <i class="fa-brands fa-x-twitter"></i>
                </a>
                <a
                  href="#"
                  class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors"
                >
                  <i class="fab fa-instagram"></i>
                </a>
                <a
                  href="#"
                  class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center hover:bg-white/30 transition-colors"
                >
                  <i class="fab fa-youtube"></i>
                </a>
              </div>
            </div>
          </div>

          <!-- Contact Form -->
          <div class="bg-white/10 backdrop-blur-sm p-8 rounded-xl">
            <h3 class="text-xl font-bold mb-6">Kirim Pesan</h3>

            <form class="space-y-4">
              <div>
                <label class="block text-sm font-medium mb-1"
                  >Nama Lengkap</label
                >
                <input
                  type="text"
                  class="w-full p-3 bg-white/20 border border-white/30 rounded text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-300"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Email</label>
                <input
                  type="email"
                  class="w-full p-3 bg-white/20 border border-white/30 rounded text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-300"
                />
              </div>

              <div>
                <label class="block text-sm font-medium mb-1">Pesan</label>
                <textarea
                  rows="4"
                  class="w-full p-3 bg-white/20 border border-white/30 rounded text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-blue-300"
                ></textarea>
              </div>

              <button
                type="submit"
                class="w-full bg-white text-blue-600 font-bold py-3 px-4 rounded hover:bg-blue-50 transition-colors"
              >
                Kirim Pesan
              </button>
            </form>
          </div>
        </div>
      </div>
    </section>
<?=$this->endSection() ?>