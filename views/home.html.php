<div id="calendar">
  <div class="cal-header">
    <div class="cal-titre cal-titre-header"></div>
    <div class="cal-ligne cal-ligne-head shadow-sm">
      <?php
        $date = DateTime::createFromImmutable($today);
        $date->modify('first day of previous month');
        for($i = 0; $i < Models\Evenement::$displayMonths; $i++):
      ?>
      <div class="cal-month" data-nbdays="<?php echo ($date->format('t')); ?>">
        <?php echo $date->format('M Y'); ?>
      </div>
      <?php
        $date->modify('next month');
        endfor;
      ?>
    </div>
  </div>
  <div class="cal-events">
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

  <div id="timeline" class="mt-5" style="padding-bottom: 100px">
      <ul class="timeline">
          <li class="timeline-item">
              <div class="timeline-body">
                  <div class="timeline-meta">
                      Aujourd'hui
                      <span class="text-body-secondary"><?php echo $today->format('d m Y') ?></span>
                  </div>
                  <div class="timeline-content">
                      <h6>Vous pouvez déclarer :</h6>
                      <ul>
                        <?php foreach ($timeline['today'] as $nom => $event): ?>
                            <li>
                                <a href="<?php echo Base::instance()->alias('event', ['evenement' => $event->id], Base::instance()->get('activefiltersparams')) ?>">
                                    <?php echo $nom ?>
                                </a>
                                <?php if ($event->liendeclaration): ?>
                                    <a href="<?php echo $event->liendeclaration ?>">
                                        <i class="ms-1 bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
                                    </a>
                                <?php endif ?>
                            </li>
                        <?php endforeach ?>
                      </ul>
                  </div>
              </div>
          </li>
          <?php foreach ($timeline['events'] as $date => $events): ?>
          <li class="timeline-item">
              <div class="timeline-body">
                  <div class="timeline-meta"><?php echo DateTime::createFromFormat('Y-m-d', $date)->format("d M Y") ?></div>
                  <div class="timeline-content">
                      <?php foreach ($events as $e): ?>
                        <?php if ($e->date_debut === $date): ?>
                            <div class="opacity-50 pb-3">
                                Ouverture de : <?php echo $e->nom ?>
                            </div>
                        <?php else: ?>
                            <div class="pb-3">
                                Fermeture de : <?php echo $e->nom ?><br/>
                                <span class="opacity-50">Ouvert depuis le : <?php echo DateTime::createFromFormat('Y-m-d', $e->date_debut)->format("d F Y") ?></span>
                            </div>
                        <?php endif ?>
                      <?php endforeach ?>
                  </div>
              </div>
          </li>
          <?php endforeach ?>
      </ul>
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
