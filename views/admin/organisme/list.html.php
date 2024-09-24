<h3>Liste des organismes</h3>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Logo</th>
      <th>Nom court</th>
      <th>Organisme</th>
      <th>Adresse</th>
      <th>Contact</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($organismes as $organisme): ?>
    <tr>
      <td><img class="img-fluid" style="height: 30px;" src="<?php echo Base::instance()->alias('organismelogo', ['organisme' => $organisme->id]) ?>"></td>
      <td><?php echo $organisme->nom_court ?></td>
      <td><?php echo $organisme->nom ?></td>
      <td><?php echo nl2br("$organisme->adresse \n $organisme->code_postal $organisme->ville") ?></td>
      <td>
        <?php if ($organisme->telephone): ?>
          <i class="bi bi-phone"></i> <?php echo $organisme->telephone ?><br/>
        <?php endif ?>
        <?php if ($organisme->email): ?>
          <i class="bi bi-envelope-open-heart"></i> <?php echo $organisme->email ?><br/>
        <?php endif ?>
      </td>
      <td>
          <a href="<?php echo Base::instance()->alias('organismeedit', ['organisme' => $organisme->id]) ?>"
             class="icon-link">
            <i class="bi bi-pencil-square"></i> Modifier
          </a>
      </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>

<div class="row mb-2">
  <div class="col-12 text-end">
    <a href="<?php echo Base::instance()->alias('organismecreate') ?>" class="btn btn-primary">
      <i class="bi bi-folder-plus"></i> Ajouter un organisme
    </a>
  </div>
</div>
