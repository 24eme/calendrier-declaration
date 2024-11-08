<?php if(Base::instance()->get('SESSION.user')): ?>
<h4 class="m-0"><i class="bi bi-lock-fill"></i> Administration</h4>

<div class="list-group my-3">
  <a href="<?php echo Base::instance()->alias('events') ?>" class="list-group-item list-group-item-action py-1<?php if (strpos(Base::instance()->get('URI'), '/admin/evenement') !== false || strpos(Base::instance()->get('URI'), '/evenements') !== false): ?> active<?php endif; ?>"><i class="bi bi-calendar-week"></i> Déclarations</a>
  <a href="<?php echo Base::instance()->alias('famillelist') ?>" class="list-group-item list-group-item-action py-1<?php if (strpos(Base::instance()->get('URI'), '/admin/familles') !== false): ?> active<?php endif; ?>"><i class="bi bi-people-fill"></i> Familles viti/vinicoles</a>
  <a href="<?php echo Base::instance()->alias('organismelist') ?>" class="list-group-item list-group-item-action py-1<?php if (strpos(Base::instance()->get('URI'), '/admin/organismes') !== false): ?> active<?php endif; ?>"><i class="bi bi-grid-3x3-gap-fill"></i> Organismes destinataires</a>
  <a href="http<?php echo ($_SERVER['SERVER_PORT'] == 443)? 's' : '' ?>://logout:logout@<?php echo Base::instance()->get('HEADERS')['Host'] ?>/logout" class="list-group-item list-group-item-action py-1"><i class="bi bi-box-arrow-left"></i> Déconnexion</a>
</div>
<?php endif; ?>

<?php if (strpos(Base::instance()->get('URI'), '/admin') === false): ?>

<h4 class="m-0"><i class="bi bi-filter-circle"></i> Filtrer par</h4>

<?php if ($filters): ?>
<p class="primary-link mt-3 mb-0">
  <a href="<?php echo Base::instance()->alias($route) ?>?resetfilters=true">[x] Voir toutes les déclarations</a>
</p>
<?php endif; ?>

<form action="<?php echo Base::instance()->alias($route) ?>" method="get" id="filter-form">

<h5 class="my-3">Familles</h5>

<?php foreach ($familles->find() as $famille): ?>
<div class="form-check form-switch m-1">
    <input name="filters[familles][]" value="<?php echo $famille->id ?>" type="checkbox" class="form-check-input" id="famille<?php echo $famille->id ?>" role="switch"
        <?php echo isset($filters['familles']) && in_array($famille->id, $filters['familles']) ? 'checked' : null ?> />
  <label class="form-check-label" for="famille<?php echo $famille->id ?>"><?php echo $famille->nom ?> <i class="bi bi-info-circle-fill text-muted small" data-toggle="tooltip" data-placement="right" title="<?php echo $famille->description ?>"></i></label>
</div>
<?php endforeach ?>

<h5 class="my-3">Organismes destinataires</h5>

<div id="sidebar-list-organismes">
<?php foreach ($organismes->find() as $organisme): ?>
<div data-bs-toggle="tooltip" data-bs-title="<?php echo $organisme->nom ?>" class="mb-1 d-inline-block">
  <input name="filters[organismes][]" value="<?php echo $organisme->id ?>" type="checkbox" class="btn-check" id="btn-check-organismes-<?php echo $organisme->id ?>" autocomplete="off"
      <?php echo isset($filters['organismes']) && in_array($organisme->id, $filters['organismes']) ? 'checked' : null ?> >
  <label class="btn btn-outline-primary btn-sm p-0 position-relative <?php echo isset($filters['organismes']) && in_array($organisme->id, $filters['organismes']) ? 'active' : null ?>" style="background: center / cover no-repeat url('<?php echo Base::instance()->alias('organismelogo', ['organisme' => $organisme->id]) ?>');" for="btn-check-organismes-<?php echo $organisme->id ?>"><span class="position-absolute bottom-0 start-50 translate-middle-x bg-white text-primary px-1"><?php echo $organisme->getNomCourt() ?></span></label>
</div>
<?php endforeach ?>
</div>

<h5 class="my-3">Mots-clés liés à une déclaration</h5>

<div id="sidebar-list-tags" class="fs-6 border-bottom" style="max-height:25vh; overflow-y:auto">
<?php foreach (\Helpers\Sidebar::instance()->getTags($filters) as $tag): ?>
<div class="me-1 mb-1 d-inline-block">
  <input name="filters[tags][]" value="<?php echo $tag->id ?>" type="checkbox" class="btn-check" id="btn-check-tags-<?php echo $tag->id ?>" autocomplete="off"
      <?php echo isset($filters['tags']) && in_array($tag->id, $filters['tags']) ? 'checked' : null ?> >
  <label class="btn btn-outline-primary btn-sm" for="btn-check-tags-<?php echo $tag->id ?>"><?php echo $tag->nom ?></label>
</div>
<?php endforeach ?>
</div>
<div class="d-grid gap-2 mx-auto mt-2">
  <button class="btn btn-outline-secondary btn-sm" type="button" id="show-more-tags">Voir plus</button>
</div>

<h5 class="my-3">Recherche</h5>

<div class="row my-3">
  <div class="input-group">
      <input class="form-control input-search" type="text" placeholder="Termes de recherche..." autocomplete="off" name="filters[query]" value="<?php echo $filters['query'] ?? '';?>" />
      <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
  </div>
</div>

</form>

<?php endif; ?>

<script>
  const listtags = document.getElementById("sidebar-list-tags")
  const showmoretags = document.getElementById("show-more-tags")
  let state = 'minimized'

  if (showmoretags) {
    showmoretags.addEventListener('click', function (e) {
      if (state === 'minimized') {
        listtags.style.maxHeight = 'fit-content'
        state = 'full'
        showmoretags.textContent = 'Voir moins'
      } else {
        listtags.style.maxHeight = '30vh'
        state = 'minimized'
        showmoretags.textContent = 'Voir plus'
      }
    });
  }

  const formfilter = document.getElementById("filter-form")
  if (formfilter) {
    formfilter.addEventListener('input', function(e) {
      if (e.inputType === "insertText") {
        return false; // on ne veut pas submit dès qu'on rentre du texte
      }

      formfilter.submit();
    })
  }
</script>
