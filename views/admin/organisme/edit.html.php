  <nav class="mt-4 clearfix">
    <h1 class="h3 col-md-auto">Édition d'un organisme</h1>
  </nav>

  <div class="mainContent clearfix">
  <form method="post" action="<?php echo $formurl ?>" id="event-form">
    <div class="row mb-3">
      <label for="nom" class="col-2 col-form-label">Nom de l'organisme</label>
      <div class="col-4">
        <input type="text" class="form-control " id="nom" name="nom" value="<?php echo $organisme->nom ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="adresse" class="col-2 col-form-label">Adresse</label>
      <div class="col-4">
        <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $organisme->adresse ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="code_postal" class="col-2 col-form-label">Code postal</label>
      <div class="col-4">
        <input type="text" class="form-control" id="code_postal" name="code_postal" value="<?php echo $organisme->code_postal ?>" />
      </div>
    </div>

    <div class="row mb-3">
      <label for="ville" class="col-2 col-form-label">Ville</label>
      <div class="col-4">
        <input type="text" class="form-control" id="ville" name="ville" value="<?php echo $organisme->ville ?>" />
      </div>
    </div>

    <div class="row mb-3">
      <label for="contact" class="col-2 col-form-label">Contact</label>
      <div class="col-4">
        <input type="text" class="form-control" id="contact" name="contact" value="<?php echo $organisme->contact ?>" />
      </div>
    </div>

    <div class="row mb-3">
      <label for="telephone" class="col-2 col-form-label">Téléphone</label>
      <div class="col-4">
        <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo $organisme->telephone ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="email" class="col-2 col-form-label">Email</label>
      <div class="col-4">
        <input type="email" class="form-control" id="email" name="email" value="<?php echo $organisme->email ?>">
      </div>
    </div>

    <div class="row mb-3">
      <label for="site" class="col-2 col-form-label">Site internet</label>
      <div class="col-4">
        <input type="text" class="form-control" id="site" name="site" value="<?php echo $organisme->site ?>" />
      </div>
    </div>

    <div class="row mb-3">
      <label for="logo" class="col-2 col-form-label">Logo</label>
      <div class="col-4">
        <img src="/images/logos/organismes/<?php echo $organisme->logo ?>" class="d-inline-block img-fluid img-thumbnail" alt="Logo">
        <input type="file" class="form-control d-inline-block" id="logo" name="logo" accept="image/jpeg, image/png"/>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-sm-2">
        <a href="<?php echo Base::instance()->alias('organismelist') ?>" class="btn btn-secondary float-left">Retour</a>
      </div>
      <div class="col-sm-2 text-center text-muted">
          <?php if ($organisme->id): ?>
          <a href="<?php echo Base::instance()->alias('organismedelete', ['organisme' => $organisme->id]) ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer cet organisme ?')">
            <i class="bi bi-trash"></i> Supprimer
          </a>
          <?php endif ?>
      </div>
      <div class="col-sm-2 text-end">
        <button type="submit" class="btn btn-primary"><i class="bi bi-check"></i> Valider</button>
      </div>
    </div>

  </form>
  </div>
