<div class="ligne">
  <?php for($j = 1; $j <= $nbDays; $j++): ?>
    <span title="<?php echo $current->format("d/m/Y") ?>"
        class="<?php echo \Views\MonthTimeline::getTimelineClass($events, $current, $today) ?>"></span>

    <?php $current->modify('+1 day'); ?>
  <?php endfor; ?>
</div>
