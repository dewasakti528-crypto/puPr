// Initialize AOS
AOS.init({
  duration: 800,
  once: true,
});

// Theme Toggle
$(document).ready(function () {
  // Check for saved theme or default to light
  const currentTheme = localStorage.getItem("theme") || "light";

  if (currentTheme === "dark") {
    $("body").removeClass("light-mode").addClass("dark-mode");
    $("#theme-toggle i").addClass("hidden");
    $("#theme-toggle i.fa-moon").removeClass("hidden");
  } else {
    $("body").removeClass("dark-mode").addClass("light-mode");
    $("#theme-toggle i").addClass("hidden");
    $("#theme-toggle i.fa-sun").removeClass("hidden");
  }

  // Theme toggle button
  $("#theme-toggle").click(function () {
    if ($("body").hasClass("light-mode")) {
      $("body").removeClass("light-mode").addClass("dark-mode");
      $("#theme-toggle i").addClass("hidden");
      $("#theme-toggle i.fa-moon").removeClass("hidden");
      localStorage.setItem("theme", "dark");
    } else {
      $("body").removeClass("dark-mode").addClass("light-mode");
      $("#theme-toggle i").addClass("hidden");
      $("#theme-toggle i.fa-sun").removeClass("hidden");
      localStorage.setItem("theme", "light");
    }
  });

  // Mobile menu toggle
  $("#mobile-menu-button").click(function () {
    $("#mobile-menu").slideToggle();
  });

  // Smooth scrolling for anchor links
  $('a[href^="#"]').on("click", function (e) {
    e.preventDefault();

    const target = this.hash;
    const $target = $(target);

    $("html, body").animate(
      {
        scrollTop: $target.offset().top - 80,
      },
      800,
      "swing"
    );

    // Close mobile menu if open
    $("#mobile-menu").slideUp();
  });
});

// Initialize Mapbox Map
document.addEventListener("DOMContentLoaded", function () {
  // Mapbox Access Token
  mapboxgl.accessToken =
    "pk.eyJ1IjoiZG9vbXNkYXJrIiwiYSI6ImNscjYyZ204eDI2dmoyaXRheGI1aTE1ajQifQ.6sV5MpXG0jYJRpd0cO8SzA";

  // Create map
  const map = new mapboxgl.Map({
    container: "map",
    style: "mapbox://styles/mapbox/streets-v12",
    center: [124.8399, 1.3233], // Tomohon coordinates
    zoom: 13,
    attributionControl: false,
  });

  // Add controls
  map.addControl(new mapboxgl.NavigationControl(), "top-right");
  map.addControl(
    new mapboxgl.ScaleControl({
      maxWidth: 100,
      unit: "metric",
    })
  );

  // Load Turf.js for spatial operations (if needed for advanced features later)
  // Note: Turf is not strictly needed for basic visualization but good to have if we do client-side analysis
  // We can load it dynamically if not present in layout
  if (typeof turf === "undefined") {
    const script = document.createElement("script");
    script.src = "https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js";
    document.head.appendChild(script);
  }

  map.on("load", function () {
    addZoningAndKawasanLayers();
  });

  // Function to load GeoJSON and add layers
  function addZoningAndKawasanLayers() {
    // Determine base URL from layout data attribute or default
    const baseUrl = document.body.dataset.url || "";

    fetch(`${baseUrl}assets/geojson/geodata.geojson`)
      .then((res) => {
        if (!res.ok) throw new Error("Gagal load GeoJSON zonasi");
        return res.json();
      })
      .then((geojson) => {
        // 1. Zoning Layer (KUZ/ZONA)
        const zoningFeatures = geojson.features.filter(
          (feat) =>
            feat.properties &&
            (String(feat.properties.KUZ || "").trim() !== "" ||
              String(feat.properties.ZONA || "").trim() !== "" ||
              String(feat.properties.zona || "").trim() !== "")
        );

        // Assign default color if missing
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
          layout: {
            visibility: "visible",
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
          layout: {
            visibility: "visible",
          },
        });

        // 2. Kawasan Layer (KAWASAN_)
        const kawasanFeatures = geojson.features.filter(
          (feat) =>
            feat.properties &&
            Object.keys(feat.properties).some((key) =>
              key.startsWith("KAWASAN_")
            )
        );

        kawasanFeatures.forEach((f, idx) => {
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

        // Setup interactions
        setupMapInteractions(zoningFeatures, kawasanFeatures);
      })
      .catch((err) => {
        console.error("Error loading GeoJSON:", err);
        const infoPanel = document.getElementById("info-panel");
        const zoneInfo = document.getElementById("zone-info");
        infoPanel.classList.remove("hidden");
        zoneInfo.innerHTML = `<p class="text-red-500">Gagal memuat data peta: ${err.message}</p>`;
      });
  }

  function setupMapInteractions(zoningFeatures, kawasanFeatures) {
    // Change cursor on hover
    const layers = ["zoning-fill", "kawasan-fill"];
    layers.forEach((layer) => {
      map.on("mouseenter", layer, () => {
        map.getCanvas().style.cursor = "pointer";
      });
      map.on("mouseleave", layer, () => {
        map.getCanvas().style.cursor = "";
      });
    });

    // Click handler for Zoning
    map.on("click", "zoning-fill", function (e) {
      const props = e.features[0].properties;
      showZoneInfo(props, "zoning");

      // Also check for overlapping kawasan if needed, or just show zoning info
      // For home page, simple info is enough
    });

    // Click handler for Kawasan
    map.on("click", "kawasan-fill", function (e) {
      const props = e.features[0].properties;
      showZoneInfo(props, "kawasan");
    });
  }

  function showZoneInfo(props, type) {
    const infoPanel = document.getElementById("info-panel");
    const zoneInfo = document.getElementById("zone-info");

    let content = "";

    if (type === "zoning") {
      const name = props.KUZ || props.ZONA || props.zona || props.name || "-";
      const kdb = props.KDB || props.kdb || "-";
      const klb = props.KLB || props.klb || "-";

      content = `
        <h4 class="font-bold text-blue-600 mb-2">Zona RTRW</h4>
        <p><strong>Nama Zona:</strong> ${name}</p>
        <p><strong>KDB:</strong> ${kdb}</p>
        <p><strong>KLB:</strong> ${klb}</p>
        <p class="mt-2 text-xs text-gray-500">Klik untuk detail lebih lanjut</p>
      `;
    } else if (type === "kawasan") {
      // Extract KAWASAN_ properties
      let kawasanList = Object.entries(props)
        .filter(([k, v]) => k.startsWith("KAWASAN_") && v && v !== "0")
        .map(([k, v]) => `<li><b>${k.replace("KAWASAN_", "")}</b>: ${v}</li>`)
        .join("");

      if (!kawasanList) kawasanList = "<li>Tidak ada detail kawasan</li>";

      content = `
        <h4 class="font-bold text-green-600 mb-2">Kawasan Khusus</h4>
        <ul class="list-disc pl-4 text-sm">
          ${kawasanList}
        </ul>
      `;
    }

    zoneInfo.innerHTML = content;
    infoPanel.classList.remove("hidden");
  }

  // Go to coordinates button
  document
    .getElementById("go-to-coords")
    .addEventListener("click", function () {
      const lat = parseFloat(document.getElementById("lat-input").value);
      const lng = parseFloat(document.getElementById("lng-input").value);

      if (!isNaN(lat) && !isNaN(lng)) {
        map.flyTo({
          center: [lng, lat],
          zoom: 15,
          essential: true,
        });
      } else {
        alert("Masukkan koordinat yang valid");
      }
    });

  // Reset map button
  document.getElementById("reset-map").addEventListener("click", function () {
    map.flyTo({
      center: [124.8399, 1.3233],
      zoom: 13,
      essential: true,
    });
    document.getElementById("info-panel").classList.add("hidden");
  });

  // Calculate area button (placeholder functionality)
  document
    .getElementById("calculate-area")
    .addEventListener("click", function () {
      alert("Fitur perhitungan luas tersedia di halaman 'Buat Usulan'");
      window.location.href = "usulan";
    });

  // Layer toggles
  function toggleLayer(layerId, isVisible) {
    if (map.getLayer(layerId)) {
      map.setLayoutProperty(
        layerId,
        "visibility",
        isVisible ? "visible" : "none"
      );
    }
  }

  document
    .getElementById("zona-residential") // Re-purposing as "Toggle Zoning"
    .addEventListener("change", function () {
      toggleLayer("zoning-fill", this.checked);
      toggleLayer("zoning-outline", this.checked);
    });

  document
    .getElementById("zona-commercial") // Re-purposing as "Toggle Kawasan"
    .addEventListener("change", function () {
      toggleLayer("kawasan-fill", this.checked);
      toggleLayer("kawasan-outline", this.checked);
    });

  document
    .getElementById("zona-industrial")
    .addEventListener("change", function () {
      // Keep as placeholder or maybe toggle satellite view?
      // Let's just log for now
      console.log("Industrial filter not mapped to specific layer yet");
    });
});

function showSopModal() {
  document.getElementById("sop-modal").style.display = "flex";
  document.body.style.overflow = "hidden";
}
function closeSopModal() {
  document.getElementById("sop-modal").style.display = "none";
  document.body.style.overflow = "";
}
// Escape to close modal
document.addEventListener("keydown", function (event) {
  if (event.key === "Escape") {
    closeSopModal();
  }
});
// Click outside image closes modal
document.getElementById("sop-modal").addEventListener("click", function (e) {
  if (e.target === this) closeSopModal();
});

function showPetaModal() {
  document.getElementById("peta-modal").classList.remove("hidden");
  document.body.style.overflow = "hidden";
}
function closePetaModal() {
  document.getElementById("peta-modal").classList.add("hidden");
  document.body.style.overflow = "";
}
// Optional: Allow closing modal with Escape key
document.addEventListener("keydown", function (e) {
  if (
    e.key === "Escape" &&
    !document.getElementById("peta-modal").classList.contains("hidden")
  ) {
    closePetaModal();
  }
});

// ========================================
// ZONING DATA LOADING FROM SATRIA.JSON
// ========================================

// Load zoning data from satria.json
function loadZoningData() {
  const baseUrl = document.body.dataset.url || "";
  
  fetch(`${baseUrl}assets/geojson/satria.json`)
    .then((response) => {
      if (!response.ok) {
        throw new Error("Gagal memuat data zonasi");
      }
      return response.json();
    })
    .then((data) => {
      renderZoningTable(data);
    })
    .catch((error) => {
      console.error("Error loading zoning data:", error);
      const tbody = document.getElementById("zoning-table-body");
      if (tbody) {
        tbody.innerHTML = `
          <tr>
            <td colspan="3" class="px-6 py-8 text-center text-red-600 dark:text-red-400">
              <i class="fas fa-exclamation-triangle mr-2"></i>
              Gagal memuat data zonasi. Silakan refresh halaman.
            </td>
          </tr>
        `;
      }
    });
}

// Render zoning table from JSON data
function renderZoningTable(data) {
  const tbody = document.getElementById("zoning-table-body");
  if (!tbody) return;

  // Filter data: only show entries with valid PASAL (not "-" or null)
  const validData = data.filter(
    (item) => item.PASAL && item.PASAL !== "-" && item.PASAL.trim() !== ""
  );

  // Clear loading indicator
  tbody.innerHTML = "";

  // If no valid data
  if (validData.length === 0) {
    tbody.innerHTML = `
      <tr>
        <td colspan="3" class="px-6 py-8 text-center text-gray-600 dark:text-gray-400">
          <i class="fas fa-info-circle mr-2"></i>
          Tidak ada data zonasi tersedia.
        </td>
      </tr>
    `;
    return;
  }

  // Generate table rows
  validData.forEach((item) => {
    const row = document.createElement("tr");
    row.className =
      "hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors cursor-pointer";

    // Kawasan column
    const kawasanCell = document.createElement("td");
    kawasanCell.className =
      "px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-white";
    kawasanCell.textContent = item.KAWASAN_ || "-";

    // Pasal column
    const pasalCell = document.createElement("td");
    pasalCell.className =
      "px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300";
    pasalCell.textContent = item.PASAL || "-";

    // Detail KUZ column (button)
    const detailCell = document.createElement("td");
    detailCell.className = "px-6 py-4 text-center";

    if (item.KUZ && item.KUZ.trim() !== "") {
      const detailButton = document.createElement("button");
      detailButton.className =
        "bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition-colors inline-flex items-center";
      detailButton.innerHTML = `
        <i class="fas fa-book-open mr-2"></i>
        Lihat Detail
      `;
      detailButton.onclick = () =>
        showKUZDetail(item.KAWASAN_, item.PASAL, item.KUZ);
      detailCell.appendChild(detailButton);
    } else {
      detailCell.innerHTML = `
        <span class="text-gray-400 dark:text-gray-500 text-sm italic">
          Tidak ada detail
        </span>
      `;
    }

    row.appendChild(kawasanCell);
    row.appendChild(pasalCell);
    row.appendChild(detailCell);

    // Add click event to entire row
    row.onclick = () => {
      if (item.KUZ && item.KUZ.trim() !== "") {
        showKUZDetail(item.KAWASAN_, item.PASAL, item.KUZ);
      }
    };

    tbody.appendChild(row);
  });
}

// Show KUZ detail modal
function showKUZDetail(kawasan, pasal, kuz) {
  const modal = document.getElementById("kuz-modal");
  const kawasanName = document.getElementById("kuz-kawasan-name");
  const pasalRef = document.getElementById("kuz-pasal-ref");
  const kuzContent = document.getElementById("kuz-content");

  if (!modal || !kawasanName || !pasalRef || !kuzContent) return;

  // Set content
  kawasanName.textContent = kawasan || "Kawasan";
  pasalRef.textContent = `Referensi: ${pasal || "-"}`;
  kuzContent.textContent = kuz || "Tidak ada detail tersedia.";

  // Show modal
  modal.style.display = "flex";
  modal.classList.remove("hidden");
  document.body.style.overflow = "hidden";
}

// Close KUZ modal
function closeKUZModal() {
  const modal = document.getElementById("kuz-modal");
  if (!modal) return;

  modal.style.display = "none";
  modal.classList.add("hidden");
  document.body.style.overflow = "";
}

// Close modal on Escape key
document.addEventListener("keydown", function (e) {
  if (e.key === "Escape") {
    closeKUZModal();
  }
});

// Close modal on outside click
document.addEventListener("click", function (e) {
  const modal = document.getElementById("kuz-modal");
  if (modal && e.target === modal) {
    closeKUZModal();
  }
});

// Load zoning data when DOM is ready
document.addEventListener("DOMContentLoaded", function () {
  // Check if zoning table exists on the page
  const zoningTable = document.getElementById("zoning-table");
  if (zoningTable) {
    loadZoningData();
  }
});
