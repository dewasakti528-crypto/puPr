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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    <style>
  :root {
    --blue-50: #E6F1FB; --blue-200: #85B7EB; --blue-600: #185FA5; --blue-800: #0C447C;
    --teal-50: #E1F5EE; --teal-200: #5DCAA5; --teal-600: #0F6E56; --teal-800: #085041;
    --purple-50: #EEEDFE; --purple-200: #AFA9EC; --purple-600: #534AB7; --purple-800: #3C3489;
    --amber-50: #FAEEDA; --amber-200: #EF9F27; --amber-600: #854F0B; --amber-800: #633806;
    --coral-50: #FAECE7; --coral-200: #F0997B; --coral-600: #993C1D; --coral-800: #712B13;
    --gray-50: #F1EFE8; --gray-200: #B4B2A9; --gray-600: #5F5E5A; --gray-800: #444441;
    --text: #1a1a18;
    --text-sec: #5F5E5A;
    --border: rgba(0,0,0,0.12);
    --bg: #ffffff;
  }
  @media (prefers-color-scheme: dark) {
    :root {
      --blue-50: #042C53; --blue-200: #0C447C; --blue-600: #85B7EB; --blue-800: #B5D4F4;
      --teal-50: #04342C; --teal-200: #085041; --teal-600: #5DCAA5; --teal-800: #9FE1CB;
      --purple-50: #26215C; --purple-200: #3C3489; --purple-600: #AFA9EC; --purple-800: #CECBF6;
      --amber-50: #412402; --amber-200: #633806; --amber-600: #EF9F27; --amber-800: #FAC775;
      --coral-50: #4A1B0C; --coral-200: #712B13; --coral-600: #F0997B; --coral-800: #F5C4B3;
      --gray-50: #2C2C2A; --gray-200: #444441; --gray-600: #B4B2A9; --gray-800: #D3D1C7;
      --text: #e8e6df;
      --text-sec: #B4B2A9;
      --border: rgba(255,255,255,0.12);
      --bg: #1a1a18;
    }
  }
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body {
    
  }
  .header {
    background: var(--blue-50);
    border: 1px solid var(--blue-200);
    border-radius: 14px;
    padding: 22px 28px;
    margin-bottom: 32px;
    display: flex;
    align-items: center;
    gap: 18px;
  }
  .header-icon {
    width: 52px; height: 52px;
    background: var(--blue-600);
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
  }
  .header-icon svg { width: 26px; height: 26px; fill: white; }
  .header h1 { font-size: 20px; font-weight: 500; color: var(--blue-800); line-height: 1.3; }
  .header p { font-size: 13px; color: var(--text-sec); margin-top: 4px; }

  .flow-wrap { position: relative; }

  /* Phase row */
  .phase-row {
    display: flex;
    align-items: stretch;
    margin-bottom: 0;
    position: relative;
  }
  .phase-label {
    width: 76px;
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 10px;
    font-size: 11px;
    font-weight: 500;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    writing-mode: vertical-lr;
    text-orientation: mixed;
    transform: rotate(180deg);
    padding: 14px 0;
    margin-right: 20px;
  }
  .phase-label.blue   { background: var(--blue-50);   color: var(--blue-800);   border: 1px solid var(--blue-200); }
  .phase-label.teal   { background: var(--teal-50);   color: var(--teal-800);   border: 1px solid var(--teal-200); }
  .phase-label.purple { background: var(--purple-50); color: var(--purple-800); border: 1px solid var(--purple-200); }
  .phase-label.amber  { background: var(--amber-50);  color: var(--amber-800);  border: 1px solid var(--amber-200); }
  .phase-label.coral  { background: var(--coral-50);  color: var(--coral-800);  border: 1px solid var(--coral-200); }

  .steps-col {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 0;
    padding: 12px 0;
  }

  .step {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 10px 0;
    position: relative;
  }

  .step-num {
    width: 30px; height: 30px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 500;
    flex-shrink: 0;
    margin-top: 2px;
    position: relative;
    z-index: 2;
  }

  .step-body {
    flex: 1;
    border-radius: 10px;
    padding: 14px 18px;
    border: 1px solid;
  }
  .step-body h3 { font-size: 15px; font-weight: 500; line-height: 1.3; }
  .step-body p  { font-size: 13px; margin-top: 4px; line-height: 1.5; }
  .step-note {
    font-size: 12px;
    margin-top: 8px;
    padding: 6px 10px;
    border-radius: 6px;
    display: inline-block;
  }

  /* Color variants */
  .step-body.teal   { background: var(--teal-50);   border-color: var(--teal-200);   }
  .step-body.teal h3 { color: var(--teal-800); }
  .step-body.teal p  { color: var(--teal-600); }
  .step-num.teal  { background: var(--teal-50); border: 1.5px solid var(--teal-200); color: var(--teal-800); }

  .step-body.purple { background: var(--purple-50); border-color: var(--purple-200); }
  .step-body.purple h3 { color: var(--purple-800); }
  .step-body.purple p  { color: var(--purple-600); }
  .step-num.purple { background: var(--purple-50); border: 1.5px solid var(--purple-200); color: var(--purple-800); }

  .step-body.amber { background: var(--amber-50); border-color: var(--amber-200); }
  .step-body.amber h3 { color: var(--amber-800); }
  .step-body.amber p  { color: var(--amber-600); }
  .step-num.amber { background: var(--amber-50); border: 1.5px solid var(--amber-200); color: var(--amber-800); }

  .step-body.coral { background: var(--coral-50); border-color: var(--coral-200); }
  .step-body.coral h3 { color: var(--coral-800); }
  .step-body.coral p  { color: var(--coral-600); }
  .step-num.coral { background: var(--coral-50); border: 1.5px solid var(--coral-200); color: var(--coral-800); }

  .step-body.gray { background: var(--gray-50); border-color: var(--gray-200); }
  .step-body.gray h3 { color: var(--gray-800); }
  .step-body.gray p  { color: var(--gray-600); }
  .step-num.gray { background: var(--gray-50); border: 1.5px solid var(--gray-200); color: var(--gray-800); }

  /* Connector line between steps */
  .connector {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 0 0 0 0;
  }
  .conn-dot-col {
    width: 30px;
    display: flex;
    justify-content: center;
    flex-shrink: 0;
  }
  .conn-line {
    width: 2px;
    height: 24px;
    background: var(--border);
    border-radius: 1px;
  }
  .conn-arrow {
    width: 0; height: 0;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    border-top: 7px solid var(--gray-200);
    margin: 0 auto;
  }

  /* Decision box */
  .decision-wrap {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding: 10px 0;
  }
  .decision-icon {
    width: 30px; height: 30px;
    background: var(--amber-50);
    border: 1.5px solid var(--amber-200);
    border-radius: 6px;
    display: flex; align-items: center; justify-content: center;
    font-size: 15px;
    flex-shrink: 0;
    margin-top: 2px;
  }
  .decision-body {
    flex: 1;
    background: var(--amber-50);
    border: 1.5px dashed var(--amber-200);
    border-radius: 10px;
    padding: 14px 18px;
  }
  .decision-body h3 { font-size: 15px; font-weight: 500; color: var(--amber-800); }
  .decision-body p  { font-size: 13px; color: var(--amber-600); margin-top: 4px; }
  .decision-branches {
    display: flex;
    gap: 12px;
    margin-top: 12px;
    flex-wrap: wrap;
  }
  .branch {
    flex: 1;
    min-width: 160px;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 13px;
  }
  .branch-yes { background: var(--teal-50); border: 1px solid var(--teal-200); color: var(--teal-800); }
  .branch-no  { background: var(--coral-50); border: 1px solid var(--coral-200); color: var(--coral-800); }
  .branch strong { display: block; font-weight: 500; margin-bottom: 2px; }

  /* Phase separator label */
  .phase-sep {
    font-size: 11px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--text-sec);
    border-top: 1px solid var(--border);
    padding: 10px 0 2px;
    margin: 8px 0 0;
  }

  /* Start / End pill */
  .pill-step {
    display: flex; justify-content: center;
    padding: 8px 0;
  }
  .pill {
    padding: 10px 36px;
    border-radius: 30px;
    font-size: 15px;
    font-weight: 500;
  }
  .pill.start { background: var(--blue-600); color: white; }
  .pill.end   { background: var(--gray-600); color: white; }

  /* Legend */
  .legend {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 28px;
    padding: 16px 20px;
    background: var(--gray-50);
    border-radius: 10px;
    border: 1px solid var(--border);
  }
  .legend-item {
    display: flex; align-items: center; gap: 7px;
    font-size: 12px; color: var(--text-sec);
  }
  .legend-dot {
    width: 12px; height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
  }

  /* Print */
  @media print {
    body { padding: 12px; }
    .header { break-inside: avoid; }
  }
</style>
  </body>
</html>
