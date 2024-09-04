<div class="ms-xs-5 ms-sm-3" id="calendar">
  <div class="cal-header">
    <div class="cal-titre cal-titre-header"></div>
    <div class="cal-ligne cal-ligne-head shadow-sm">
      <?php
        $date = DateTime::createFromImmutable($today);
        $date->modify('first day of previous month');
        for($i = 0; $i < Models\Evenement::$displayMonths; $i++):
      ?>
      <div class="cal-month d-none d-lg-block" data-nbdays="<?php echo ($date->format('t')); ?>">
        <?php echo $date->format('M Y'); ?>
      </div>
      <?php
        $date->modify('next month');
        endfor;
      ?>
    </div>
  </div>
  <div class="cal-events d-none d-lg-block">
    <?php foreach ($evenements as $nom => $evts): $evenement = current($evts); ?>
    <div class="cal-ligne">
      <div class="cal-titre" title="<?php echo $nom ?>">
        <a class="cal-titre-txt" href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id], Base::instance()->get('activefiltersparams')) ?>"><?php echo $nom ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn btn-sm btn-warning px-1 py-0 mt-1 float-end">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
      </div>
      <?php
        $date = DateTime::createFromImmutable($today);
        $date->modify('first day of previous month');
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
