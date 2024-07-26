<h3>Liste des familles</h3>

<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Famille</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($familles as $famille): ?>
    <tr>
      <td><?php echo $famille->nom ?></td>
      <td>
          <a href="<?php echo Base::instance()->alias('familleedit', ['famille' => $famille->id]) ?>"
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
    <a href="<?php echo Base::instance()->alias('famillecreate') ?>" class="btn btn-primary">
      <i class="bi bi-folder-plus"></i> Ajouter une famille
    </a>
  </div>
</div>
