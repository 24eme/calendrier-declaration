<div class="px-3">
<table class="table table-bordered table-striped table-hover table-sm">
  <thead>
    <tr>
      <th>Déclarations</th>
      <th>Déclencheur</th>
      <th>Échéances</th>
      <?php if(Base::instance()->get('SESSION.user')): ?><th></th><?php endif ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($evenements as $evenement): ?>
    <tr>
      <td>
        <a href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id]) ?>?referer=event&<?php echo Base::instance()->get('activefiltersparams'); ?>"><?php echo $evenement->nom ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn-warning ms-2 btn btn-sm py-0 px-1">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
      </td>
      <td><?php echo $evenement->element_declencheur; ?></td>
      <td><?php echo \Helpers\MonthTimeline::renderDatelines($evenement); ?></td>
      <?php if(Base::instance()->get('SESSION.user')): ?>
        <td>
          <a href="<?php echo Base::instance()->alias('eventedit', ['evenement' => $evenement->id]) ?>"><i class="bi bi-pencil-square"></i></a>
        </td>
      <?php endif ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div>
