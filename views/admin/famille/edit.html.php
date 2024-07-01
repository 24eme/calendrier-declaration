<h3>Édition d'une famille</h3>

<form method="POST" action="<?php echo $formurl ?>">
  <div class="row my-3">
    <label for="nom" class="col-sm-2 col-form-label">Nom de la famille</label>
    <div class="col-sm-8">
      <input type="text" class="form-control" id="nom" name="nom" value="<?php echo $famille->nom ?>">
    </div>
  </div>

  <div class="row mb-3">
    <label for="description" class="col-sm-2 col-form-label">Description</label>
    <div class="col-sm-8">
      <textarea rows=3 class="form-control" id="description" name="description"><?php echo $famille->description ?></textarea>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col-sm-2">
      <button type="submit" class="btn btn-secondary">Retour</button>
    </div>
    <div class="col-sm-2 offset-sm-7">
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-check"></i> Valider
      </button>
    </div>
  </div>
</form>
