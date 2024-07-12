<div class="ligne">
  <?php for($j = 1; $j <= $nbDays; $j++): ?>
    <span title="<?php echo $current->format("d/m/Y") ?>"
        class="<?php echo \Views\MonthTimeline::getTimelineClass($events, $current, $today) ?>"
        style="width: <?php echo round(100 / $nbDays, 2) ?>%;"></span>

    <?php $current->modify('+1 day'); ?>
  <?php endfor; ?>
</div>
