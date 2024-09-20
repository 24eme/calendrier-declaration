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
        $themePath = implode(DIRECTORY_SEPARATOR, [Base::instance()->get('ROOT'), 'themes', Base::instance()->get('theme')]).'/';
        include($themePath.'css.php');
      } else {
        $themePath = null;
      }
    ?>
</head>
<body>
  <div style="min-height: 80vh;">
    <?php if (strpos(Base::instance()->get('URI'), '/pages') === false): ?>
    <div class="d-sm-none">
        <header class="text-center">
        <?php if (isset($themePath)) {include($themePath.'/header.php');} ?>
        </header>

        <button class="btn btn-light mt-3 mb-2 d-block w-75 d-sm-none m-auto text-center" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar" aria-expanded="false" aria-controls="sidebar">
          <i class="bi bi-list"></i> Voir les filtres
        </button>
    </div>
    <?php endif; ?>
    <div class="d-sm-flex">
      <?php if (strpos(Base::instance()->get('URI'), '/pages') === false): ?>
      <div id="sidebar" class="d-sm-flex flex-column flex-shrink-0 border-end px-3 collapse">
        <header class="text-center mb-5 d-none d-sm-block">
          <?php if (isset($themePath)) {include($themePath.'/header.php');} ?>
        </header>
        <?php \Helpers\Sidebar::instance()->render(); ?>
      </div>
      <?php endif; ?>

      <div id="main" class="mt-4 <?php if (Base::instance()->get('mainCssClass')) echo implode(" ", Base::instance()->get('mainCssClass')) ?>">
        <span class="ms-4"><i class="bi bi-calendar2-event"></i><?php echo str_repeat('&nbsp', 3).str_replace(array_keys(Models\Evenement::$months), array_values(Models\Evenement::$months), date('j F Y'));?></span>
        <?php
          $route = 'home';
          if (strpos(Base::instance()->get('URI'), '/evenements') !== false) {
            $route = 'events';
          }
          if (strpos(Base::instance()->get('URI'), '/chronologie') !== false) {
              $route = 'chronologie';
          }
        ?>
        <?php if ((strpos(Base::instance()->get('URI'), '/admin') === false)&&(strpos(Base::instance()->get('URI'), '/pages') === false)): ?>
        <ul class="nav nav-tabs justify-content-center mb-3 d-none d-sm-flex">
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
        <h2 class="d-block d-sm-none mb-0 px-2 text-center">
          <i class="bi bi-three-dots-vertical"></i>Chronologie
        </h2>
        <div class="px-4">
        <?php include __DIR__.'/'.Base::instance()->get('content') ?>
        </div>
      </div>
      <?php if (strpos(Base::instance()->get('URI'), '/admin') === false): ?>
      <?php endif; ?>
    </div>
  </div>

  <footer id="footer" class="text-center">
      <?php if ($themePath) {include($themePath.'footer.php');} ?>
  </footer>

  <script src="/js/quill.js"></script>
  <script src="/js/bootstrap.bundle.min.js"></script>
</body>
</html>
