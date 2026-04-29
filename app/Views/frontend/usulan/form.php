<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Form Usulan Wilayah - KRK Kota Tomohon</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Mapbox GL JS -->
    <link
      href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css"
      rel="stylesheet"
    />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>
    <!-- Mapbox Draw -->
    <link
      href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.css"
      rel="stylesheet"
    />
    <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-draw/v1.4.3/mapbox-gl-draw.js"></script>
    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />
    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <style>
      :root {
        --primary-red: #ef4444;
        --primary-purple: #7c3aed;
        --primary-blue: #3b82f6;
        --light-blue: #f0f9ff;
        --dark-bg: #111827;
      }
      /* keep original styles unchanged.... */
      .gradient-bg {
        background: linear-gradient(
          135deg,
          var(--primary-red),
          var(--primary-purple),
          var(--primary-blue)
        );
        background-size: 200% 200%;
        animation: gradient 15s ease infinite;
      }
      @keyframes gradient {
        0% {
          background-position: 0% 50%;
        }
        50% {
          background-position: 100% 50%;
        }
        100% {
          background-position: 0% 50%;
        }
      }
      .btn-gradient {
        background: linear-gradient(
          90deg,
          var(--primary-red),
          var(--primary-purple),
          var(--primary-blue)
        );
        transition: all 0.3s ease;
      }
      .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }
      .map-container {
        height: 500px;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        position: relative;
      }
      #map {
        height: 100%;
        width: 100%;
      }
      .mapboxgl-ctrl-top-right {
        top: 10px;
        right: 10px;
      }
      .drawing-controls {
        position: absolute;
        top: 10px;
        left: 10px;
        background: white;
        padding: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        display: flex;
        gap: 8px;
      }
      .drawing-controls button {
        padding: 8px 12px;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
      }
      .drawing-controls button:hover {
        transform: translateY(-1px);
      }
      .info-panel {
        position: absolute;
        bottom: 10px;
        left: 10px;
        background: white;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        z-index: 1000;
        max-width: 300px;
      }
      .form-section {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        padding: 24px;
        margin-bottom: 24px;
        transition: all 0.3s ease;
      }
      .form-section:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
      }
      .step-indicator {
        display: flex;
        justify-content: space-between;
        margin-bottom: 32px;
        position: relative;
      }
      .step-indicator::before {
        content: "";
        position: absolute;
        top: 20px;
        left: 0;
        right: 0;
        height: 2px;
        background: #e5e7eb;
        z-index: 1;
      }
      .step {
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        z-index: 2;
      }
      .step-number {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e5e7eb;
        color: #6b7280;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-bottom: 8px;
        transition: all 0.3s ease;
      }
      .step.active .step-number {
        background: linear-gradient(
          135deg,
          var(--primary-red),
          var(--primary-purple)
        );
        color: white;
      }
      .step.completed .step-number {
        background: #10b981;
        color: white;
      }
      .step-label {
        font-size: 14px;
        color: #6b7280;
        text-align: center;
      }
      .step.active .step-label {
        color: #111827;
        font-weight: 600;
      }
      .area-visualization {
        height: 200px;
        background: linear-gradient(135deg, #f0f9ff, #e0f2fe);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-top: 16px;
        position: relative;
        overflow: hidden;
      }
      .building-outline {
        width: 80%;
        height: 60%;
        border: 2px dashed #3b82f6;
        position: relative;
      }
      .building-dimensions {
        position: absolute;
        background: rgba(255, 255, 255, 0.8);
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 12px;
      }
      .length-label {
        bottom: -25px;
        left: 50%;
        transform: translateX(-50%);
      }
      .width-label {
        right: -40px;
        top: 50%;
        transform: translateY(-50%) rotate(90deg);
      }
      .floating-label {
        position: relative;
        margin-bottom: 24px;
      }
      .floating-label input,
      .floating-label select,
      .floating-label textarea {
        width: 100%;
        padding: 16px;
        border: 1px solid #d1d5db;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
      }
      .floating-label input:focus,
      .floating-label select:focus,
      .floating-label textarea:focus {
        outline: none;
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
      }
      .floating-label label {
        position: absolute;
        top: 16px;
        left: 16px;
        color: #6b7280;
        transition: all 0.3s ease;
        pointer-events: none;
        background: white;
        padding: 0 4px;
      }
      .floating-label input:focus + label,
      .floating-label input:not(:placeholder-shown) + label,
      .floating-label select:focus + label,
      .floating-label select:not([value=""]):valid + label,
      .floating-label textarea:focus + label,
      .floating-label textarea:not(:placeholder-shown) + label {
        top: -8px;
        left: 12px;
        font-size: 12px;
        color: #3b82f6;
      }
      .file-upload {
        border: 2px dashed #d1d5db;
        border-radius: 8px;
        padding: 32px;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
      }
      .file-upload:hover {
        border-color: #3b82f6;
        background: #f0f9ff;
      }
      .file-upload i {
        font-size: 48px;
        color: #9ca3af;
        margin-bottom: 16px;
      }
      .file-upload.dragover {
        border-color: #3b82f6;
        background: #eff6ff;
      }
      .summary-card {
        background: #f8fafc;
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 16px;
      }
      .summary-card h4 {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 4px;
      }
      .summary-card p {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
      }
      .pulse-animation {
        animation: pulse 2s infinite;
      }
      @keyframes pulse {
        0% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.05);
        }
        100% {
          transform: scale(1);
        }
      }
      .fade-in {
        animation: fadeIn 0.5s ease-in;
      }
      @keyframes fadeIn {
        from {
          opacity: 0;
          transform: translateY(10px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }
      .mapboxgl-ctrl-group {
        border-radius: 8px !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1) !important;
      }
      .loading-map {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        background: #f8fafc;
        color: #6b7280;
        font-size: 18px;
      }
      .zone-info-popup {
        max-width: 250px;
      }
      .zone-info-popup h3 {
        font-weight: bold;
        margin-bottom: 8px;
        color: #1f2937;
      }
      .zone-info-popup p {
        margin-bottom: 4px;
        color: #4b5563;
      }
    </style>
  </head>
  <body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white py-6 shadow-lg">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="flex items-center space-x-3 mb-4 md:mb-0">
            <i class="fas fa-map-marked-alt text-3xl"></i>
            <div>
              <h1 class="text-2xl font-bold">Form Usulan Wilayah KRK</h1>
              <p class="text-blue-100">
                Berdasarkan RTRW Pemerintah Kota Tomohon
              </p>
            </div>
          </div>
          <div class="flex items-center space-x-4">
            <button
              id="theme-toggle"
              class="bg-white/20 hover:bg-white/30 w-10 h-10 rounded-full flex items-center justify-center transition-colors"
            >
              <i class="fas fa-sun"></i>
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Progress Steps -->
    <div class="container mx-auto px-4 py-8">
      <div class="step-indicator">
        <div class="step active" data-step="1">
          <div class="step-number">1</div>
          <div class="step-label">Data Pemohon</div>
        </div>
        <div class="step" data-step="2">
          <div class="step-number">2</div>
          <div class="step-label">Lokasi & Zonasi</div>
        </div>
        <div class="step" data-step="3">
          <div class="step-number">3</div>
          <div class="step-label">Rencana Bangunan</div>
        </div>
        <div class="step" data-step="4">
          <div class="step-number">4</div>
          <div class="step-label">Dokumen Pendukung</div>
        </div>
        <div class="step" data-step="5">
          <div class="step-number">5</div>
          <div class="step-label">Ringkasan & Kirim</div>
        </div>
      </div>

      <!-- Form Container -->
      <div class="max-w-6xl mx-auto">
        <!-- Step 1: Data Pemohon (modifikasi) -->
        <div id="step-1" class="form-section fade-in">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <span
              class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3"
              >1</span
            >
            Data Pemohon
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="floating-label">
              <input type="text" id="nama" placeholder=" " required />
              <label for="nama">Nama Lengkap Pemohon</label>
            </div>
            <div class="floating-label">
              <input
                type="text"
                id="nik"
                placeholder=" "
                required
                pattern="\d{16}"
              />
              <label for="nik">Nomor Induk Kependudukan (16 digit)</label>
            </div>
            <div class="floating-label">
              <input type="text" id="alamat" placeholder=" " required />
              <label for="alamat">Alamat Tempat Tinggal</label>
            </div>
            <div class="floating-label">
              <input
                type="tel"
                id="telepon"
                placeholder=" "
                required
                pattern="^(\+62|62|0)8[1-9][0-9]{6,9}$"
              />
              <label for="telepon">No. HP (format Indonesia)</label>
            </div>
            <div class="floating-label">
              <input type="email" id="email" placeholder=" " required />
              <label for="email">Alamat Email (diisi aktif)</label>
            </div>
            <div class="floating-label">
              <select id="jenis-pemohon" required>
                <option value=""></option>
                <option value="perorangan">Perorangan</option>
                <option value="perusahaan">Perusahaan/Badan Usaha</option>
                <option value="instansi">Instansi Pemerintah</option>
                <option value="yayasan">Yayasan</option>
              </select>
              <label for="jenis-pemohon">Kategori Pemohon</label>
            </div>
          </div>
          <div class="flex justify-between mt-8">
            <div></div>
            <button
              class="next-step btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg"
            >
              Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!-- Step 2: Lokasi & Zonasi (tidak diubah) -->
        <div id="step-2" class="form-section hidden fade-in">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <span
              class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3"
              >2</span
            >
            Lokasi & Zonasi
          </h2>
          <div class="mb-6">
            <div class="map-container relative">
              <div id="map">
                <div class="loading-map">
                  <i class="fas fa-spinner fa-spin mr-2"></i> Memuat peta...
                </div>
              </div>
              <div class="drawing-controls">
                <button
                  id="draw-polygon"
                  class="bg-blue-600 hover:bg-blue-700 text-white"
                >
                  <i class="fas fa-draw-polygon"></i> Gambar Area
                </button>
                <button
                  id="clear-drawing"
                  class="bg-red-600 hover:bg-red-700 text-white"
                >
                  <i class="fas fa-eraser"></i> Hapus
                </button>
              </div>
              <div id="map-info" class="info-panel">
                <h3 class="font-bold mb-2">Informasi Zona</h3>
                <p id="zone-details">
                  Klik pada peta untuk melihat informasi zona
                </p>
              </div>
            </div>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="floating-label">
              <input type="text" id="alamat-lokasi" placeholder=" " required />
              <label for="alamat-lokasi">Alamat Lokasi Tanah</label>
            </div>
            <div class="floating-label">
              <input type="text" id="kelurahan" placeholder=" " required />
              <label for="kelurahan">Kelurahan</label>
            </div>
            <div class="floating-label">
              <input
                type="text"
                id="kecamatan"
                name="kecamatan"
                placeholder=""
                readonly
              />
              <label for="kecamatan">Kecamatan</label>
            </div>
            <div class="floating-label">
              <input type="text" id="koordinat" placeholder=" " readonly />
              <label for="koordinat">Koordinat (Lat, Lng)</label>
            </div>
            <div class="floating-label">
              <input type="text" id="luas-tanah" placeholder=" " readonly />
              <label for="luas-tanah">Luas Tanah (m²)</label>
            </div>
            <div class="floating-label">
              <input type="text" id="zona" placeholder=" " readonly />
              <label for="zona">Zona RTRW</label>
            </div>
          </div>
          <div class="flex justify-between mt-8">
            <button
              class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors"
            >
              <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
            </button>
            <button
              class="next-step btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg"
            >
              Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!-- Step 3: Rencana Bangunan (modifikasi label) -->
        <div id="step-3" class="form-section hidden fade-in">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <span
              class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3"
              >3</span
            >
            Rencana Bangunan
          </h2>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="floating-label">
              <input type="text" id="jenis-bangunan" placeholder=" " required />
              <label for="jenis-bangunan">Jenis / Fungsi Bangunan</label>
            </div>
            <div class="floating-label">
              <input
                type="number"
                id="tinggi-bangunan"
                placeholder=" "
                min="1"
                required
              />
              <label for="tinggi-bangunan">Tinggi Bangunan / Atap (m)</label>
            </div>
            <div class="floating-label">
              <input
                type="number"
                id="luas-bangunan"
                placeholder=" "
                min="1"
                required
              />
              <label for="luas-bangunan"
                >Luas Bangunan yang Diusulkan (m²)</label
              >
            </div>
            <div class="floating-label">
              <input
                type="number"
                id="jumlah-lantai"
                placeholder=" "
                min="1"
                required
              />
              <label for="jumlah-lantai">Jumlah Lantai Bangunan</label>
            </div>
            <div class="floating-label">
              <input type="number" id="kdb" placeholder=" " readonly />
              <label for="kdb">KDB (Koefisien Dasar Bangunan)</label>
            </div>
            <div class="floating-label">
              <input type="number" id="klb" placeholder=" " readonly />
              <label for="klb">KLB (Koefisien Lantai Bangunan)</label>
            </div>
          </div>
          <div class="mt-6">
            <h3 class="text-lg font-semibold mb-4">
              Visualisasi Luas Bangunan
            </h3>
            <div class="area-visualization">
              <div class="building-outline">
                <div class="building-dimensions length-label" id="length-label">
                  Panjang: - m
                </div>
                <div class="building-dimensions width-label" id="width-label">
                  Lebar: - m
                </div>
              </div>
            </div>
          </div>
          <div class="mt-6 bg-blue-50 p-4 rounded-lg">
            <h3 class="font-semibold text-blue-800 mb-2">Informasi Zonasi</h3>
            <p class="text-blue-700 text-sm" id="zona-info">
              Setelah menentukan lokasi, informasi zonasi akan ditampilkan di
              sini
            </p>
          </div>
          <div class="flex justify-between mt-8">
            <button
              class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors"
            >
              <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
            </button>
            <button
              class="next-step btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg"
            >
              Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!-- Step 4: Dokumen Pendukung (tidak diubah) -->
        <div id="step-4" class="form-section hidden fade-in">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <span
              class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3"
              >4</span
            >
            Dokumen Pendukung
          </h2>
          <div class="space-y-6">
            <div class="file-upload" id="sertifikat-upload">
              <i class="fas fa-file-contract"></i>
              <h3 class="font-semibold mb-2">Sertifikat Tanah</h3>
              <p class="text-gray-600 mb-4">
                Unggah scan sertifikat tanah (PDF, JPG, PNG)
              </p>
              <input
                type="file"
                id="sertifikat"
                class="hidden"
                accept=".pdf,.jpg,.jpeg,.png"
              />
              <button
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors"
              >
                Pilih File
              </button>
              <p id="sertifikat-name" class="mt-2 text-sm text-gray-500"></p>
            </div>
            <div class="file-upload" id="ktp-upload">
              <i class="fas fa-id-card"></i>
              <h3 class="font-semibold mb-2">KTP Pemohon</h3>
              <p class="text-gray-600 mb-4">Unggah scan KTP (JPG, PNG)</p>
              <input
                type="file"
                id="ktp"
                class="hidden"
                accept=".jpg,.jpeg,.png"
              />
              <button
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors"
              >
                Pilih File
              </button>
              <p id="ktp-name" class="mt-2 text-sm text-gray-500"></p>
            </div>
            <div class="file-upload" id="gambar-upload">
              <i class="fas fa-drafting-compass"></i>
              <h3 class="font-semibold mb-2">Gambar Rencana</h3>
              <p class="text-gray-600 mb-4">
                Unggah gambar rencana bangunan (PDF, JPG, PNG)
              </p>
              <input
                type="file"
                id="gambar"
                class="hidden"
                accept=".pdf,.jpg,.jpeg,.png"
              />
              <button
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors"
              >
                Pilih File
              </button>
              <p id="gambar-name" class="mt-2 text-sm text-gray-500"></p>
            </div>
            <div class="file-upload" id="lainnya-upload">
              <i class="fas fa-folder-open"></i>
              <h3 class="font-semibold mb-2">Dokumen Pendukung Lainnya</h3>
              <p class="text-gray-600 mb-4">
                Unggah dokumen pendukung lainnya (PDF, JPG, PNG) - Opsional
              </p>
              <input
                type="file"
                id="lainnya"
                class="hidden"
                accept=".pdf,.jpg,.jpeg,.png"
              />
              <button
                class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded transition-colors"
              >
                Pilih File
              </button>
              <p id="lainnya-name" class="mt-2 text-sm text-gray-500"></p>
            </div>
          </div>
          <div class="flex justify-between mt-8">
            <button
              class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors"
            >
              <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
            </button>
            <button
              class="next-step btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg"
            >
              Selanjutnya <i class="fas fa-arrow-right ml-2"></i>
            </button>
          </div>
        </div>

        <!-- Step 5... (tidak diubah, kecuali minor perbaikan label/field jika perlu) -->
        <div id="step-5" class="form-section hidden fade-in">
          <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center">
            <span
              class="w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mr-3"
              >5</span
            >
            Ringkasan & Kirim
          </h2>
          <div class="bg-blue-50 p-6 rounded-lg mb-6">
            <h3 class="text-lg font-semibold text-blue-800 mb-4">
              Konfirmasi Data Usulan
            </h3>
            <p class="text-blue-700">
              Silakan periksa kembali data yang telah Anda masukkan sebelum
              mengirimkan formulir.
            </p>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                Data Pemohon
              </h3>
              <div class="space-y-4">
                <div class="summary-card">
                  <h4>Nama Lengkap</h4>
                  <p id="summary-nama">-</p>
                </div>
                <div class="summary-card">
                  <h4>NIK</h4>
                  <p id="summary-nik">-</p>
                </div>
                <div class="summary-card">
                  <h4>Alamat</h4>
                  <p id="summary-alamat">-</p>
                </div>
                <div class="summary-card">
                  <h4>No. Telepon</h4>
                  <p id="summary-telepon">-</p>
                </div>
              </div>
            </div>
            <div>
              <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                Lokasi & Bangunan
              </h3>
              <div class="space-y-4">
                <div class="summary-card">
                  <h4>Alamat Lokasi</h4>
                  <p id="summary-alamat-lokasi">-</p>
                </div>
                <div class="summary-card">
                  <h4>Koordinat</h4>
                  <p id="summary-koordinat">-</p>
                </div>
                <div class="summary-card">
                  <h4>Luas Tanah</h4>
                  <p id="summary-luas-tanah">- m²</p>
                </div>
                <div class="summary-card">
                  <h4>Luas Bangunan</h4>
                  <p id="summary-luas-bangunan">- m²</p>
                </div>
              </div>
            </div>
          </div>
          <div
            class="mt-8 bg-yellow-50 p-4 rounded-lg border border-yellow-200"
          >
            <div class="flex items-start">
              <i
                class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-3"
              ></i>
              <div>
                <h4 class="font-semibold text-yellow-800">Pernyataan</h4>
                <p class="text-yellow-700 text-sm mt-1">
                  Saya menyatakan bahwa data yang saya berikan adalah benar dan
                  sah. Saya bersedia menerima konsekuensi hukum jika data yang
                  diberikan ternyata tidak benar.
                </p>
                <div class="mt-3">
                  <label class="flex items-center">
                    <input type="checkbox" id="pernyataan" class="mr-2" />
                    <span class="text-sm text-yellow-800"
                      >Saya menyetujui pernyataan di atas</span
                    >
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-between mt-8">
            <button
              class="prev-step bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors"
            >
              <i class="fas fa-arrow-left mr-2"></i>Sebelumnya
            </button>
            <button
              id="submit-form"
              class="btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg opacity-50 cursor-not-allowed"
              disabled
            >
              <i class="fas fa-paper-plane mr-2"></i>Kirim Usulan
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Success Modal -->
    <div
      id="success-modal"
      class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden"
    >
      <div class="bg-white rounded-xl p-8 max-w-md w-full mx-4 text-center">
        <div
          class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4"
        >
          <i class="fas fa-check text-green-500 text-2xl"></i>
        </div>
        <h3 class="text-2xl font-bold text-gray-800 mb-2">Usulan Terkirim!</h3>
        <p class="text-gray-600 mb-6">
          Formulir usulan wilayah KRK Anda telah berhasil dikirim. Tim kami akan
          memproses dalam 3-5 hari kerja.
        </p>
        <div class="bg-gray-100 p-4 rounded-lg mb-6">
          <p class="text-sm text-gray-700">
            Nomor Tiket: <span class="font-mono font-bold">KRK-2023-0876</span>
          </p>
        </div>
        <div class="flex space-x-3">
          <a
            href="<?=base_url('')?>"
            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-3 px-4 rounded-lg transition-colors text-center"
          >
            Kembali ke Beranda
          </a>
          <button
            id="print-ticket"
            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 py-3 px-4 rounded-lg transition-colors"
          >
            Cetak Tiket
          </button>
        </div>
      </div>
    </div>

    <script>
      // Initialize AOS
      AOS.init({
        duration: 800,
        once: true,
      });

      // Mapbox Access Token (Ganti dengan token Anda)
      mapboxgl.accessToken =
        "pk.eyJ1IjoiZG9vbXNkYXJrIiwiYSI6ImNscjYyZ204eDI2dmoyaXRheGI1aTE1ajQifQ.6sV5MpXG0jYJRpd0cO8SzA";

      // Form navigation
      let currentStep = 1;
      const totalSteps = 5;

      // Show step function
      function showStep(step) {
        document.querySelectorAll(".form-section").forEach((section) => {
          section.classList.add("hidden");
        });
        document.getElementById(`step-${step}`).classList.remove("hidden");
        document.querySelectorAll(".step").forEach((stepEl, index) => {
          if (index + 1 < step) {
            stepEl.classList.remove("active");
            stepEl.classList.add("completed");
          } else if (index + 1 === step) {
            stepEl.classList.add("active");
            stepEl.classList.remove("completed");
          } else {
            stepEl.classList.remove("active", "completed");
          }
        });
        currentStep = step;
        if (step === 5) {
          updateSummary();
        }
        if (step === 2 && !window.mapInitialized) {
          initMap();
          window.mapInitialized = true;
        }
      }

      // Next & Previous step buttons
      document.querySelectorAll(".next-step").forEach((button) => {
        button.addEventListener("click", function () {
          if (validateStep(currentStep)) {
            showStep(currentStep + 1);
          }
        });
      });
      document.querySelectorAll(".prev-step").forEach((button) => {
        button.addEventListener("click", function () {
          showStep(currentStep - 1);
        });
      });

      // Validate step function
      function validateStep(step) {
        let isValid = true;
        if (step === 1) {
          const requiredFields = [
            "nama",
            "nik",
            "alamat",
            "telepon",
            "email",
            "jenis-pemohon",
          ];
          requiredFields.forEach((field) => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
              input.classList.add("border-red-500");
              isValid = false;
            } else {
              input.classList.remove("border-red-500");
            }
          });
        }
        if (step === 2) {
          const koordinat = document.getElementById("koordinat").value;
          if (!koordinat) {
            alert("Silakan tentukan lokasi pada peta terlebih dahulu");
            isValid = false;
          }
        }
        if (step === 3) {
          const requiredFields = [
            "jenis-bangunan",
            "tinggi-bangunan",
            "luas-bangunan",
            "jumlah-lantai",
          ];
          requiredFields.forEach((field) => {
            const input = document.getElementById(field);
            if (!input.value.trim()) {
              input.classList.add("border-red-500");
              isValid = false;
            } else {
              input.classList.remove("border-red-500");
            }
          });
        }
        if (step === 5) {
          const pernyataan = document.getElementById("pernyataan");
          if (!pernyataan.checked) {
            alert("Anda harus menyetujui pernyataan sebelum mengirim formulir");
            isValid = false;
          }
        }
        return isValid;
      }

      // Update summary function
      function updateSummary() {
        document.getElementById("summary-nama").textContent =
          document.getElementById("nama").value;
        document.getElementById("summary-nik").textContent =
          document.getElementById("nik").value;
        document.getElementById("summary-alamat").textContent =
          document.getElementById("alamat").value;
        document.getElementById("summary-telepon").textContent =
          document.getElementById("telepon").value;
        document.getElementById("summary-alamat-lokasi").textContent =
          document.getElementById("alamat-lokasi").value;
        document.getElementById("summary-koordinat").textContent =
          document.getElementById("koordinat").value;
        document.getElementById("summary-luas-tanah").textContent =
          document.getElementById("luas-tanah").value;
        document.getElementById("summary-luas-bangunan").textContent =
          document.getElementById("luas-bangunan").value;
      }

      // File upload functionality
      document.querySelectorAll(".file-upload").forEach((uploadArea) => {
        const input = uploadArea.querySelector('input[type="file"]');
        const button = uploadArea.querySelector("button");
        const fileName = uploadArea.querySelector("p:last-child");
        button.addEventListener("click", function (e) {
          e.preventDefault();
          input.click();
        });
        input.addEventListener("change", function () {
          if (this.files.length > 0) {
            fileName.textContent = this.files[0].name;
            uploadArea.classList.add("bg-green-50", "border-green-300");
          }
        });
        uploadArea.addEventListener("dragover", function (e) {
          e.preventDefault();
          uploadArea.classList.add("dragover");
        });
        uploadArea.addEventListener("dragleave", function () {
          uploadArea.classList.remove("dragover");
        });
        uploadArea.addEventListener("drop", function (e) {
          e.preventDefault();
          uploadArea.classList.remove("dragover");
          if (e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            fileName.textContent = e.dataTransfer.files[0].name;
            uploadArea.classList.add("bg-green-50", "border-green-300");
          }
        });
      });

      // Submit form
      document
        .getElementById("submit-form")
        .addEventListener("click", function () {
          if (validateStep(5)) {
            submitForm();
          }
        });

      // Close modal
      document
        .getElementById("print-ticket")
        .addEventListener("click", function () {
          window.print();
        });

      // Toggle submit button based on agreement
      document
        .getElementById("pernyataan")
        .addEventListener("change", function () {
          const submitButton = document.getElementById("submit-form");
          if (this.checked) {
            submitButton.disabled = false;
            submitButton.classList.remove("opacity-50", "cursor-not-allowed");
          } else {
            submitButton.disabled = true;
            submitButton.classList.add("opacity-50", "cursor-not-allowed");
          }
        });

      // Initialize Mapbox Map
      let map, draw;

      function initMap() {
        console.log("Initializing Mapbox map...");
        map = new mapboxgl.Map({
          container: "map",
          style: "mapbox://styles/mapbox/streets-v12",
          center: [124.8399, 1.3233],
          zoom: 13,
          attributionControl: false,
        });

        map.addControl(new mapboxgl.NavigationControl(), "top-right");
        map.addControl(
          new mapboxgl.ScaleControl({
            maxWidth: 100,
            unit: "metric",
          })
        );

        draw = new MapboxDraw({
          displayControlsDefault: false,
          controls: {
            polygon: true,
            trash: true,
          },
        });
        map.addControl(draw, "top-left");

        map.on("load", function () {
          const loadingElement = document.querySelector(".loading-map");
          if (loadingElement) {
            loadingElement.style.display = "none";
          }
          addZoningAndKawasanLayers();
        });

        map.on("draw.create", updateArea);
        map.on("draw.delete", updateArea);
        map.on("draw.update", updateArea);

        document
          .getElementById("draw-polygon")
          .addEventListener("click", function () {
            draw.changeMode("draw_polygon");
          });
        document
          .getElementById("clear-drawing")
          .addEventListener("click", function () {
            draw.deleteAll();
            updateArea();
          });

        document
          .getElementById("luas-bangunan")
          .addEventListener("input", function () {
            const luas = parseInt(this.value) || 0;
            const panjang = Math.sqrt(luas * 1.5);
            const lebar = luas / panjang;
            document.getElementById(
              "length-label"
            ).textContent = `Panjang: ${panjang.toFixed(1)} m`;
            document.getElementById(
              "width-label"
            ).textContent = `Lebar: ${lebar.toFixed(1)} m`;
            const buildingOutline = document.querySelector(".building-outline");
            const maxWidth = 80,
              maxHeight = 60;
            const scale = Math.min(0.3 + Math.log10(luas) * 0.2, 1);
            buildingOutline.style.width = `${maxWidth * scale}%`;
            buildingOutline.style.height = `${maxHeight * scale}%`;
          });

        console.log("Mapbox map initialized successfully");
      }

      let administrativeBoundaries = [];

      function findAdminInfoAt(lngLat) {
        if (!administrativeBoundaries || administrativeBoundaries.length === 0) return null;
        const pt = turf.point([lngLat.lng, lngLat.lat]);
        for (const feature of administrativeBoundaries) {
          if (feature.geometry && (feature.geometry.type === 'Polygon' || feature.geometry.type === 'MultiPolygon')) {
            if (turf.booleanPointInPolygon(pt, feature)) {
              if (feature.properties.WADMKC || feature.properties.WADMKD) {
                return feature.properties;
              }
            }
          }
        }
        return null;
      }

      function updateAdministrativeFields(lngLat) {
        const adminInfo = findAdminInfoAt(lngLat);
        if (adminInfo) {
          if (adminInfo.WADMKC) {
             document.getElementById('kecamatan').value = adminInfo.WADMKC;
             // Remove readonly if it was set, or keep it if we want to enforce auto-fill
             // User requested auto-fill, usually implies readonly or just auto-filled.
          }
          if (adminInfo.WADMKD) {
             document.getElementById('kelurahan').value = adminInfo.WADMKD;
          }
        }
      }

      /**
       * Load geojson file and tambahkan:
       * 1) Layer ZONASI (properties yg mengandung KUZ atau ZONA)
       * 2) Layer KAWASAN_ (properties yg mengandung KAWASAN_)
       */
      function addZoningAndKawasanLayers() {
        fetch("<?=base_url("assets/geojson/")?>geodata.geojson")
          .then((res) => {
            if (!res.ok) throw new Error("Gagal load GeoJSON zonasi");
            return res.json();
          })
          .then((geojson) => {
            administrativeBoundaries = geojson.features;
            // Ambil fitur zoning / KUZ ("KUZ", "ZONA", dll)
            const zoningFeatures = geojson.features.filter(
              (feat) =>
                feat.properties &&
                (String(feat.properties.KUZ || "").trim() !== "" ||
                  String(feat.properties.ZONA || "").trim() !== "" ||
                  String(feat.properties.zona || "").trim() !== "")
            );
            // Beri warna default jika belum ada pada feature zoning
            zoningFeatures.forEach((f) => {
              if (!f.properties.color) f.properties.color = "#3b82f6";
            });
            map.addSource("zoning-data", {
              type: "geojson",
              data: { type: "FeatureCollection", features: zoningFeatures },
            });
            map.addLayer({
              id: "zoning-fill",
              type: "fill",
              source: "zoning-data",
              paint: {
                "fill-color": ["get", "color"],
                "fill-opacity": 0.28,
              },
            });
            map.addLayer({
              id: "zoning-outline",
              type: "line",
              source: "zoning-data",
              paint: {
                "line-color": ["get", "color"],
                "line-width": 2,
              },
            });

            // Fitur KAWASAN_ (semua properties yg memiliki awalan 'KAWASAN_')
            const kawasanFeatures = geojson.features.filter(
              (feat) =>
                feat.properties &&
                Object.keys(feat.properties).some((key) =>
                  key.startsWith("KAWASAN_")
                )
            );
            kawasanFeatures.forEach((f, idx) => {
              // Assign warna kawasan jika belum ada
              if (!f.properties.kawasanColor) {
                const colors = [
                  "#a3e635",
                  "#65a30d",
                  "#facc15",
                  "#f87171",
                  "#f472b6",
                  "#818cf8",
                  "#38bdf8",
                  "#c026d3",
                ];
                f.properties.kawasanColor = colors[idx % colors.length];
              }
            });

            if (kawasanFeatures.length > 0) {
              map.addSource("kawasan-data", {
                type: "geojson",
                data: { type: "FeatureCollection", features: kawasanFeatures },
              });
              map.addLayer({
                id: "kawasan-fill",
                type: "fill",
                source: "kawasan-data",
                paint: {
                  "fill-color": ["get", "kawasanColor"],
                  "fill-opacity": 0.15,
                },
                layout: {
                  visibility: "visible",
                },
              });
              map.addLayer({
                id: "kawasan-outline",
                type: "line",
                source: "kawasan-data",
                paint: {
                  "line-color": ["get", "kawasanColor"],
                  "line-width": 2,
                },
                layout: {
                  visibility: "visible",
                },
              });
            }

            // Fungsi utilitas untuk mengambil nama/aturan kawasan dari properties
            function getKawasanInfo(props) {
              let kawasanNames = Object.entries(props)
                .filter(([k, v]) => k.startsWith("KAWASAN_") && v && v !== "0")
                .map(
                  ([k, v]) =>
                    `<div><b>${k.replace("KAWASAN_", "")}</b>: ${v}</div>`
                );
              if (!kawasanNames.length) {
                return `<div class="text-gray-400">(Tidak ada detail nama kawasan)</div>`;
              }
              return kawasanNames.join("");
            }

            // Fungsi untuk membuat info popup yang menggabungkan info zona KUZ dan kawasan terkait
            function buildCombinedPopupHTML(zonaProps, kawasanProps) {
              let zonaTitle =
                zonaProps.KUZ ||
                zonaProps.ZONA ||
                zonaProps.zona ||
                zonaProps.name ||
                "-";
              let kdb = zonaProps.KDB || zonaProps.kdb || "";
              let klb = zonaProps.KLB || zonaProps.klb || "";
              return `
                <div class="zone-info-popup">
                  <h3>${zonaTitle}</h3>
                  ${kdb ? `<p><strong>KDB:</strong> ${kdb}</p>` : ""}
                  ${klb ? `<p><strong>KLB:</strong> ${klb}</p>` : ""}
                  <p class="mt-2 text-sm text-gray-600">Zonasi telah dipilih untuk perhitungan bangunan</p>
                  <hr class="my-3">
                  <h4 class="font-bold text-base mb-1">Kawasan Terkait</h4>
                  ${getKawasanInfo(kawasanProps || {})}
                </div>
              `;
            }

            // Cari fitur kawasan yang tumpang tindih (spatially intersects) dengan fitur zona pada klik
            function findKawasanAt(lngLat) {
              // Konversi lngLat menjadi turf point
              const pt = turf.point([lngLat.lng, lngLat.lat]);
              for (let feat of kawasanFeatures) {
                if (turf.booleanPointInPolygon(pt, feat)) {
                  return feat.properties;
                }
              }
              return null;
            }

            // Interaksi klik pada zona KUZ/zoning, tampilkan juga info kawasan jika ada
            map.on("click", "zoning-fill", function (e) {
              updateAdministrativeFields(e.lngLat);
              const properties = e.features[0].properties;
              document.getElementById("zona").value =
                properties.KUZ ||
                properties.ZONA ||
                properties.zona ||
                properties.name ||
                "-";
              document.getElementById("kdb").value =
                properties.KDB || properties.kdb || "";
              document.getElementById("klb").value =
                properties.KLB || properties.klb || "";

              document.getElementById("zona-info").textContent =
                `Zona ${
                  properties.KUZ ||
                  properties.ZONA ||
                  properties.zona ||
                  properties.name ||
                  "-"
                }` +
                (properties.KDB || properties.kdb
                  ? ` memiliki KDB ${properties.KDB || properties.kdb}`
                  : "") +
                (properties.KLB || properties.klb
                  ? ` dan KLB ${properties.KLB || properties.klb}`
                  : "") +
                (properties.KDB || properties.kdb
                  ? `. Luas maksimum bangunan yang diizinkan adalah ${
                      parseFloat(properties.KDB || properties.kdb) * 100
                    }% dari luas tanah.`
                  : "");

              // Temukan info kawasan berdasarkan lokasi klik
              const kawasanProps = findKawasanAt(e.lngLat);

              new mapboxgl.Popup()
                .setLngLat(e.lngLat)
                .setHTML(buildCombinedPopupHTML(properties, kawasanProps))
                .addTo(map);
            });

            // Interaksi klik pada KAWASAN, tampilkan juga info zona bila tersedia pada posisi klik
            map.on("click", "kawasan-fill", function (e) {
              updateAdministrativeFields(e.lngLat);
              const kawasanProps = e.features[0].properties;

              // Temukan fitur zona/zoning pada posisi klik
              let zonaProps = null;
              if (zoningFeatures.length > 0) {
                const pt = turf.point([e.lngLat.lng, e.lngLat.lat]);
                for (let f of zoningFeatures) {
                  if (turf.booleanPointInPolygon(pt, f)) {
                    zonaProps = f.properties;
                    break;
                  }
                }
              }

              if (!zonaProps) {
                // Fallback: zona kosong jika tidak tumpang tindih
                zonaProps = {};
              }

              new mapboxgl.Popup()
                .setLngLat(e.lngLat)
                .setHTML(buildCombinedPopupHTML(zonaProps, kawasanProps))
                .addTo(map);
            });

            map.on("mouseenter", "zoning-fill", function () {
              map.getCanvas().style.cursor = "pointer";
            });
            map.on("mouseleave", "zoning-fill", function () {
              map.getCanvas().style.cursor = "";
            });

            map.on("mouseenter", "kawasan-fill", function () {
              map.getCanvas().style.cursor = "pointer";
            });
            map.on("mouseleave", "kawasan-fill", function () {
              map.getCanvas().style.cursor = "";
            });
          })
          .catch((err) => {
            document.getElementById("zone-details").innerHTML =
              "Gagal memuat peta zonasi/kawasan: " + err.message;
          });
      }

      function updateArea() {
        const data = draw.getAll();
        if (data.features.length > 0) {
          const area = turf.area(data);
          const areaInM2 = Math.round(area);
          document.getElementById("luas-tanah").value = areaInM2;
          const center = turf.center(data).geometry.coordinates;
          updateAdministrativeFields({lng: center[0], lat: center[1]});
          document.getElementById("koordinat").value = `${center[1].toFixed(
            6
          )}, ${center[0].toFixed(6)}`;
          document.getElementById("zone-details").innerHTML = `
              <p><strong>Luas Tanah:</strong> ${areaInM2} m²</p>
              <p><strong>Koordinat:</strong> ${center[1].toFixed(
                6
              )}, ${center[0].toFixed(6)}</p>
              <p class="mt-2 text-sm text-blue-600">Klik pada zona berwarna untuk melihat aturan zonasi, klik pada area kawasan untuk info kawasan</p>
          `;
        } else {
          document.getElementById("luas-tanah").value = "";
          document.getElementById("koordinat").value = "";
          document.getElementById("zone-details").textContent =
            "Klik pada peta untuk melihat informasi zona/kawasan";
        }
      }

      // Submit form function
      function submitForm() {
        const submitButton = document.getElementById("submit-form");
        const originalText = submitButton.innerHTML;
        
        // Show loading state
        submitButton.disabled = true;
        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Mengirim...';
        
        // Collect form data
        const formData = new FormData();
        
        // Data pemohon
        formData.append('nama', document.getElementById('nama').value);
        formData.append('nik', document.getElementById('nik').value);
        formData.append('alamat', document.getElementById('alamat').value);
        formData.append('telepon', document.getElementById('telepon').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('jenis_pemohon', document.getElementById('jenis-pemohon').value);
        
        // Data lokasi
        formData.append('alamat_lokasi', document.getElementById('alamat-lokasi').value);
        formData.append('kelurahan', document.getElementById('kelurahan').value);
        formData.append('kecamatan', document.getElementById('kecamatan').value);
        formData.append('koordinat', document.getElementById('koordinat').value);
        formData.append('luas_tanah', document.getElementById('luas-tanah').value);
        formData.append('zona', document.getElementById('zona').value);
        
        // Data bangunan
        formData.append('jenis_bangunan', document.getElementById('jenis-bangunan').value);
        formData.append('tinggi_bangunan', document.getElementById('tinggi-bangunan').value);
        formData.append('luas_bangunan', document.getElementById('luas-bangunan').value);
        formData.append('jumlah_lantai', document.getElementById('jumlah-lantai').value);
        formData.append('kdb', document.getElementById('kdb').value || '');
        formData.append('klb', document.getElementById('klb').value || '');
        
        // Pernyataan
        formData.append('pernyataan', document.getElementById('pernyataan').checked ? '1' : '');
        
        // File uploads
        const sertifikatFile = document.getElementById('sertifikat').files[0];
        const ktpFile = document.getElementById('ktp').files[0];
        const gambarFile = document.getElementById('gambar').files[0];
        const lainnyaFile = document.getElementById('lainnya').files[0];
        
        if (sertifikatFile) formData.append('sertifikat', sertifikatFile);
        if (ktpFile) formData.append('ktp', ktpFile);
        if (gambarFile) formData.append('gambar', gambarFile);
        if (lainnyaFile) formData.append('lainnya', lainnyaFile);
        
        // Send AJAX request
        fetch('<?=base_url("usulan/save")?>', {
          method: 'POST',
          body: formData
        })
        .then(response => response.json())
        .then(data => {
          if (data.success) {
            // Update modal with actual ticket number
            document.querySelector('#success-modal .font-mono').textContent = data.nomor_tiket;
            document.getElementById("success-modal").classList.remove("hidden");
          } else {
            // Show error message
            let errorMessage = data.message || 'Terjadi kesalahan saat mengirim formulir.';
            if (data.errors) {
              errorMessage += '\n\nDetail Error:\n' + Object.values(data.errors).join('\n');
            }
            alert(errorMessage);
          }
        })
        .catch(error => {
          console.error('Error:', error);
          alert('Terjadi kesalahan jaringan. Silakan coba lagi.');
        })
        .finally(() => {
          // Restore button state
          submitButton.disabled = false;
          submitButton.innerHTML = originalText;
        });
      }

      // Initialize when DOM is loaded
      document.addEventListener("DOMContentLoaded", function () {
        // Initialize AOS
        AOS.init();

        // Theme toggle
        document
          .getElementById("theme-toggle")
          .addEventListener("click", function () {
            document.body.classList.toggle("bg-gray-900");
            document.body.classList.toggle("text-white");

            const icon = this.querySelector("i");
            if (icon.classList.contains("fa-sun")) {
              icon.classList.remove("fa-sun");
              icon.classList.add("fa-moon");
            } else {
              icon.classList.remove("fa-moon");
              icon.classList.add("fa-sun");
            }
          });

        // Load Turf.js for area calculations
        const script = document.createElement("script");
        script.src = "https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js";
        document.head.appendChild(script);
      });
    </script>
  </body>
</html>
