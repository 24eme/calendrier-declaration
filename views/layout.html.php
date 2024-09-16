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
      if (Base::instance()->get('theme')) {
        $themePath = implode(DIRECTORY_SEPARATOR, [Base::instance()->get('ROOT'), 'themes', Base::instance()->get('theme')]);
        include($themePath.'/css.php');
      } else {
        $themePath = null;
      }
    ?>
</head>
<body>
  <div class="container-fluid" style="height: 100%;">

    <header class="d-flex">
      <a href="/" class="text-start <?php if (! isset($themePath)): ?>mt-5 pt-5<?php endif; ?>">
        <?php if (isset($themePath)) {include($themePath.'/header.php');} ?>
      </a>
      <div class="m-auto">
        <strong class="text-uppercase align-middle">déclarations viti/vinicoles</strong>
      </div>
    </header>

    <div class="row" style="height: 100%;">

      <?php if (Base::instance()->get('URI') != '/admin'): ?>
      <div id="sidebar" class="d-flex flex-column flex-shrink-0 border-end d-none d-lg-block" style="height: 100%;">
        <?php \Helpers\Sidebar::instance()->render(); ?>
      </div>
      <div class="">
        <div class="d-flex justify-content-center">
          <button class="btn btn-primary mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNav" aria-expanded="false" aria-controls="collapseNav">
            Voir les filtres
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

      <div id="main" class="<?php if (Base::instance()->get('mainCssClass')) echo implode(" ", Base::instance()->get('mainCssClass')) ?>">
        <?php
          $route = 'home';
          if (strpos(Base::instance()->get('URI'), '/evenements') !== false) {
            $route = 'events';
          }
          if (strpos(Base::instance()->get('URI'), '/chronologie') !== false) {
              $route = 'chronologie';
          }
        ?>
        <?php if (Base::instance()->get('URI') != '/admin'): ?>
        <ul class="nav nav-tabs justify-content-center mb-4">
          <li class="nav-item">
            <a class="fs-5 nav-link<?php if($route == 'home'): ?> active<?php endif ?>" aria-current="page" href="<?php echo Base::instance()->alias('home') ?>?<?php echo Base::instance()->get('activefiltersparams'); ?>"><i class="bi bi-calendar2"></i> Calendrier</a>
          </li>
          <li class="nav-item">
            <a class="fs-5 nav-link<?php if($route == 'chronologie'): ?> active<?php endif ?>" href="<?php echo Base::instance()->alias('timeline') ?>?<?php echo Base::instance()->get('activefiltersparams'); ?>"><i class="bi bi-three-dots-vertical"></i> Chronologie</a>
          </li>
          <li class="nav-item">
            <a class="fs-5 nav-link<?php if($route == 'events'): ?> active<?php endif ?>" href="<?php echo Base::instance()->alias('events') ?>?<?php echo Base::instance()->get('activefiltersparams'); ?>"><i class="bi bi-list"></i> Liste</a>
          </li>
        </ul>
        <?php endif; ?>
        <?php include __DIR__.'/'.Base::instance()->get('content') ?>
      </div>
      <?php if (strpos(Base::instance()->get('URI'), '/admin') === false): ?>
      <div id="timeline" class="d-flex justify-content-center mt-3 ms-1" style="padding-bottom: 100px">
        <?php include __DIR__.'/timeline.html.php' ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

  <footer id="footer" class="text-center" style="color: #fff; background-color: #18142f">
      <?php if ($themePath) {include($themePath.'/footer.php');} ?>
  </footer>

  <script src="/js/quill.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
