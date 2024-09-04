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
    <?php
      $themePath = Base::instance()->get('THEME');
      if ($themePath) {
        include($themePath.'/css.php');
      }
    ?>
</head>
<body>
  <div class="container-fluid">

    <header class="d-flex">
      <a href="/" class="text-start <?php if (! $themePath): ?>mt-5 pt-5<?php endif; ?>">
        <?php if ($themePath) {include($themePath.'/header.php');} ?>
      </a>
      <div class="m-auto">
        <strong class="text-uppercase align-middle">déclarations viti/vinicoles</strong>
      </div>
    </header>

    <div class="row">

      <?php if (Base::instance()->get('URI') != '/admin'): ?>
      <div id="sidebar" class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary d-none d-lg-block">
        <?php \Helpers\Sidebar::instance()->render(); ?>
      </div>
      <div class="d-lg-none">
        <div class="d-flex justify-content-center">
          <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNav" aria-expanded="false" aria-controls="collapseNav">
            Dérouler les options
          </button>
        </div>
        <div class="collapse" id="collapseNav">
          <div class="card card-body">
            <nav id="sidenav-1" data-mdb-sidenav-init class="sidenav d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" data-mdb-hidden="false">
              <?php \Helpers\Sidebar::instance()->render(); ?>
            </nav>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div id="main" class="d-none d-lg-block <?php if (Base::instance()->get('mainCssClass')) echo implode(" ", Base::instance()->get('mainCssClass')) ?>">
        <?php include __DIR__.'/'.Base::instance()->get('content') ?>
      </div>
      <div id="timeline" class="d-flex justify-content-center mt-2" style="padding-bottom: 100px">
        <?php include __DIR__.'/'.Base::instance()->get('timeline') ?>
      </div>
    </div>
  </div>

  <footer id="footer" class="text-center" style="color: #fff; background-color: #18142f">
    <a href="/" class="text-start <?php if (! $themePath): ?>mt-5 pt-5<?php endif; ?>"><?php if ($themePath) {include($themePath.'/footer.php');} ?></a>
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
          <a class="nav-link" id="nav-link-admin" href="<?php echo Base::instance()->alias('login') ?>"><i class="fas fa-user-lock"></i> Administration</a>
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
