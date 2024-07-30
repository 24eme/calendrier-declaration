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
      <?php foreach ($evenements as $nom => $evts): ?>
      <div class="cal-ligne">
        <div class="cal-titre" title="<?php echo $nom ?>">
          <a href="<?php echo Base::instance()->alias('event', ['evenement' => current($evts)['id']]) ?>"><?php echo $nom ?></a>
        </div>
        <?php
          $date = DateTime::createFromImmutable($today);
          $date->modify('first day of previous month');
          for($i = 0; $i < Models\Evenement::$displayMonths; $i++):
        ?>
        <div class="cal-month">
          <?php echo \Views\MonthTimeline::render($date, $today, $evts); ?>
        </div>
        <?php
          $date->modify('next month');
          endfor;
        ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
