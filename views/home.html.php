<div class="d-none d-sm-block" id="calendar" style="">
  <?php foreach($evenementsByTpe as $type => $evenements): ?>
  <div class="mb-3">
  <div class="cal-header">
      <div class="cal-titre cal-titre-header h5">
        <?php echo $type ?>
        <span class="">
          <a href="<?php echo Base::instance()->alias('home') ?>?annee=<?php echo $year-1; ?>&<?php echo Base::instance()->get('activefiltersparams'); ?>" class="opacity-25"><small class="bi bi-chevron-left small"></small></a>
          <small class="bi bi-calendar"></small> <?php echo $year ?>
          <a href="<?php echo Base::instance()->alias('home') ?>?annee=<?php echo $year+1; ?>&<?php echo Base::instance()->get('activefiltersparams'); ?>" class="opacity-25"><small class="bi bi-chevron-right small"></small></a>
        </span>
      </div>
      <div class="cal-ligne cal-ligne-head">
        <?php
          $date = new DateTime("$year-01-01");
          for($i = 0; $i < Models\Evenement::$displayMonths; $i++):
        ?>
        <div class="cal-month text-center" data-nbdays="<?php echo ($date->format('t')); ?>">
            <?php echo Models\Evenement::$months[$date->format('F')]; ?>
        </div>
        <?php
          $date->modify('next month');
          endfor;
        ?>
    </div>
  </div>
  <div class="cal-events">
    <?php $hasTitre = false; ?>
    <?php foreach ($evenements as $nom => $evts): $evenement = current($evts); ?>
      <div class="cal-ligne">
      <div class="cal-titre" data-bs-toggle="tooltip" data-bs-html="true" data-bs-title="<strong><?php echo $nom ?></strong><br /><i class='bi bi-calendar'></i> <?php echo \Helpers\MonthTimeline::renderDatelines($evenement) ?><br /><i class='bi bi-buildings'></i> <?php echo implode(', ', $evenement->getNomsOrganismes()) ?><?php if($evenement->liendeclaration): ?><br /><i class='bi bi-globe'></i> <?php echo $evenement->liendeclaration ?><?php endif; ?>" data-bs-placement="right" data-bs-custom-class="tooltip-app">
        <a class="cal-titre-txt" href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id], Base::instance()->get('activefiltersparams')) ?>"><i class='bi bi-file-earmark opacity-25'></i> <i class='bi bi-eye d-none'></i> <?php echo $evenement->getNomCourt(); ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn btn-sm btn-warning px-1 py-0 me-2 mt-2 float-end">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
      </div>
      <?php
        $date = new DateTime("$year-01-01");
        for($i = 0; $i < Models\Evenement::$displayMonths; $i++):
      ?>
      <div class="cal-month">
        <?php echo \Helpers\MonthTimeline::render($date, $today, $evts); ?>
      </div>
      <?php
        $date->modify('next month');
        endfor;
      ?>
    </div>
    <?php endforeach; ?>
  </div>
  </div>
  <?php endforeach; ?>
</div>

<div class="d-sm-none ps-3 pe-2">
  <?php include __DIR__.'/timeline.html.php' ?>
</div>

<script>
  document.getElementById('calendar').addEventListener('click', function (e) {
    if (e.target.classList.contains('active')) {
      let ligne = e.target.closest('.cal-ligne')
      if (! ligne) {
        console.warn('Pas d\'entête...')
        return false
      }

      link = ligne.querySelector('a.cal-titre-txt')
      if (! link) {
        console.warn('Pas de lien...')
        return false
      }

      link.click()
    }
  })
</script>
