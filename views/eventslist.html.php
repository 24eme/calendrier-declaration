<?php if(Base::instance()->get('SESSION.user')): ?>
  <div class="text-end mb-3">
    <a type="button" class="btn btn-primary" href="<?php echo Base::instance()->alias('eventcreate') ?>"><i class="bi bi-calendar-plus"></i> Créer une déclaration</a>
  </div>
<?php endif; ?>
<?php if (!$evenements): ?>
  <?php echo \View::instance()->render('noresult.html.php'); ?>
<?php else: ?>
<table class="table table-bordered table-striped table-hover table-sm">
  <thead>
    <tr>
      <?php if(Base::instance()->get('SESSION.user')): ?><th>Nom court</th><?php endif ?>
      <th>Déclarations</th>
      <th>Déclencheur</th>
      <th>Échéances</th>
      <?php if(Base::instance()->get('SESSION.user')): ?><th></th><?php endif ?>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($evenements as $evenement): ?>
    <tr>
      <?php if(Base::instance()->get('SESSION.user')): ?><td><a href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id]) ?>?referer=event&<?php echo Base::instance()->get('activefiltersparams'); ?>"><?php echo $evenement->nom_court ?></a></td><?php endif ?>
      <td>
        <a href="<?php echo Base::instance()->alias('event', ['evenement' => $evenement->id]) ?>?referer=event&<?php echo Base::instance()->get('activefiltersparams'); ?>"><?php echo $evenement->nom ?></a>
        <?php if ($evenement->liendeclaration): ?>
        <a href="<?php echo $evenement->liendeclaration ?>" class="btn-warning ms-2 btn btn-sm py-0 px-1" target="_blank">
          <i class="d-inline-flex bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
        </a>
        <?php endif ?>
        <?php foreach ($evenement->organismes as $organisme): ?>
          <img class="img-fluid float-end mx-1" style="height: 25px;" src="<?php echo Base::instance()->alias('organismelogo', ['organisme' => $organisme->id]) ?>" data-bs-toggle="tooltip" data-bs-title="<?php echo $organisme->nom ?>">
        <?php endforeach; ?>
      </td>
      <td><?php echo $evenement->element_declencheur; ?></td>
      <td><?php echo \Helpers\MonthTimeline::renderDatelines($evenement);?></td>
      <?php if(Base::instance()->get('SESSION.user')): ?>
        <td>
          <a href="<?php echo Base::instance()->alias('eventedit', ['evenement' => $evenement->id]) ?>"><i class="bi bi-pencil-square"></i></a>
        </td>
      <?php endif ?>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<?php endif; ?>
