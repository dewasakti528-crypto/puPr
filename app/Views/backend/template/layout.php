<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= isset($page_title) ? esc($page_title) : 'Dashboard - SATRIA' ?></title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

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

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
      :root {
        --primary-red: #ef4444;
        --primary-purple: #7c3aed;
        --primary-blue: #3b82f6;
        --light-blue: #f0f9ff;
        --dark-bg: #111827;
      }

      .dark-mode {
        background-color: var(--dark-bg);
        color: rgba(255, 255, 255, 0.9);
      }

      .light-mode {
        background-color: var(--light-blue);
        color: #1f2937;
      }

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

      .sidebar {
        transition: all 0.3s ease;
      }

      .sidebar.collapsed {
        width: 70px;
      }

      .sidebar.collapsed .sidebar-text {
        display: none;
      }

      .main-content {
        transition: all 0.3s ease;
      }

      .card-hover {
        transition: all 0.3s ease;
      }

      .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
      }

      .stat-card {
        background: linear-gradient(135deg, #ffffff, #f8fafc);
        border-left: 4px solid;
      }

      .dark-mode .stat-card {
        background: linear-gradient(135deg, #1e293b, #334155);
      }

      .notification-dot {
        position: absolute;
        top: 8px;
        right: 8px;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #ef4444;
      }

      .progress-bar {
        height: 6px;
        border-radius: 3px;
        background-color: #e5e7eb;
        overflow: hidden;
      }

      .dark-mode .progress-bar {
        background-color: #374151;
      }

      .progress-fill {
        height: 100%;
        border-radius: 3px;
        transition: width 0.5s ease;
      }

      .chart-container {
        position: relative;
        height: 250px;
      }

      .table-container {
        max-height: 400px;
        overflow-y: auto;
      }

      .table-container::-webkit-scrollbar {
        width: 6px;
      }

      .table-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
      }

      .table-container::-webkit-scrollbar-thumb {
        background: #c5c5c5;
        border-radius: 3px;
      }

      .table-container::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
      }

      .transition-all {
        transition: all 0.5s ease;
      }

      .navbar {
        backdrop-filter: blur(10px);
      }
    </style>
  </head>
  <body class="light-mode transition-all">
    <!-- Dashboard Container -->
    <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
      <!-- Sidebar -->
      <div
        class="sidebar bg-white dark:bg-gray-800 shadow-lg w-64 flex flex-col"
      >
        <!-- Logo -->
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
          <div class="flex items-center space-x-3">
            <div
              class="w-10 h-10 gradient-bg rounded-lg flex items-center justify-center"
            >
              <i class="fas fa-globe-asia text-white text-lg"></i>
            </div>
            <div class="sidebar-text">
              <h1 class="text-xl font-bold text-gray-800 dark:text-white">
                SATRIA
              </h1>
              <p class="text-xs text-gray-500 dark:text-gray-400">Dashboard</p>
            </div>
          </div>
        </div>

        <?=$this->include('backend/template/sidebar') ?>

        <!-- User Profile -->
        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
          <div class="flex items-center space-x-3">
            <div
              class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center"
            >
              <span class="text-white font-semibold">A</span>
            </div>
            <div class="sidebar-text flex-1">
              <p class="text-sm font-medium text-gray-800 dark:text-white">
                Admin SmartGIS
              </p>
              <p class="text-xs text-gray-500 dark:text-gray-400">
                Administrator
              </p>
            </div>
            <button
              class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
            >
              <i class="fas fa-chevron-down"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Main Content -->
      <div class="main-content flex-1 flex flex-col overflow-hidden">
        <!-- Top Navigation -->
        <header class="navbar bg-white dark:bg-gray-800 shadow-sm z-10">
          <div class="flex items-center justify-between px-6 py-4">
            <div class="flex items-center space-x-4">
              <button
                id="sidebar-toggle"
                class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
              >
                <i class="fas fa-bars"></i>
              </button>
              <h1 class="text-xl font-semibold text-gray-800 dark:text-white">
                <?= isset($page_header) ? esc($page_header) : 'Dashboard Overview' ?>
              </h1>
            </div>

            <div class="flex items-center space-x-4">
              <!-- Search -->
              <div class="relative">
                <input
                  type="text"
                  placeholder="Search..."
                  class="pl-10 pr-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all"
                />
                <i
                  class="fas fa-search absolute left-3 top-3 text-gray-400"
                ></i>
              </div>

              <!-- Notifications -->
              <div class="relative">
                <button
                  class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors relative"
                >
                  <i class="fas fa-bell"></i>
                  <span class="notification-dot"></span>
                </button>
              </div>

              <!-- Theme Toggle -->
              <button
                id="theme-toggle"
                class="w-10 h-10 bg-gray-100 dark:bg-gray-700 rounded-lg flex items-center justify-center text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors"
              >
                <i class="fas fa-sun dark:hidden"></i>
                <i class="fas fa-moon hidden dark:block"></i>
              </button>
            </div>
          </div>
        </header>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto p-6">
          <?= $this->renderSection('content') ?>
        </main>
      </div>
    </div>

    <script>
      // Initialize AOS
      AOS.init({
        duration: 800,
        once: true,
      });

      // Theme Toggle
      document.addEventListener("DOMContentLoaded", function () {
        // Check for saved theme or default to light
        const currentTheme = localStorage.getItem("theme") || "light";

        if (currentTheme === "dark") {
          document.body.classList.remove("light-mode");
          document.body.classList.add("dark-mode");
          document.querySelectorAll("#theme-toggle i").forEach((icon) => {
            icon.classList.add("hidden");
          });
          document
            .querySelector("#theme-toggle i.fa-moon")
            .classList.remove("hidden");
        } else {
          document.body.classList.remove("dark-mode");
          document.body.classList.add("light-mode");
          document.querySelectorAll("#theme-toggle i").forEach((icon) => {
            icon.classList.add("hidden");
          });
          document
            .querySelector("#theme-toggle i.fa-sun")
            .classList.remove("hidden");
        }

        // Theme toggle button
        document
          .getElementById("theme-toggle")
          .addEventListener("click", function () {
            if (document.body.classList.contains("light-mode")) {
              document.body.classList.remove("light-mode");
              document.body.classList.add("dark-mode");
              document.querySelectorAll("#theme-toggle i").forEach((icon) => {
                icon.classList.add("hidden");
              });
              document
                .querySelector("#theme-toggle i.fa-moon")
                .classList.remove("hidden");
              localStorage.setItem("theme", "dark");
            } else {
              document.body.classList.remove("dark-mode");
              document.body.classList.add("light-mode");
              document.querySelectorAll("#theme-toggle i").forEach((icon) => {
                icon.classList.add("hidden");
              });
              document
                .querySelector("#theme-toggle i.fa-sun")
                .classList.remove("hidden");
              localStorage.setItem("theme", "light");
            }
          });

        // Sidebar toggle
        document
          .getElementById("sidebar-toggle")
          .addEventListener("click", function () {
            document.querySelector(".sidebar").classList.toggle("collapsed");
            document
              .querySelector(".main-content")
              .classList.toggle("lg:ml-64");
            document
              .querySelector(".main-content")
              .classList.toggle("lg:ml-20");
          });

        // Initialize Charts
        initializeCharts();
      });

      function initializeCharts() {
        // Chart 1: Usulan per Zona
        const zonaCanvas = document.getElementById("zonaChart");
        if (!zonaCanvas) {
          console.log('zonaChart canvas not found, skipping chart initialization');
          return;
        }
        const zonaCtx = zonaCanvas.getContext("2d");
        const zonaChart = new Chart(zonaCtx, {
          type: "bar",
          data: {
            labels: [
              "Perumahan",
              "Komersial",
              "Industri",
              "Khusus",
              "Campuran",
            ],
            datasets: [
              {
                label: "Jumlah Usulan",
                data: [65, 45, 20, 12, 8],
                backgroundColor: [
                  "rgba(59, 130, 246, 0.7)",
                  "rgba(124, 58, 237, 0.7)",
                  "rgba(239, 68, 68, 0.7)",
                  "rgba(16, 185, 129, 0.7)",
                  "rgba(245, 158, 11, 0.7)",
                ],
                borderColor: [
                  "rgb(59, 130, 246)",
                  "rgb(124, 58, 237)",
                  "rgb(239, 68, 68)",
                  "rgb(16, 185, 129)",
                  "rgb(245, 158, 11)",
                ],
                borderWidth: 1,
              },
            ],
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              legend: {
                display: false,
              },
            },
            scales: {
              y: {
                beginAtZero: true,
                grid: {
                  color: "rgba(0, 0, 0, 0.1)",
                },
              },
              x: {
                grid: {
                  display: false,
                },
              },
            },
          },
        });
      }
    </script>
    <!-- External JavaScript File (includes auto-initialization) -->
  <script src="<?= base_url('assets/js/' . $page .  "-v" . env('app.version') . '.js') ?>"></script>
  </body>
</html>
