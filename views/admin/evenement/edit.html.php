  <nav class="mt-4 clearfix">
    <h1 class="h3 col-md-auto float-left">Édition d'une déclaration</h1>
  </nav>

  <div class="mainContent clearfix">
  <form method="post" action="<?php echo $formurl ?>" id="event-form">

    <div class="row mb-3">
      <label for="nom" class="col-2 col-form-label"><strong>Nom</strong></label>
      <div class="col-4">
        <input type="text" class="form-control " name="nom" value="<?php echo $event->nom ?>" style="font-weight: bold;" />
      </div>
    </div>

    <div class="row mb-3">
      <label for="description" class="col-2 col-form-label">Description</label>
      <div class="col-4">
        <div id="editor" class="form-control" name="description"><?php echo $event->description ?></div>
      </div>
    </div>

    <div class="row mt-4 mb-3">
      <label for="type_id" class="col-2 col-form-label">Type de déclaration</label>
        <div class="col-4">
          <select class="form-control " name="type_id">
            <?php foreach ($types->find() as $t): ?>
                <option value="<?php echo $t->id ?>" <?php echo $event->type_id === $t->id ? "selected" : "" ?>><?php echo $t->nom ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <label for="familles" class="col-2 col-form-label">Familles viti/vinicoles</label>
        <fieldset class="col-4">
          <?php foreach ($familles->find() as $famille): ?>
          <div class="form-check form-check-inline">
            <input name="familles[]" <?php echo $event->hasFamille($famille->id) ? 'checked' : '' ?>  class="form-check-input " id="famille-<?php echo $famille->id ?>" type="checkbox" value="<?php echo $famille->id ?>">
            <label class="form-check-label" for="famille-<?php echo $famille->id ?>"><?php echo $famille->nom ?></label>
          </div>
          <?php endforeach ?>
          <p class="text-right primary-link"><a href="<?php echo Base::instance()->alias('famillelist') ?>">Gérer les familles</a></p>
        </fieldset>
      </div>

      <div class="row mb-3">
        <label for="date_debut" class="col-2 col-form-label">Date début</label>
        <div class="col-4">
          <input type="date" min="2000-01-01" max="2100-12-31" class="form-control " name="date_debut" value="<?php echo $event->date_debut ?>" />
        </div>
      </div>
      <div class="row mb-3">
        <label for="date_fin" class="col-2 col-form-label">Date de fin</label>
        <div class="col-4">
          <input type="date" min="2000-01-01" max="2100-12-31" class="form-control " name="date_fin" value="<?php echo $event->date_fin ?>" />
         </div>
       </div>

       <div class="row mb-3">
         <label for="element_declencheur" class="col-2 col-form-label">Élément déclencheur</label>
         <div class="col-4">
           <input type="text" class="form-control " name="element_declencheur" value="<?php echo $event->element_declencheur ?>" />
          </div>
       </div>

      <div class="row mb-3">
        <label for="organismes" class="col-2 col-form-label">Organismes destinataires</label>
        <fieldset class="col-4">
          <?php foreach ($organismes->find() as $organisme): ?>
            <div class="form-check form-check-inline">
              <input name="organismes[]" <?php if ($event->hasOrganisme($organisme->id)): ?>checked<?php endif ?> class="form-check-input " id="organisme-<?php echo $organisme->id ?>" type="checkbox" value="<?php echo $organisme->id ?>">
              <label class="form-check-label" for="organisme-<?php echo $organisme->id ?>"><?php echo $organisme->nom ?></label>
            </div>
          <?php endforeach ?>
          <p class="text-right primary-link"><a href="<?php echo Base::instance()->alias('organismelist') ?>">Gérer les organismes</a></p>
        </fieldset>
      </div>

      <div class="row mb-3">
        <label for="textdeloi" class="col-2 col-form-label">Texte de loi</label>
        <div class="col-4">
          <input type="text" class="form-control " name="textdeloi" value="<?php echo $event->textedeloi ?>" />
        </div>
      </div>

      <div class="row mb-3">
        <label for="liendeclaration" class="col-2 col-form-label">Lien de télédéclaration</label>
        <div class="col-4">
          <input type="text" class="form-control " name="liendeclaration" value="<?php echo $event->liendeclaration ?>" />
        </div>
      </div>

      <div class="row mb-3">
        <label for="tags" class="col-2 col-form-label">Mots-Clés <small>(séparés par des virgules)</small></label>
        <div class="col-4">
            <input type="text" class="form-control " name="tags" value="<?php echo $event->getTags() ?>" />
         </div>
      </div>

      <div class="row mb-3">
        <label for="recurrence" class="col-2 col-form-label">Récurrence <small>(sur 1 année glissante)</small></label>
        <div class="col-4">
          <select class="form-control " name="recurrence">
            <?php foreach ($event::$recurrences as $recurrence => $desc): ?>
              <option value="<?php echo $recurrence ?>"<?php echo $event->recurrence === $recurrence ? ' selected' : '' ?>>
                <?php echo $desc ?>
              </option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <div class="row mb-3">
        <div class="col-4">
          <div class="form-check form-check-inline">
            <input type="checkbox" class="form-check-input " name="actif" id="actif" value="1" <?php echo $event->actif ? 'checked' : '' ?>/>
            <label class="form-check-label" for="actif">Actif</label>
          </div>
        </div>
      </div>

      <div class="row mb-3">
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
        <div class="col-sm-2 text-end">
          <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Valider</button>
        </div>
      </div>
  </form>
  </div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const QuillToolbarOptions = [
      ['bold', 'italic', 'underline'], [{ 'size': [] }, 'link', 'image'],
      [{ 'color': [] }, { 'background': [] }], [{ 'align': [] }], [{ 'indent': '-1'}, { 'indent': '+1' }],
      [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
      ['clean']
    ]

    const formevent = document.getElementById("event-form")
    const quill = new Quill('#editor', {
      theme: 'snow',
      modules: {
        toolbar: QuillToolbarOptions
      }
    });

    formevent.addEventListener('formdata', (event) => {
      // Append Quill content before submitting
      event.formData.append('description', quill.getSemanticHTML());
    });
  });
</script>
