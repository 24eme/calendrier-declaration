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
      <td>
        <a href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id]) ?>?referer=event"><?php echo $evenement->nom ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn-warning ms-2 btn btn-sm py-0 px-1">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
      </td>
      <td><?php echo \Views\MonthTimeline::renderDatelines($evenement); ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
