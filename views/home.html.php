<h3>Hello world</h3>

<div id="calendrierVue">

  <div class="container-fluid text-center">
    <div class="row sticky-top">
      <?php
        $date = new DateTime();
        $date->modify('-1 month');
        for($i = 0; $i < 12; $i++):
      ?>
      <div class="col-1 bg-warning border-start border-end border-white border-1">
        <?php echo $date->format('M'); ?>
      </div>
      <?php
        $date->modify('+1 month');
        endfor;
      ?>
    </div>

    <?php foreach ($evenements as $titre => $evts): ?>
    <div class="row border-bottom border-start border-end">
      <div class="text-start w-100">
        <?php echo $titre ?>
      </div>
      <?php
        $date = new DateTime();
        $date->modify('-1 month');
        for($i = 0; $i < 12; $i++):
      ?>
      <div class="col-1 px-0 pb-2 border-start border-end border-white border-2">
        <?php echo \Views\MonthTimeline::render($date->format('n'), $evts); ?>
      </div>
      <?php
        $date->modify('+1 month');
        endfor;
      ?>
    </div>
    <?php endforeach; ?>
  </div>

</div>
