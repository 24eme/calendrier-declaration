<?php

  $lienfermer = "/";

  if ($referer && $referer == 'event') {
    $lienfermer = Base::instance()->alias('events');
  }
  if (Base::instance()->get('activefiltersparams')) {
    $lienfermer .= '?'.Base::instance()->get('activefiltersparams');
  }

?><div class="modal-xl modal show d-block">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-3">
      <div class="row sticky-md-top bg-white pt-2">
        <div class="col">
          <h2 class="h2"><?php echo $event->nom ?>
            <?php if(Base::instance()->get('SESSION.user')): ?>
            <small class="d-none d-md-inline"><a href="<?php echo Base::instance()->alias('eventedit', ['evenement' => $event->id]) ?>"><i class="bi bi-pencil-square"></i></a></small>
            <?php endif ?>
            <a href="<?php echo $lienfermer; ?>" class="ms-3 float-end d-none d-md-inline">
              <i class="bi bi-x-circle"></i>
            </a>
            <?php if ($event->liendeclaration): ?>
            <a href="<?php echo $event->liendeclaration ?>" class="btn btn-warning float-end">
              <span class="d-none d-md-inline">Accéder à la déclaration </span><i class="d-inline-flex bi bi-box-arrow-up-right"></i>
            </a>
            <?php endif ?>
            <a href="/evenement/export/<?php echo $event->id ?>" class="btn btn-primary float-end mx-2" title="Exporter la déclaration dans mon calendrier personnel"><i class="bi bi-calendar-plus"></i></a>
          </h2>
          <p class="tags-header">
            <span><i class="bi bi-bookmark me-1"></i>&nbsp;<?php echo $event->type_id->nom ?></span>
            <?php if ($event->familles): ?>
            <span class="d-md-none"><br /></span>
            <span><i class="bi bi-person-square me-1"></i>&nbsp;<?php echo implode(', ', $event->familles->getAll('nom')) ?></span>
            <?php endif; ?>
            <?php if($event->recurrence): ?>
            <span class="d-md-none"><br /></span>
            <span><i class="bi bi-calendar-range me-1"></i>&nbsp;Déclaration <?php echo $event->recurrence ?>le</span>
            <?php endif; ?>
          </p>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-7">
          <h3 class="h3">Information</h3>
          <p class="mt-4 mb-0">
            <?php echo $event->description ?>
          </p>
        </div>

        <div class="col-12 col-md-5">
          <h3>Organismes destinataires</h3>
          <?php foreach ($event->organismes as $organisme): ?>
            <div class="organisme-card p-2">
              <div class="pb-2">
                <img src="/images/logos/organismes/<?php echo $organisme->logo ?>" class="img-fluid" style="height: 25px">
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
            <?php if($event->tags): ?>
            <b class="text-decoration-underline me-3">Mots-clés :</b>
            <?php foreach ($event->tags as $tag): ?>
              <a href="/?<?php echo http_build_query(['filters' => ['tags' => [$tag->id => 'on']]]) ?>" class="btn btn-sm btn-outline-primary">
                <?php echo $tag->nom ?>
              </a>
            <?php endforeach ?>
            <?php endif; ?>
            <span class="d-md-none"><br /></span>
            <a href="<?php echo $lienfermer; ?>" class="btn btn-secondary float-end">Fermer</a>
        </p>
      </div>
    </div>
  </div>
</div>
<div class="modal-backdrop" style="opacity: 85%;"></div>
