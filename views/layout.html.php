<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendrier des déclarations viti/vinicoles</title>
    <link rel="shortcut icon" href="/images/logos/logo-P.svg" >

    <link href='/css/bootstrap.min.css' rel='stylesheet' />
    <link rel="stylesheet" href="/css/bootstrap-icons.min.css">
    <link href="/css/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
  <div class="w-100">
    <div class="d-flex align-items-center">
      <a href="/"><img src="/images/logos/logo-P.svg" alt="logo" /></a>
      <a href="/">
        <i class="bi bi-caret-right-fill"></i>
        <span class="fw-bold">déclarations viti/vinicoles</span><br />
        <small class="ps-3 ms-1" title="Conseil Interprofessionnel des Vins de Provence">mises à disposition par le CIVP</small><br  />
        <small class="ps-3 ms-1">à titre indicatif*</small>
      </a>
    </div>
  </div>

  <div class="container-fluid">
    <div class="row">
      <div class="offcanvas-lg col-2" tabindex="-1" id="offcanvas-sidebar" aria-labelledby="offcanvas sidebar">
        <div id="sideNavigation" class="bg-light h-100 border-end border-2 p-1">
          <?php Views\Sidebar::instance()->render(); ?>
        </div>
      </div>

      <div id="main" class="<?php echo implode(" ", Base::instance()->get('mainCssClass')) ?>">
        <button class="btn btn-primary d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-sidebar" aria-controls="offcanvas-sidebar">
          <i class="bi bi-filter"></i> Ouvrir les filtres
        </button>
        <?php include __DIR__.'/'.Base::instance()->get('content') ?>
      </div>
    </div>
  </div>

  <footer id="footer" class="text-center" style="color: #fff; background-color: #18142f">
    <a href="/"><img src="https://calendrier-vitivini.vinsdeprovence.com/images/logos/civp.png" height=200  alt=""></a>
    <div class="footer-links container">
      <ul class="footer-nav list-unstyled mx-2" role="menubar">
        <li class="nav-item d-inline-block" id="nav-item-civp" role="menuitem">
          <a class="nav-link" id="nav-link-civp" href="https://www.vinsdeprovence.com/civp">CIVP</a>
        </li>
        <li class="nav-item d-inline-block mx-2" id="nav-item-contact" role="menuitem">
          <a class="nav-link" id="nav-link-contact" href="https://www.vinsdeprovence.com/contact">Contact</a>
        </li>
        <li class="nav-item d-inline-block mx-2" id="nav-item-mentions-legales" role="menuitem">
          <a class="nav-link" id="nav-link-mentions-legales" href="https://calendrier-vitivini.vinsdeprovence.com/mentions-legales">Mentions légales</a>
        </li>
        <li class="nav-item d-inline-block mx-2" id="nav-item-admin" role="menuitem">
          <a class="nav-link" id="nav-link-admin" href="https://calendrier-vitivini.vinsdeprovence.com/admin"><i class="fas fa-user-lock"></i> Administration</a>
        </li>
      </ul>
    </div>
    <hr>
    <div class="footer-disclaimer">
      <div class="container">
        <a href="https://www.vinsdeprovence.com" class="text-light" target="_blank">www.vinsdeprovence.com</a>
      </div>
    </div>
  </footer>

  <script src="/js/quill.js"></script>
</body>
</html>

