<h3>Hello world</h3>

<div id="calendrierVue">

  <div class="container-fluid text-center">
    <div class="row sticky-top">
      <?php for($m = 1; $m<=12; $m++): ?>
      <div class="col-1 bg-warning border-start border-end border-white border-2">
        <?php $month = date('M', mktime(0, 0, 0, $m, 1, date('Y'))); ?>
        <?php echo ucfirst($month); ?>
      </div>
      <?php endfor; ?>
    </div>

    <?php foreach ($evenements as $titre => $evts): ?>
    <div class="row border-bottom border-start border-end">
      <div class="text-start w-100">
        <?php echo $titre ?>
      </div>

      <?php for ($mois = 1; $mois <= 12; $mois++): ?>
        <div class="col-1 px-0 pb-2 border-start border-end border-white border-2">
          <?php echo \Views\MonthTimeline::render($mois, $evts); ?>
        </div>
      <?php endfor; ?>

    </div>
    <?php endforeach; ?>
  </div>

</div>
