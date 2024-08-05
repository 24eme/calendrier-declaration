<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Déclaration</th>
      <th>Échéances</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($evenements as $evenement): ?>
    <tr>
      <td><a href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id]) ?>?from=event"><?php echo $evenement->nom ?></a></td>
      <td><?php echo \Views\MonthTimeline::renderDatelines($evenement); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
