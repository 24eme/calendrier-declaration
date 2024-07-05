<h3>Hello world</h3>

<div id="calendrierVue">

<?php
?>
  <div class="row" style="width: 93%; margin: 30px 0;">
    <?php
      for($m = 1; $m<=12; $m++) {
        $month = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
        echo strtoupper("<div class='span5' style='margin: 0 auto; display: inline-block; font-size: 18px; font-weight: 900; width: 90px; padding: 0; text-align: center;'> {$month} </div>");
      }
    ?>
  </div>

  <?php foreach ($evenements as $titre => $evts): ?>
  <?php echo $titre ?>
  <div class="ligne pb-2">
    <?php
      $annee = date('Y');
      $date = strtotime($annee.'-01-01');
      while (date('Y', $date) == $annee):
        $dateSuivante = strtotime('+1 day', $date);
        $isEventDate = false;
        foreach ($evts as $evt) {
          if (date('Y-m-d', $date) >= $evt['start'] && date('Y-m-d', $date) <= $evt['end']) {
            $isEventDate = true;
            break;
          }
        }
    ?>
    <?php if ($isEventDate): ?>
    <a style="background-color: red;" title="<?php echo date('d/m/Y', $date)?>" class="jour<?php if (date('m', $dateSuivante) != date('m', $date)): ?> finMois<?php endif; ?><?php if (date('Y-m-d') == date('Y-m-d', $date)): ?> jourcourant<?php endif; ?>"></a>
    <?php else: ?>
    <a title="<?php echo date('d/m/Y', $date)?>" class="jour<?php if (date('m', $dateSuivante) != date('m', $date)): ?> finMois<?php endif; ?><?php if (date('Y-m-d') == date('Y-m-d', $date)): ?> jourcourant<?php endif; ?>"></a>
    <?php endif; ?>
    <?php
        $date = $dateSuivante;
      endwhile;
    ?>
    </div>
    <br />
    <?php endforeach; ?>

</div>
