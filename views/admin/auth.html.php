<div class="bg-body-tertiary">
<div class="form-signin d-flex align-items-center py-4 m-auto">
  <form action="<?php echo Base::instance()->alias('auth') ?>" method="post" class="w-100">
    <h1 class="h3 mb-3 fw-normal text-center"><i class="bi bi-person-fill-lock"></i> Administration</h1>
    <?php if($flash): ?>
    <div class="alert alert-danger" role="alert"><?php echo $flash; ?></div>
    <?php endif; ?>
    <div class="form-floating mt-3 mb-2">
      <input type="text" class="form-control" id="identifiant" placeholder="Identifiant" name="identifiant" />
      <label for="identifiant">Identifiant</label>
    </div>
    <div class="form-floating mb-3">
      <input type="password" class="form-control" id="password" placeholder="Mot de passe" name="password" />
      <label for="password">Mot de passe</label>
    </div>
    <button class="btn btn-primary w-100 py-2" type="submit">S'identifier</button>
  </form>
</div>
</div>
