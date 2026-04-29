/**
 * Manage Usulan JavaScript
 * Handles all client-side logic for managing usulan (proposals)
 *
 * @requires mapboxgl - Mapbox GL JS library
 * @requires ManageUsulanConfig - Configuration object passed from PHP (optional for dynamic loading)
 */

// Global variables from configuration
let usulanData = [];
let currentPage = 1;
let currentFilter = "all";
let currentZona = "";
let currentKelurahan = "";
let baseUrl = "";
let mapboxToken =
  "pk.eyJ1IjoiZG9vbXNkYXJrIiwiYSI6ImNscjYyZ204eDI2dmoyaXRheGI1aTE1ajQifQ.6sV5MpXG0jYJRpd0cO8SzA";
let totalPages = 1;
let isLoading = false;

/**
 * Load usulan data from server via AJAX
 * @param {Object} params - Query parameters (status, zona, kelurahan, page)
 * @param {boolean} reload - Whether to reload page after loading data
 * @returns {Promise} Promise that resolves with data
 */
async function loadUsulanData(params = {}, reload = true) {
  if (isLoading) {
    console.log("Already loading data, skipping...");
    return;
  }

  isLoading = true;

  // Build query string
  const queryParams = new URLSearchParams();
  if (params.status && params.status !== "all")
    queryParams.append("status", params.status);
  if (params.zona) queryParams.append("zona", params.zona);
  if (params.kelurahan) queryParams.append("kelurahan", params.kelurahan);
  if (params.page) queryParams.append("page", params.page);

  const url = `${baseUrl}admin/usulan/getdata${
    queryParams.toString() ? "?" + queryParams.toString() : ""
  }`;

  try {
    console.log("Loading data from:", url);
    const response = await fetch(url, {
      method: "GET",
      headers: {
        "X-Requested-With": "XMLHttpRequest",
        Accept: "application/json",
      },
    });

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const result = await response.json();

    if (result.success && result.data) {
      // Update global variables with fetched data
      usulanData = result.data.usulanData || [];
      currentPage = result.data.currentPage || 1;
      currentFilter = result.data.currentFilter || "all";
      currentZona = result.data.currentZona || "";
      currentKelurahan = result.data.currentKelurahan || "";
      totalPages = result.data.totalPages || 1;

      console.log("Data loaded successfully:", {
        count: usulanData.length,
        page: currentPage,
        totalPages: totalPages,
      });

      // Reload the page to show new data if requested
      if (reload) {
        window.location.reload();
      }

      return result.data;
    } else {
      throw new Error("Invalid response format");
    }
  } catch (error) {
    console.error("Error loading usulan data:", error);
    alert("Gagal memuat data usulan. Silakan refresh halaman.");
    throw error;
  } finally {
    isLoading = false;
  }
}

/**
 * Initialize the manage usulan page
 * @param {Object} config - Configuration object from PHP (optional)
 */
async function initManageUsulan(config) {
  // If config is provided, use it
  if (config && config.usulanData && config.usulanData.length > 0) {
    usulanData = config.usulanData || [];
    currentPage = config.currentPage || 1;
    currentFilter = config.currentFilter || "all";
    currentZona = config.currentZona || "";
    currentKelurahan = config.currentKelurahan || "";
    baseUrl = config.baseUrl || "";
    mapboxToken = config.mapboxToken || mapboxToken;
    totalPages = config.totalPages || 1;

    console.log("Initialized with config from PHP");
  } else {
    // No config or empty data, load from AJAX
    console.log("No config provided, loading data from AJAX...");

    // Set baseUrl from config or try to get from window location
    baseUrl = (config && config.baseUrl) || window.location.origin + "/";

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get("status") || "all";
    const zona = urlParams.get("zona") || "";
    const kelurahan = urlParams.get("kelurahan") || "";
    const page = urlParams.get("page") || "1";

    try {
      await loadUsulanData(
        {
          status: status,
          zona: zona,
          kelurahan: kelurahan,
          page: page,
        },
        false
      ); // Don't reload page after initial load
    } catch (error) {
      console.error("Failed to load initial data:", error);
    }
  }

  // Debug logging
  console.log("Manage Usulan Initialized");
  console.log("usulanData:", usulanData);
  console.log("Type of usulanData:", typeof usulanData);
  console.log("Is array?", Array.isArray(usulanData));
  console.log("Data count:", usulanData.length);
  console.log("Base URL:", baseUrl);

  // Setup event listeners
  setupEventListeners();
}

/**
 * Setup all event listeners
 */
function setupEventListeners() {
  // Detail modal close buttons
  const closeModalBtn = document.getElementById("close-detail-modal");
  const closeDetailBtn = document.getElementById("close-detail-btn");
  const detailModal = document.getElementById("detail-modal");

  if (closeModalBtn) {
    closeModalBtn.addEventListener("click", () => {
      detailModal.classList.add("hidden");
    });
  }

  if (closeDetailBtn) {
    closeDetailBtn.addEventListener("click", () => {
      detailModal.classList.add("hidden");
    });
  }

  // Close detail modal when clicking outside
  if (detailModal) {
    detailModal.addEventListener("click", (e) => {
      if (e.target === detailModal) {
        detailModal.classList.add("hidden");
      }
    });
  }

  // Reject modal elements
  const rejectModal = document.getElementById("reject-modal");
  const rejectBtn = document.getElementById("reject-btn");
  const cancelRejectBtn = document.getElementById("cancel-reject-btn");
  const confirmRejectBtn = document.getElementById("confirm-reject-btn");
  const rejectReason = document.getElementById("reject-reason");

  // Show reject modal when reject button clicked
  if (rejectBtn) {
    rejectBtn.addEventListener("click", () => {
      const usulanId = rejectBtn.dataset.usulanId;
      if (usulanId) {
        rejectModal.classList.remove("hidden");
        rejectReason.value = ""; // Clear previous input
        rejectReason.focus();
      }
    });
  }

  // Cancel reject
  if (cancelRejectBtn) {
    cancelRejectBtn.addEventListener("click", () => {
      rejectModal.classList.add("hidden");
      rejectReason.value = "";
    });
  }

  // Confirm reject
  if (confirmRejectBtn) {
    confirmRejectBtn.addEventListener("click", () => {
      const usulanId = rejectBtn.dataset.usulanId;
      const catatan = rejectReason.value.trim();

      if (!catatan) {
        alert("Catatan penolakan wajib diisi!");
        rejectReason.focus();
        return;
      }

      if (usulanId) {
        rejectUsulan(usulanId, catatan);
        rejectModal.classList.add("hidden");
      }
    });
  }

  // Close reject modal when clicking outside
  if (rejectModal) {
    rejectModal.addEventListener("click", (e) => {
      if (e.target === rejectModal) {
        rejectModal.classList.add("hidden");
        rejectReason.value = "";
      }
    });
  }

  // Approve button in modal
  const approveBtn = document.getElementById("approve-btn");

  if (approveBtn) {
    approveBtn.addEventListener("click", () => {
      const usulanId = approveBtn.dataset.usulanId;
      if (usulanId) {
        approveUsulan(usulanId);
      }
    });
  }
}

/**
 * Helper function to format file size
 * @param {number} bytes - File size in bytes
 * @returns {string} Formatted file size
 */
function formatFileSize(bytes) {
  if (!bytes) return "Unknown";
  const sizes = ["Bytes", "KB", "MB", "GB"];
  const i = Math.floor(Math.log(bytes) / Math.log(1024));
  return Math.round(bytes / Math.pow(1024, i), 2) + " " + sizes[i];
}

/**
 * Filter usulan by status
 * @param {string} status - Status filter (all, submitted, approved, rejected)
 */
function filterUsulan(status) {
  loadUsulanData({
    status: status,
    zona: currentZona,
    kelurahan: currentKelurahan,
    page: 1,
  });
}

/**
 * Filter usulan by zona
 * @param {string} zona - Zona filter
 */
function filterByZona(zona) {
  loadUsulanData({
    status: currentFilter,
    zona: zona,
    kelurahan: currentKelurahan,
    page: 1,
  });
}

/**
 * Filter usulan by kelurahan
 * @param {string} kelurahan - Kelurahan filter
 */
function filterByKelurahan(kelurahan) {
  loadUsulanData({
    status: currentFilter,
    zona: currentZona,
    kelurahan: kelurahan,
    page: 1,
  });
}

/**
 * Change pagination page
 * @param {string} direction - Direction (prev or next)
 */
function changePage(direction) {
  let newPage = currentPage;

  if (direction === "prev" && currentPage > 1) {
    newPage = currentPage - 1;
  } else if (direction === "next" && currentPage < totalPages) {
    newPage = currentPage + 1;
  }

  if (newPage !== currentPage) {
    loadUsulanData({
      status: currentFilter,
      zona: currentZona,
      kelurahan: currentKelurahan,
      page: newPage,
    });
  }
}

/**
 * Show detail modal for a specific usulan
 * @param {number} id - Usulan ID
 */
function showDetail(id) {
  console.log("Looking for usulan with ID:", id);
  console.log("Available usulanData:", usulanData);

  // Show modal immediately for better UX
  const modal = document.getElementById("detail-modal");
  if (modal) {
    modal.classList.remove("hidden");
  }

  // Validate usulanData
  if (!Array.isArray(usulanData)) {
    console.error("usulanData is not an array:", typeof usulanData);
    alert("Data tidak tersedia. Silakan refresh halaman.");
    modal?.classList.add("hidden");
    return;
  }

  if (usulanData.length === 0) {
    console.error("usulanData is empty");
    alert("Tidak ada data usulan. Silakan refresh halaman.");
    modal?.classList.add("hidden");
    return;
  }

  // Find usulan with error handling
  let usulan = null;
  try {
    usulan = usulanData.find((u) => u && (u.id == id || u.id == parseInt(id)));
  } catch (error) {
    console.error("Error finding usulan:", error);
    alert("Terjadi kesalahan saat mencari data. Silakan refresh halaman.");
    modal?.classList.add("hidden");
    return;
  }

  console.log("Found usulan:", usulan);

  if (!usulan) {
    console.error("Usulan not found with ID:", id);
    console.error(
      "Available IDs:",
      usulanData.map((u) => u?.id).filter((id) => id !== undefined)
    );
    console.error("Data structure sample:", usulanData[0]);
    alert("Data usulan tidak ditemukan. Silakan refresh halaman.");
    modal?.classList.add("hidden");
    return;
  }

  // Populate modal with usulan data
  populateModal(usulan);

  // Initialize verification map (after a short delay to ensure modal is visible)
  setTimeout(() => {
    initVerificationMap(usulan);
  }, 100);
}

/**
 * Populate modal with usulan data
 * @param {Object} usulan - Usulan data object
 */
function populateModal(usulan) {
  // Quick info cards
  document.getElementById("detail-nomor-tiket").textContent =
    usulan.nomor_tiket || "Tidak ada data";
  document.getElementById("detail-submitted-at").textContent = usulan.created_at
    ? new Date(usulan.created_at).toLocaleDateString("id-ID", {
        day: "numeric",
        month: "short",
        year: "numeric",
        hour: "2-digit",
        minute: "2-digit",
      })
    : "Tidak ada data";

  // Data pemohon
  document.getElementById("detail-nama").textContent =
    usulan.nama_pemohon || "Tidak ada data";
  document.getElementById("detail-nik").textContent =
    usulan.nik || "Tidak ada data";
  document.getElementById("detail-alamat-pemohon").textContent =
    usulan.alamat_pemohon || "Tidak ada data";
  document.getElementById("detail-no-hp").textContent =
    usulan.no_hp_pemohon || "Tidak ada data";
  document.getElementById("detail-email").textContent =
    usulan.email_pemohon || "Tidak ada data";
  document.getElementById("detail-jenis-pemohon").textContent =
    usulan.jenis_pemohon_pemohon || "Tidak ada data";

  // Data lokasi
  document.getElementById("detail-alamat-lokasi").textContent =
    usulan.alamat_lokasi || "Tidak ada data";
  document.getElementById("detail-kelurahan").textContent =
    usulan.kelurahan || "Tidak ada data";
  document.getElementById("detail-kecamatan").textContent =
    usulan.kecamatan || "Tidak ada data";
  document.getElementById("detail-koordinat").textContent =
    usulan.koordinat_lat && usulan.koordinat_lng
      ? `${usulan.koordinat_lat}, ${usulan.koordinat_lng}`
      : "Tidak ada koordinat";

  // Data bangunan
  document.getElementById("detail-luas-tanah").textContent = usulan.luas_tanah
    ? `${usulan.luas_tanah} m²`
    : "Tidak ada data";
  document.getElementById("detail-zona-rtrw").textContent =
    usulan.zona_rtrw || "Tidak ada data";
  document.getElementById("detail-jenis-bangunan").textContent =
    usulan.jenis_bangunan || "Tidak ada data";
  document.getElementById("detail-tinggi-bangunan").textContent =
    usulan.tinggi_bangunan ? `${usulan.tinggi_bangunan} m` : "Tidak ada data";
  document.getElementById("detail-luas-bangunan").textContent =
    usulan.luas_bangunan ? `${usulan.luas_bangunan} m²` : "Tidak ada data";
  document.getElementById("detail-jumlah-lantai").textContent =
    usulan.jumlah_lantai || "Tidak ada data";
  document.getElementById("detail-kdb").textContent =
    usulan.kdb || "Tidak ada data";
  document.getElementById("detail-klb").textContent =
    usulan.klb || "Tidak ada data";

  // Status badge
  updateStatusBadge(usulan);

  // Catatan verifikasi
  if (usulan.status === "rejected" && usulan.catatan_verifikasi) {
    document.getElementById("catatan-section").classList.remove("hidden");
    document.getElementById("detail-catatan-verifikasi").textContent =
      usulan.catatan_verifikasi;
  } else {
    document.getElementById("catatan-section").classList.add("hidden");
  }

  // Dokumen
  populateDokumen(usulan);

  // Update action buttons
  updateActionButtons(usulan);
}

/**
 * Update status badge in modal
 * @param {Object} usulan - Usulan data object
 */
function updateStatusBadge(usulan) {
  const statusBadge = document.getElementById("detail-status-badge");
  let statusText = "";
  let statusClass = "";
  let icon = "";

  switch (usulan.status) {
    case "approved":
      statusText = "Disetujui";
      statusClass =
        "bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200";
      icon = '<i class="fas fa-check-circle"></i>';
      break;
    case "submitted":
      statusText = "Menunggu";
      statusClass =
        "bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200";
      icon = '<i class="fas fa-clock"></i>';
      break;
    case "rejected":
      statusText = "Perlu Revisi";
      statusClass = "bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200";
      icon = '<i class="fas fa-exclamation-circle"></i>';
      break;
    default:
      statusText = "Draft";
      statusClass =
        "bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200";
      icon = '<i class="fas fa-file"></i>';
  }

  statusBadge.className = `status-badge ${statusClass}`;
  statusBadge.innerHTML = `${icon} ${statusText}`;
}

/**
 * Populate dokumen section
 * @param {Object} usulan - Usulan data object
 */
function populateDokumen(usulan) {
  const dokumenContainer = document.getElementById("detail-dokumen");

  if (usulan.dokumen && usulan.dokumen.length > 0) {
    const dokumenHtml = usulan.dokumen
      .map(
        (doc) => `
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-600 p-4 mb-3 hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-file-alt text-blue-500 dark:text-blue-400 mr-3"></i>
                            <span class="font-medium text-gray-800 dark:text-white">${
                              doc.filename || "Dokumen"
                            }</span>
                        </div>
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="mr-2">Type: ${
                              doc.tipe_dokumen || "Unknown"
                            }</span>
                            <span class="mr-2">Size: ${
                              doc.file_size
                                ? formatFileSize(doc.file_size)
                                : "Unknown"
                            }</span>
                        </div>
                    </div>
                    <a href="${baseUrl}admin/usulan/download/${doc.filename}"
                       class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors inline-flex items-center text-sm font-medium"
                       target="_blank">
                        <i class="fas fa-download mr-2"></i>Download
                    </a>
                </div>
            </div>
        `
      )
      .join("");
    dokumenContainer.innerHTML = dokumenHtml;
  } else {
    dokumenContainer.innerHTML = `
            <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                <i class="fas fa-file-times text-4xl mb-3"></i>
                <p class="text-lg">Tidak ada dokumen</p>
            </div>
        `;
  }
}

/**
 * Update action buttons based on usulan status
 * @param {Object} usulan - Usulan data object
 */
function updateActionButtons(usulan) {
  const approveBtn = document.getElementById("approve-btn");
  const rejectBtn = document.getElementById("reject-btn");

  // Store usulan ID in button dataset
  if (approveBtn) {
    approveBtn.dataset.usulanId = usulan.id;
  }
  if (rejectBtn) {
    rejectBtn.dataset.usulanId = usulan.id;
  }

  // Show/hide buttons based on status
  if (usulan.status === "submitted") {
    approveBtn?.classList.remove("hidden");
    rejectBtn?.classList.remove("hidden");
  } else {
    approveBtn?.classList.add("hidden");
    rejectBtn?.classList.add("hidden");
  }
}

/**
 * Initialize verification map
 * @param {Object} usulan - Usulan data object
 */
function initVerificationMap(usulan) {
  console.log("Initializing map with usulan:", usulan);

  if (!usulan || !usulan.koordinat_lat || !usulan.koordinat_lng) {
    console.log("Missing coordinates, skipping map initialization");
    return;
  }

  // Check if mapboxgl is available
  if (typeof mapboxgl === "undefined") {
    console.error("Mapbox GL JS not loaded");
    alert("Peta tidak dapat dimuat. Silakan refresh halaman.");
    return;
  }

  // Check if container exists
  const mapContainer = document.getElementById("verification-map");
  if (!mapContainer) {
    console.error("Map container not found");
    return;
  }

  try {
    mapboxgl.accessToken = mapboxToken;

    const map = new mapboxgl.Map({
      container: "verification-map",
      style: "mapbox://styles/mapbox/streets-v12",
      center: [usulan.koordinat_lng, usulan.koordinat_lat],
      zoom: 15,
      attributionControl: false,
    });

    console.log("Map initialized successfully");

    // Add controls
    map.addControl(new mapboxgl.NavigationControl(), "top-right");
    map.addControl(
      new mapboxgl.ScaleControl({
        maxWidth: 100,
        unit: "metric",
      })
    );

    // Add marker for usulan location
    new mapboxgl.Marker()
      .setLngLat([usulan.koordinat_lng, usulan.koordinat_lat])
      .addTo(map)
      .setPopup(
        new mapboxgl.Popup().setHTML(`
                <div class="p-2">
                    <strong>Lokasi Usulan</strong><br>
                    <small>${usulan.alamat_lokasi}, ${usulan.kelurahan}</small>
                </div>
            `)
      );

    // Load and display RTRW zones
    fetch(`${baseUrl}assets/geojson/data-satria.geojson`)
      .then((response) => response.json())
      .then((geojson) => {
        // Filter zone features
        const zoningFeatures = geojson.features.filter(
          (feat) =>
            feat.properties &&
            (String(feat.properties.KUZ || "").trim() !== "" ||
              String(feat.properties.ZONA || "").trim() !== "" ||
              String(feat.properties.zona || "").trim() !== "")
        );

        // Add zone layer
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
            "fill-opacity": 0.3,
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

        // Add info popup for zones
        map.on("click", "zoning-fill", function (e) {
          const properties = e.features[0].properties;
          new mapboxgl.Popup()
            .setLngLat(e.lngLat)
            .setHTML(
              `
                            <div class="p-2">
                                <strong>Zona:</strong> ${
                                  properties.KUZ ||
                                  properties.ZONA ||
                                  properties.zona ||
                                  "-"
                                }<br>
                                <small>KDB: ${properties.KDB || "-"}, KLB: ${
                properties.KLB || "-"
              }</small>
                            </div>
                        `
            )
            .addTo(map);
        });
      })
      .catch((error) => {
        console.error("Error loading zoning data:", error);
      });
  } catch (error) {
    console.error("Error initializing map:", error);
    alert("Gagal memuat peta verifikasi. Silakan refresh halaman.");
  }
}

/**
 * Approve usulan
 * @param {number} id - Usulan ID
 */
function approveUsulan(id) {
  if (!confirm("Apakah Anda yakin ingin menyetujui usulan ini?")) return;

  fetch(`${baseUrl}admin/usulan/approve/${id}`, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Usulan berhasil disetujui!");
        location.reload();
      } else {
        alert("Gagal menyetujui usulan: " + (data.message || "Unknown error"));
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Terjadi kesalahan. Silakan coba lagi.");
    });
}

/**
 * Reject usulan
 * @param {number} id - Usulan ID
 * @param {string} catatan - Rejection reason
 */
function rejectUsulan(id, catatan) {
  if (!catatan || catatan.trim() === "") {
    alert("Catatan penolakan wajib diisi!");
    return;
  }

  if (!confirm("Apakah Anda yakin ingin menolak usulan ini?")) {
    return;
  }

  fetch(`${baseUrl}admin/usulan/reject/${id}`, {
    method: "POST",
    headers: {
      "X-Requested-With": "XMLHttpRequest",
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ catatan: catatan }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert("Usulan berhasil ditolak dengan catatan.");
        location.reload();
      } else {
        alert("Gagal menolak usulan: " + (data.message || "Unknown error"));
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      alert("Terjadi kesalahan. Silakan coba lagi.");
    });
}

/**
 * Print detail
 */
function printDetail() {
  window.print();
}

// Auto-initialize when DOM is loaded
document.addEventListener("DOMContentLoaded", function () {
  // Check if ManageUsulanConfig is defined (passed from PHP)
  if (typeof ManageUsulanConfig !== "undefined") {
    console.log("Using ManageUsulanConfig from PHP");
    initManageUsulan(ManageUsulanConfig);
  } else {
    console.log("No ManageUsulanConfig found, using AJAX initialization");
    // Create minimal config with baseUrl
    const minimalConfig = {
      baseUrl: window.location.origin + "/",
      usulanData: [], // Empty array will trigger AJAX load
    };
    initManageUsulan(minimalConfig);
  }
});
