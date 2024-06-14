<div id="main" class="main col-10">
  <nav class="mt-4 clearfix">
    <h1 class="h3 col-md-auto float-left">Édition d'une déclaration</h1>
  </nav>

  <div class="mainContent clearfix">
  <form method="post" action="<?php echo $formurl ?>">
    <div class="form-group row">
      <label for="type_id" class="col-2">Edition d'une déclaration</label>
        <div class="col-4">
          <select class="form-control " name="type_id">
            <?php foreach ($types->find() as $t): ?>
                <option value="<?php echo $t->id ?>" <?php echo $event->type_id === $t->id ? "selected" : "" ?>><?php echo $t->name ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <label for="familles" class="col-2">Familles viti/vinicoles</label>
        <div class="col-4">
          <?php foreach ($familles->find() as $famille): ?>
          <div class="form-check form-check-inline">
            <input name="familles[]" <?php echo $event->hasFamille($famille->id) ? 'checked' : '' ?>  class="form-check-input " id="famille-<?php echo $famille->id ?>" type="checkbox" value="<?php echo $famille->id ?>">
            <label class="form-check-label" for="famille-<?php echo $famille->id ?>"><?php echo $famille->nom ?></label>
          </div>
          <?php endforeach ?>
          <p class="text-right primary-link"><a href="https://calendrier-vitivini.vinsdeprovence.com/admin/familles">Gérer les familles</a></p>
        </div>
      </div>

      <div class="form-group row">
        <label for="start" class="col-2">Date début</label>
        <div class="col-4">
          <input type="date" min="2000-01-01" max="2100-12-31" class="form-control " name="start" value="<?php echo $event->start ?>" />
        </div>
      </div>
      <div class="form-group row">
        <label for="end" class="col-2">Date de fin</label>
        <div class="col-4">
          <input type="date" min="2000-01-01" max="2100-12-31" class="form-control " name="end" value="<?php echo $event->end ?>" />
         </div>
      </div>

      <div class="form-group row">
        <label for="title" class="col-2">Titre</label>
        <div class="col-4">
          <input type="text" class="form-control " name="title" value="<?php echo $event->title ?>" />
        </div>
      </div>

      <div class="form-group row">
        <label for="description" class="col-2">Description</label>
        <div class="col-4">
          <textarea id="editor" class="form-control " rows="3" name="description"><?php echo $event->description ?></textarea>
        </div>
      </div>

      <div class="form-group row">
        <label for="organismes" class="col-2">Organismes destinataires</label>
        <div class="col-4">
          <?php foreach ($organismes->find() as $organisme): ?>
            <div class="form-check form-check-inline">
              <input name="organismes[]" <?php if ($event->hasOrganisme($organisme->id)): ?>checked<?php endif ?> class="form-check-input " id="organisme-<?php echo $organisme->id ?>" type="checkbox" value="<?php echo $organisme->id ?>">
              <label class="form-check-label" for="organisme-<?php echo $organisme->id ?>"><?php echo $organisme->nom ?></label>
            </div>
          <?php endforeach ?>
          <p class="text-right primary-link"><a href="https://calendrier-vitivini.vinsdeprovence.com/admin/organismes">Gérer les organismes</a></p>
        </div>
      </div>

      <div class="form-group row">
        <label for="textdeloi" class="col-2">Texte de loi</label>
        <div class="col-4">
          <input type="text" class="form-control " name="textdeloi" value="<?php echo $event->textedeloi ?>" />
        </div>
      </div>

      <div class="form-group row">
        <label for="liendeclaration" class="col-2">Lien de télédéclaration</label>
        <div class="col-4">
          <input type="text" class="form-control " name="liendeclaration" value="<?php echo $event->liendeclaration ?>" />
        </div>
      </div>

      <div class="form-group row">
        <label for="tags" class="col-2">Mots-Clés  <small>(séparés par des virgules)</small></label>
        <div class="col-4">
            <input type="text" class="form-control " name="tags" value="<?php echo $event->getTags() ?>" />
         </div>
      </div>

      <div class="form-group row">
        <label for="rrule" class="col-2">Récurrence <small>(sur 1 année glissante)</small></label>
        <div class="col-4">
          <select class="form-control " name="rrule">
            <?php foreach ($event::$rrules as $recurrence => $desc): ?>
              <option value="<?php echo $recurrence ?>"<?php echo $event->rrule === $recurrence ? ' selected' : '' ?>>
                <?php echo $desc ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="form-group row">
        <div class="col-4">
          <div class="form-check form-check-inline">
            <input type="checkbox" class="form-check-input " name="active" id="active" value="1" <?php echo $event->active ? 'checked' : '' ?>/>
            <label class="form-check-label" for="active">Actif</label>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-sm-2">
          <a href="/" class="btn btn-secondary float-left">Retour</a>
        </div>
        <div class="col-sm-2 text-center text-muted">
            <?php if ($event->id): ?>
            <a href="<?php echo Base::instance()->alias('eventdelete', ['evenement' => $event->id]) ?>" onclick="return confirm('Etes vous sûr de vouloir supprimer cette déclaration ?')">
              <i class="bi bi-trash"></i> Supprimer
            </a>
            <?php endif ?>
        </div>
        <div class="col-sm-2">
          <button type="submit" class="btn btn-primary float-right"><i class="fas fa-check"></i> Valider</button>
        </div>
      </div>
  </form>
  </div>

</div>

