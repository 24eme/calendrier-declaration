<?php if ($route == 'home'): ?>
<a class="btn btn-outline-primary mb-3" href="<?php echo Base::instance()->alias('events') ?>" role="button"><i class="bi bi-list"></i> Vue liste</a>
<?php else: ?>
<a class="btn btn-outline-primary mb-3" href="<?php echo Base::instance()->alias('home') ?>" role="button"><i class="bi bi-calendar-week"></i> Vue calendrier</a>
<?php endif; ?>

<h4 class="m-0">Filtrer par</h4>

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
<div class="me-1 mb-1 d-inline-block">
  <input name="filters[organismes][]" value="<?php echo $organisme->id ?>" type="checkbox" class="btn-check" id="btn-check-organismes-<?php echo $organisme->id ?>" autocomplete="off"
      <?php echo isset($filters['organismes']) && in_array($organisme->id, $filters['organismes']) ? 'checked' : null ?> >
  <label class="btn btn-outline-primary btn-sm" for="btn-check-organismes-<?php echo $organisme->id ?>"><img src="/images/logos/organismes/<?php echo $organisme->logo ?>" class="img-fluid" style="height: 30px;" title="<?php echo $organisme->nom ?>"></label>
</div>
<?php endforeach ?>
</div>

<h5 class="my-3">Mots-clés liés à une déclaration</h5>

<div id="sidebar-list-tags" class="fs-6 border-bottom" style="max-height:25vh; overflow-y:auto">
<?php foreach (\Views\Sidebar::instance()->displayTags($filters) as $tag): ?>
<div class="me-1 mb-1 d-inline-block">
  <input name="filters[tags][]" value="<?php echo $tag->id ?>" type="checkbox" class="btn-check" id="btn-check-tags-<?php echo $tag->id ?>" autocomplete="off"
      <?php echo isset($filters['tags']) && in_array($tag->id, $filters['tags']) ? 'checked' : null ?> >
  <label class="btn btn-outline-primary btn-sm" for="btn-check-tags-<?php echo $tag->id ?>"><?php echo $tag->nom ?></label>
</div>
<?php endforeach ?>
</div>
<div class="d-grid gap-2 mx-auto mt-2">
  <button class="btn btn-primary btn-sm" type="button" id="show-more-tags">Voir plus</button>
</div>

<h5 class="my-3">Recherche</h5>

<div class="row my-3">
  <div class="input-group">
    <input class="form-control input-search" type="text" placeholder="Termes de recherche..." autocomplete="off" name="filters[query]" onkeypress="return event.keyCode!=13" value="" />
    <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
  </div>
</div>

</form>

<p class="primary-link text-end">
  <a href="<?php echo Base::instance()->alias($route) ?>">[x] Voir toutes les déclarations</a>
</p>

<script>
  const listtags = document.getElementById("sidebar-list-tags")
  const showmoretags = document.getElementById("show-more-tags")
  let state = 'minimized'

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

  const formfilter = document.getElementById("filter-form")
  formfilter.addEventListener('input', function(e) {
    if (e.inputType === "insertText") {
      return false; // on ne veut pas submit dès qu'on rentre du texte
    }

    formfilter.submit();
  })
</script>
