  <div id="calendar">
    <div class="cal-header">
      <div class="cal-titre cal-titre-header"></div>
      <div class="cal-ligne cal-ligne-head shadow-sm">
        <?php
          $date = DateTime::createFromImmutable($today);
          $date->modify('first day of previous month');
          for($i = 0; $i < 16; $i++):
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
      <?php foreach ($evenements as $titre => $evts): ?>
      <div class="cal-ligne">
        <div class="cal-titre" title="<?php echo $titre ?>">
          <?php echo $titre ?>
        </div>
        <?php
          $date = DateTime::createFromImmutable($today);
          $date->modify('first day of previous month');
          for($i = 0; $i < 16; $i++):
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
</div>
