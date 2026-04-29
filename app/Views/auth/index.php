<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SATRIA - Sistem Administrasi Terpadu</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <style>
      :root {
        --primary-red: #ef4444;
        --primary-purple: #7c3aed;
        --primary-blue: #3b82f6;
        --primary-green: #10b981;
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
          var(--primary-green),
          var(--primary-blue),
          var(--primary-purple)
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
          135deg,
          var(--primary-green),
          var(--primary-blue)
        );
        transition: all 0.3s ease;
      }

      .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
      }

      .transition-all {
        transition: all 0.5s ease;
      }

      .navbar {
        backdrop-filter: blur(10px);
      }

      .login-card {
        backdrop-filter: blur(10px);
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.2);
      }

      .dark-mode .login-card {
        background: rgba(30, 41, 59, 0.95);
        border: 1px solid rgba(255, 255, 255, 0.1);
      }

      .floating-label {
        transform: translateY(-50%);
        transition: all 0.3s ease;
      }

      .input-focused .floating-label {
        transform: translateY(-180%);
        font-size: 0.75rem;
        color: #3b82f6;
      }

      .dark-mode .input-focused .floating-label {
        color: #60a5fa;
      }
    </style>
  </head>
  <body class="light-mode transition-all">
    <!-- Navbar -->
    <nav
      class="navbar fixed top-0 w-full z-50 bg-white/90 dark:bg-slate-900/90 shadow-md transition-all"
    >
      <div class="container mx-auto px-4">
        <div class="flex justify-between items-center py-4">
          <!-- Logo -->
          <div class="flex items-center space-x-2">
            <i class="fas fa-shield-alt text-2xl text-green-600"></i>
            <span class="text-xl font-bold text-gray-800 dark:text-white"
              >SATRIA - Sistem Administrasi Terpadu</span
            >
          </div>

          <!-- Toggle Theme -->
          <div class="flex items-center space-x-4">
            <button
              id="theme-toggle"
              class="p-2 rounded-full bg-gray-200 dark:bg-gray-700 transition-all"
            >
              <i class="fas fa-sun text-yellow-500 dark:hidden"></i>
              <i class="fas fa-moon text-blue-300 hidden dark:block"></i>
            </button>
          </div>
        </div>
      </div>
    </nav>

    <!-- Login Section -->
    <section
      class="min-h-screen gradient-bg flex items-center justify-center py-20 px-4"
    >
      <div class="container mx-auto max-w-6xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
          <!-- Left Side - Welcome Message -->
          <div
            class="text-white text-center lg:text-left"
            data-aos="fade-right"
          >
            <div class="mb-8">
              <i class="fas fa-shield-alt text-6xl mb-6 text-white/90"></i>
              <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Selamat Datang di <span class="text-green-300">SATRIA</span>
              </h1>
              <p class="text-xl opacity-90 mb-8">
                SISTEM AKUNTABILITAS TATA RUANG INOVATIF ADAPTIF
              </p>
            </div>

            <!-- Features -->
            <div class="space-y-4">
              <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-300 text-lg"></i>
                <span class="text-lg">Akses terintegrasi ke semua layanan</span>
              </div>
              <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-300 text-lg"></i>
                <span class="text-lg">Keamanan data terjamin</span>
              </div>
              <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-300 text-lg"></i>
                <span class="text-lg">Antarmuka yang user-friendly</span>
              </div>
              <div class="flex items-center space-x-3">
                <i class="fas fa-check-circle text-green-300 text-lg"></i>
                <span class="text-lg">Dukungan 24/7 untuk administrator</span>
              </div>
            </div>
          </div>

          <!-- Right Side - Login Form -->
          <div class="flex justify-center lg:justify-end" data-aos="fade-left">
            <div class="login-card rounded-2xl shadow-2xl p-8 w-full max-w-md">
              <div class="text-center mb-8">
                <h2
                  class="text-2xl font-bold text-gray-800 dark:text-white mb-2"
                >
                  Masuk ke Akun Anda
                </h2>
                <p class="text-gray-600 dark:text-gray-300">
                  Silakan masuk dengan kredensial Anda
                </p>
              </div>

              <?php if (session()->getFlashdata('error')) : ?>
                <div class="mb-4 p-4 rounded-xl bg-red-500 text-white flex items-center space-x-2">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
              <?php endif; ?>

              <?php if (session()->getFlashdata('success')) : ?>
                <div class="mb-4 p-4 rounded-xl bg-green-500 text-white flex items-center space-x-2">
                    <i class="fas fa-check-circle"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
              <?php endif; ?>

              <form action="<?= base_url('login') ?>" method="post" class="space-y-6">
                <?= csrf_field() ?>
                <!-- Username/Email Field -->
                <div class="relative">
                  <div class="relative">
                    <input
                      type="text"
                      id="username"
                      name="username"
                      class="w-full p-4 pt-6 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                      required
                    />
                    <label
                      for="username"
                      class="floating-label absolute left-4 top-1/2 text-gray-500 dark:text-gray-400 pointer-events-none"
                    >
                      <i class="fas fa-user mr-2"></i>Username atau Email
                    </label>
                  </div>
                </div>

                <!-- Password Field -->
                <div class="relative">
                  <div class="relative">
                    <input
                      type="password"
                      id="password"
                      name="password"
                      class="w-full p-4 pt-6 border border-gray-300 dark:border-gray-600 rounded-xl dark:bg-gray-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all"
                      required
                    />
                    <label
                      for="password"
                      class="floating-label absolute left-4 top-1/2 text-gray-500 dark:text-gray-400 pointer-events-none"
                    >
                      <i class="fas fa-lock mr-2"></i>Password
                    </label>
                    <button
                      type="button"
                      id="toggle-password"
                      class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300"
                    >
                      <i class="fas fa-eye"></i>
                    </button>
                  </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                  <label class="flex items-center">
                    <input
                      type="checkbox"
                      id="remember"
                      name="remember"
                      class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                    />
                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                      Ingat saya
                    </span>
                  </label>
                  <a
                    href="#"
                    class="text-sm text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 transition-colors"
                  >
                    Lupa password?
                  </a>
                </div>

                <!-- Login Button -->
                <button
                  type="submit"
                  class="btn-gradient w-full text-white font-bold py-4 px-6 rounded-xl shadow-lg transition-all"
                >
                  <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>

                <!-- Divider -->
                <div class="relative flex items-center justify-center">
                  <div
                    class="border-t border-gray-300 dark:border-gray-600 flex-grow"
                  ></div>
                  <span class="mx-4 text-sm text-gray-500 dark:text-gray-400"
                    >atau</span
                  >
                  <div
                    class="border-t border-gray-300 dark:border-gray-600 flex-grow"
                  ></div>
                </div>

                <!-- Alternative Login Methods -->
                <div class="grid grid-cols-2 gap-4">
                  <button
                    type="button"
                    class="flex items-center justify-center space-x-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                  >
                    <i class="fab fa-google text-red-500"></i>
                    <span>Google</span>
                  </button>
                  <button
                    type="button"
                    class="flex items-center justify-center space-x-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 py-3 px-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                  >
                    <i class="fas fa-id-card text-blue-500"></i>
                    <span>SSO</span>
                  </button>
                </div>

                <!-- Register Link -->
                <div class="text-center">
                  <p class="text-gray-600 dark:text-gray-300">
                    Belum punya akun?
                    <a
                      href="#"
                      class="text-green-600 hover:text-green-700 dark:text-green-400 dark:hover:text-green-300 font-medium transition-colors"
                    >
                      Daftar di sini
                    </a>
                  </p>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-8">
      <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row justify-between items-center">
          <div class="mb-4 md:mb-0">
            <p class="text-sm">
              © 2025 SATRIA - Sistem Administrasi Terpadu | Pemerintah Kota
              Tomohon
            </p>
          </div>

          <div class="flex space-x-6 text-sm">
            <a href="#" class="hover:text-green-400 transition-colors"
              >Kebijakan Privasi</a
            >
            <a href="#" class="hover:text-green-400 transition-colors"
              >Bantuan</a
            >
            <a href="#" class="hover:text-green-400 transition-colors"
              >Kontak</a
            >
          </div>
        </div>
      </div>
    </footer>

    <script>
      // Theme Toggle
      document.addEventListener("DOMContentLoaded", function () {
        // Check for saved theme or default to light
        const currentTheme = localStorage.getItem("theme") || "light";

        if (currentTheme === "dark") {
          document.body.classList.remove("light-mode");
          document.body.classList.add("dark-mode");
          updateThemeIcons("dark");
        } else {
          document.body.classList.remove("dark-mode");
          document.body.classList.add("light-mode");
          updateThemeIcons("light");
        }

        // Theme toggle button
        document
          .getElementById("theme-toggle")
          .addEventListener("click", function () {
            if (document.body.classList.contains("light-mode")) {
              document.body.classList.remove("light-mode");
              document.body.classList.add("dark-mode");
              localStorage.setItem("theme", "dark");
              updateThemeIcons("dark");
            } else {
              document.body.classList.remove("dark-mode");
              document.body.classList.add("light-mode");
              localStorage.setItem("theme", "light");
              updateThemeIcons("light");
            }
          });

        // Update theme icons
        function updateThemeIcons(theme) {
          const themeToggle = document.getElementById("theme-toggle");
          const sunIcon = themeToggle.querySelector(".fa-sun");
          const moonIcon = themeToggle.querySelector(".fa-moon");

          if (theme === "dark") {
            sunIcon.classList.add("hidden");
            moonIcon.classList.remove("hidden");
          } else {
            sunIcon.classList.remove("hidden");
            moonIcon.classList.add("hidden");
          }
        }

        // Password visibility toggle
        document
          .getElementById("toggle-password")
          .addEventListener("click", function () {
            const passwordInput = document.getElementById("password");
            const icon = this.querySelector("i");

            if (passwordInput.type === "password") {
              passwordInput.type = "text";
              icon.classList.remove("fa-eye");
              icon.classList.add("fa-eye-slash");
            } else {
              passwordInput.type = "password";
              icon.classList.remove("fa-eye-slash");
              icon.classList.add("fa-eye");
            }
          });

        // Floating label animation
        const inputs = document.querySelectorAll(
          'input[type="text"], input[type="password"]'
        );
        inputs.forEach((input) => {
          const parent = input.parentElement;

          input.addEventListener("focus", () => {
            parent.parentElement.classList.add("input-focused");
          });

          input.addEventListener("blur", () => {
            if (input.value === "") {
              parent.parentElement.classList.remove("input-focused");
            }
          });

          // Check on page load if input has value
          if (input.value !== "") {
            parent.parentElement.classList.add("input-focused");
          }
        });
      });
    </script>
  </body>
</html>
