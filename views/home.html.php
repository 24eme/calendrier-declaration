<div id="calendrierVue" style="width: max-content; ">
    <div class="cal-ligne cal-ligne-head">
      <div class="cal-titre">
      </div>
      <?php
        $date = new DateTime(date('Y-m-d'));
        $date->modify('first day of previous month');
        for($i = 0; $i < 16; $i++):
      ?>
      <div class="cal-month" style="width: <?php echo ($date->format('t')+1)*3; ?>px;">
        <?php echo $date->format('M Y'); ?>
      </div>
      <?php
        $date->modify('next month');
        endfor;
      ?>
    </div>

    <?php foreach ($evenements as $titre => $evts): ?>
    <div class="cal-ligne">
      <div class="cal-titre">
        <?php echo $titre ?>
      </div>
      <?php
        $date = new DateTime();
        $date->modify('first day of previous month');
        for($i = 0; $i < 16; $i++):
      ?>
      <div class="cal-month">
        <?php echo \Views\MonthTimeline::render($date, $evts); ?>
      </div>
      <?php
        $date->modify('next month');
        endfor;
      ?>
    </div>
    <?php endforeach; ?>
</div>
