<?php if(Base::instance()->get('URI') == '/'): ?>
<a class="btn btn-outline-primary mb-3" href="<?php echo Base::instance()->alias('events') ?>" role="button"><i class="bi bi-list"></i> Vue liste</a>
<?php else: ?>
<a class="btn btn-outline-primary mb-3" href="/" role="button"><i class="bi bi-calendar-week"></i> Vue calendrier</a>
<?php endif; ?>

<h4 class="h4 mb-4">Filtrer par</h4>

<form action="/" method="get" id="filter-form">

<h5 class="h5">Familles</h5>

<?php foreach ($familles->find() as $famille): ?>
<div class="form-check form-switch m-1">
    <input name="filters[familles][]" value="<?php echo $famille->id ?>" type="checkbox" class="form-check-input" id="famille<?php echo $famille->id ?>" role="switch"
        <?php echo isset($filters['familles']) && in_array($famille->id, $filters['familles']) ? 'checked' : null ?> />
  <label class="form-check-label" for="famille<?php echo $famille->id ?>"><?php echo $famille->nom ?> <i class="bi bi-info-circle-fill text-muted small" data-toggle="tooltip" data-placement="right" title="<?php echo $famille->description ?>"></i></label>
</div>
<?php endforeach ?>

<h5 class="h5 my-3">Mots-clés liés à une déclaration</h5>

<div id="sidebar-list-tags" class="fs-6 border-bottom" style="max-height:30vh; overflow-y:auto">
<?php foreach (\Views\Sidebar::instance()->displayTags($filters) as $tag): ?>
<div class="me-1 mb-1 d-inline-block">
  <input name="filters[tags][<?php echo $tag->id ?>]" type="checkbox" class="btn-check" id="btn-check-<?php echo $tag->id ?>" autocomplete="off"
      <?php echo isset($filters['tags']) && array_key_exists($tag->id, $filters['tags']) ? 'checked' : null ?> >
  <label class="btn btn-outline-primary btn-sm" for="btn-check-<?php echo $tag->id ?>"><?php echo $tag->nom ?></label>
</div>
<?php endforeach ?>
</div>
<div class="d-grid gap-2 mx-auto mt-2">
  <button class="btn btn-primary btn-sm" type="button" id="show-more-tags">Voir plus</button>
</div>

<h4 class="h4 my-4">Recherche</h4>

<div class="row my-4">
  <div class="input-group">
    <input class="form-control input-search" type="text" placeholder="Termes de recherche..." autocomplete="off" name="filters[query]" onkeypress="return event.keyCode!=13" value="" />
    <button class="btn btn-outline-danger" type="button"><i class="bi bi-search"></i></button>
  </div>
</div>

</form>

<p class="primary-link text-end">
  <a href="/">[x] Voir toutes les déclarations</a>
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
