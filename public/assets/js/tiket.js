 let baseurl = $("#wrap").data("url")
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

        // Search form submission
        $("#search-form").submit(function (e) {
          e.preventDefault();
          const nomorTiket = $("#nomor_tiket").val().trim();

          console.log("Mencari nomor tiket:", nomorTiket);

          if (nomorTiket) {
            searchTicket(nomorTiket);
          } else {
            alert("Silakan masukkan nomor tiket");
          }
        });

        // New search button
        $("#new-search-button").click(function () {
          resetForm();
        });

        // Try again button
        $("#try-again-button").click(function () {
          resetForm();
        });

        // Print button
        $("#print-button").click(function () {
          window.print();
        });

        // Function to search ticket via AJAX
        function searchTicket(nomorTiket) {
          // Hide all result sections first
          $("#results-section").addClass("hidden");
          $("#no-results-section").addClass("hidden");

          // Show loading state
          $("#search-form button")
            .html('<i class="fas fa-spinner fa-spin mr-2"></i>Mencari...')
            .prop("disabled", true);

          $.ajax({
            url: baseurl + "tiket/lookup",
            type: "POST",
            data: {
              nomor_tiket: nomorTiket,
            },
            dataType: "json",
            success: function (response) {
              // Reset button
              $("#search-form button")
                .html('<i class="fas fa-search mr-2"></i>Cari Data')
                .prop("disabled", false);

              if (response.success) {
                console.log("Data ditemukan:", response.data);
                populateResults(response.data);
                $("#results-section").removeClass("hidden");
              } else {
                console.log("Data tidak ditemukan:", response.message);
                $("#no-results-section").removeClass("hidden");
              }
            },
            error: function (xhr, status, error) {
              // Reset button
              $("#search-form button")
                .html('<i class="fas fa-search mr-2"></i>Cari Data')
                .prop("disabled", false);

              console.error("Error:", error);
              alert("Terjadi kesalahan saat mencari data. Silakan coba lagi.");
            },
          });
        }

        // Function to populate results
        function populateResults(data) {
          // Basic Information
          $("#nomor_tiket_result").text(data.nomor_tiket);
          $("#pemohon_id").text(data.pemohon_id);
          $("#submitted_at").text(data.submitted_at);
          $("#verified_at").text(data.verified_at);

          // Status with appropriate styling
          const statusElement = $("#status");
          statusElement.text(
            data.status === "verified"
              ? "Terverifikasi"
              : data.status === "pending"
              ? "Menunggu Verifikasi"
              : data.status === "rejected"
              ? "Ditolak"
              : data.status
          );

          statusElement.removeClass(
            "status-verified status-pending status-rejected"
          );
          if (data.status === "verified") {
            statusElement.addClass("status-verified");
          } else if (data.status === "pending") {
            statusElement.addClass("status-pending");
          } else if (data.status === "rejected") {
            statusElement.addClass("status-rejected");
          }

          // Location Information
          $("#alamat_lokasi").text(data.alamat_lokasi);
          $("#kelurahan").text(data.kelurahan);
          $("#kecamatan").text(data.kecamatan);
          $("#koordinat").text(`${data.koordinat_lat}, ${data.koordinat_lng}`);

          // Zoning Information
          $("#zona_rtrw").text(data.zona_rtrw);
          $("#kdb").text(data.kdb);
          $("#klb").text(data.klb);
          $("#luas_tanah").text(`${data.luas_tanah} m²`);

          // Building Information
          $("#jenis_bangunan").text(data.jenis_bangunan);
          $("#tinggi_bangunan").text(`${data.tinggi_bangunan} m`);
          $("#luas_bangunan").text(`${data.luas_bangunan} m²`);
          $("#jumlah_lantai").text(data.jumlah_lantai);

          // Verification Notes
          $("#catatan_verifikasi").text(data.catatan_verifikasi);
        }

        // Function to reset the form
        function resetForm() {
          $("#search-form")[0].reset();
          $("#results-section").addClass("hidden");
          $("#no-results-section").addClass("hidden");
          $("#nomor_tiket").focus();
        }
      });