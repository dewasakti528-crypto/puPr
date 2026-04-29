<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SmartGIS - Perencanaan Pembangunan</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Mapbox GL JS -->
    <link
      href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css"
      rel="stylesheet"
    />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Font Awesome -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
    />

    <!-- AOS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <link rel="stylesheet" href="<?=base_url('assets/css/'.$page .  "-v" . env('app.version').'.css')?>">
  </head>
  <body id="wrap" data-url="<?=base_url()?>" class="light-mode transition-all">
    <?=$this->include("frontend/template/navbar")?>
    
    <?= $this->renderSection('content') ?>

    <?= $this->include('frontend/template/footer') ?>

    <script src="<?=base_url('assets/js/'.$page .  "-v" . env('app.version') .'.js')?>"></script> </script>
  </body>
</html>
