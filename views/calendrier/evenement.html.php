<div class="container">
  <div class="row sticky-top bg-white pt-2">
    <div class="col">
      <h2 class="h2"><?php echo $event->title ?>
        <small><a href="<?php echo Base::instance()->alias('eventedit', ['evenement' => $event->id]) ?>"><i class="bi bi-pencil-square"></i></a></small>
        <?php if ($event->liendeclaration): ?>
        <a href="<?php echo $event->liendeclaration ?>" class="btn btn-danger float-end">
          Accéder à la déclaration <i class="d-inline-flex bi bi-box-arrow-up-right"></i>
        </a>
        <?php endif ?>
        <a href="/evenement/export/<?php echo $event->id ?>" class="btn btn-primary float-end mx-2" title="Exporter la déclaration dans mon calendrier personnel"><i class="bi bi-calendar-plus"></i></a>
      </h2>
      <p class="tags-header">
        <span><i class="bi bi-bookmark me-1"></i> <?php echo $event->type_id->name ?></span>
        <span><i class="bi bi-person-rolodex me-1"></i> <?php echo implode(', ', $event->familles->getAll('nom')) ?></span>
        <?php if($event->rrule): ?>
        <span><i class="bi bi-calendar-range me-1"></i> Déclaration <?php echo $event->rrule ?>le</span>
        <?php endif; ?>
      </p>
    </div>
  </div>

  <div class="row">
    <div class="col-7">
      <h3 class="h3">Information</h3>
      <p class="mt-4 mb-0">
        <?php echo $event->description ?>
      </p>
    </div>

    <div class="col-5">
      <?php foreach ($event->organismes as $organisme): ?>
        <div class="organisme-card p-2">
          <div class="pb-2">
            <img src="/images/logos/organismes/<?php echo $organisme->logo ?>" class="img-fluid" height="20px">
            <strong><?php echo $organisme->nom ?></strong>
          </div>
          <div>
            <?php echo nl2br($organisme->adresse . PHP_EOL . $organisme->code_postal . " " . $organisme->ville) ?>
          </div>
          <div>
            <i class="bi bi-telephone-fill"></i> <?php echo $organisme->telephone ?> <br/>
            <i class="bi bi-envelope"></i> <?php echo $organisme->email ?> <br/>
            <i class="bi bi-globe"></i> <a href="<?php echo $organisme->site ?>"><?php echo $organisme->site ?></a>
          </div>
        </div>
      <?php endforeach ?>
    </div>
  </div>

  <hr class="w-50 mx-auto"/>

  <div class="row">
    <p>
        <b class="text-decoration-underline me-3">Mots-clés :</b>
        <?php foreach ($event->tags as $tag): ?>
          <a href="/?<?php echo http_build_query(['filters' => ['tags' => [$tag->id => 'on']]]) ?>" class="btn btn-sm btn-outline-primary">
            <?php echo $tag->nom ?>
          </a>
        <?php endforeach ?>
    </p>
  </div>
</div>
