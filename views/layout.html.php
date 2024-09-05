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

      <div id="main" class="d-none d-lg-block <?php if (Base::instance()->get('mainCssClass')) echo implode(" ", Base::instance()->get('mainCssClass')) ?>">
        <?php
          $route = 'home';
          if (strpos(Base::instance()->get('URI'), '/evenements') !== false) {
              $route = 'events';
          }
        ?>
        <div>
          <?php if ($route == 'home'): ?>
            <a class="btn btn-outline-primary mb-3" href="<?php echo Base::instance()->alias('events') ?>?<?php echo Base::instance()->get('activefiltersparams'); ?>" role="button"><i class="bi bi-list"></i> Vue liste</a>
            <?php $titre = "Calendrier"; ?>
          <?php else: ?>
            <a class="btn btn-outline-primary mb-3" href="<?php echo Base::instance()->alias('home') ?>?<?php echo Base::instance()->get('activefiltersparams'); ?>" role="button"><i class="bi bi-calendar-week"></i> Vue calendrier</a>
            <?php $titre = "Liste des évènements"; ?>
          <?php endif; ?>
        </div>
        <div class="d-flex justify-content-center mb-3">
          <h2><?php echo $titre; ?></h2>
        </div>
        <?php include __DIR__.'/'.Base::instance()->get('content') ?>
      </div>
      <?php if ($route == 'home'): ?>
        <div class="d-flex justify-content-center mb-3">
          <h2>Chronologie</h2>
        </div>
        <div id="timeline" class="d-flex justify-content-center mt-3 ms-1" style="padding-bottom: 100px">
          <?php include __DIR__.'/'.Base::instance()->get('timeline') ?>
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
