<div class="d-none d-sm-block" id="calendar">
  <?php foreach($evenementsByTpe as $type => $evenements): ?>
  <div class="mb-3">
  <div class="cal-header">
      <div class="cal-titre cal-titre-header h5"><?php echo $type ?> <span class=""><a href="" class="opacity-25"><small class="bi bi-chevron-left small"></small></a> <small class="bi bi-calendar"></small> 2024 <a href="" class="opacity-25"><small class="bi bi-chevron-right small"></small></a></span></div>
      <div class="cal-ligne cal-ligne-head">
        <?php
          $date = new DateTime("2024-01-01");
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
      <div class="cal-titre" title="<?php echo $nom ?>">
        <a class="cal-titre-txt" href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id], Base::instance()->get('activefiltersparams')) ?>"><?php echo $nom ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn btn-sm btn-warning px-1 py-0 me-2 mt-2 float-end">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
      </div>
      <?php
        $date = new DateTime("2024-01-01");
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

<div class="d-sm-none">
  <?php include __DIR__.'/timeline.html.php' ?>
</div>

<script>
  document.getElementById('calendar').addEventListener('click', function (e) {
    if (e.target.classList.contains('active')) {
      const ligne = e.target.closest('.cal-ligne')
      if (! ligne) {
        console.warn('Pas d\'entête...')
        return false
      }

      const link = ligne.querySelector('a.cal-titre-txt')
      if (! link) {
        console.warn('Pas de lien...')
        return false
      }

      link.click()
    }
  })
</script>
