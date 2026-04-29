<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usulan Berhasil - KRK Kota Tomohon</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #ef4444, #7c3aed, #3b82f6);
            background-size: 200% 200%;
            animation: gradient 15s ease infinite;
        }
        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }
        @keyframes successPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Header -->
    <header class="gradient-bg text-white py-6 shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex items-center space-x-3">
                <i class="fas fa-map-marked-alt text-3xl"></i>
                <div>
                    <h1 class="text-2xl font-bold">Form Usulan Wilayah KRK</h1>
                    <p class="text-blue-100">Berhasil Diajukan</p>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto px-4 py-12">
        <div class="max-w-2xl mx-auto">
            <!-- Success Card -->
            <div class="bg-white rounded-xl shadow-lg p-8 text-center success-animation">
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-check text-green-500 text-3xl"></i>
                </div>
                
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Usulan Berhasil Dikirim!</h2>
                
                <p class="text-gray-600 mb-8 text-lg">
                    Terima kasih telah mengajukan usulan KRK. Formulir Anda telah diterima dan akan diproses oleh tim kami dalam 3-5 hari kerja.
                </p>

                <!-- Ticket Information -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 mb-8">
                    <h3 class="font-semibold text-blue-800 mb-2">Nomor Tiket Anda:</h3>
                    <div class="text-2xl font-mono font-bold text-blue-600">
                        <?= esc($nomor_tiket) ?>
                    </div>
                    <p class="text-sm text-blue-700 mt-2">
                        Simpan nomor tiket ini untuk tracking status usulan Anda
                    </p>
                </div>

                <!-- Next Steps -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8 text-left">
                    <h3 class="font-semibold text-gray-800 mb-4">Langkah Selanjutnya:</h3>
                    <ol class="space-y-3 text-gray-700">
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Tim kami akan memverifikasi data yang Anda kirimkan</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Proses verifikasi memakan waktu 3-5 hari kerja</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Anda akan menerima notifikasi melalui email/telepon</span>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-check-circle text-green-500 mt-1 mr-3"></i>
                            <span>Gunakan nomor tiket untuk tracking status usulan</span>
                        </li>
                    </ol>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <button onclick="window.print()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-6 rounded-lg transition-colors">
                        <i class="fas fa-print mr-2"></i>Cetak Tiket
                    </button>
                    <a href="<?= base_url('/') ?>" class="btn-gradient text-white font-bold py-3 px-6 rounded-lg shadow-lg text-center">
                        <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                    </a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mt-8 text-center text-gray-600">
                <p class="mb-2">Butuh bantuan? Hubungi kami:</p>
                <div class="flex justify-center space-x-4">
                    <a href="tel:+628123456789" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-phone mr-1"></i> +62 812-3456-789
                    </a>
                    <a href="mailto:info@tomohon.go.id" class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-envelope mr-1"></i> info@tomohon.go.id
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; <?= date('Y') ?> Pemerintah Kota Tomohon. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>