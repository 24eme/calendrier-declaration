<div class="d-flex justify-content-center mt-3 ms-3 ps-3 pe-2">
  <ul class="timeline">
    <li class="timeline-item">
        <div class="timeline-body">
            <div class="timeline-meta">
                Aujourd'hui
                <span class="text-body-secondary small"><?php echo (isset($today))? $today->format('d M Y') : null; ?></span>
            </div>
            <div class="timeline-content">
                <h6>Vous pouvez déclarer :</h6>
                <ul>
                    <?php if (isset($timeline['today'])): foreach ($timeline['today'] as $nom => $event): ?>
                      <li>
                            <?php if (strpos(Base::instance()->get('URI'), '/chronologie') !== false): ?>
                            <a href="<?php echo Base::instance()->alias('event', ['evenement' => $event->id]) ?>?referer=chronologie&<?php echo Base::instance()->get('activefiltersparams'); ?>">
                            <?php else: ?>
                            <a href="<?php echo Base::instance()->alias('event', ['evenement' => $event->id], Base::instance()->get('activefiltersparams')) ?>">
                            <?php endif; ?>
                                <?php echo $nom ?>
                            </a>
                            <?php if ($event->liendeclaration): ?>
                                <a href="<?php echo $event->liendeclaration ?>">
                                    <i class="ms-1 bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
                                </a>
                            <?php endif ?>
                        </li>
                    <?php endforeach; endif; ?>
                </ul>
                <?php if (isset($timeline['nondate'])): ?>
                    <details>
                        <summary class="mt-2">
                            + <?php echo count($timeline['nondate']) ?> déclaration(s) sans date butoir : <span class="text-primary">voir</span>
                        </summary>
                        <ul>
                            <?php foreach ($timeline['nondate'] as $nom => $event): ?>
                                <li>
                                  <?php if (strpos(Base::instance()->get('URI'), '/chronologie') !== false): ?>
                                  <a href="<?php echo Base::instance()->alias('event', ['evenement' => $event->id]) ?>?referer=chronologie&<?php echo Base::instance()->get('activefiltersparams'); ?>">
                                  <?php else: ?>
                                  <a href="<?php echo Base::instance()->alias('event', ['evenement' => $event->id], Base::instance()->get('activefiltersparams')) ?>">
                                  <?php endif; ?>
                                    <?php echo $nom ?>
                                  </a>
                                    <?php if ($event->liendeclaration): ?>
                                        <a href="<?php echo $event->liendeclaration ?>">
                                            <i class="ms-1 bi bi-box-arrow-up-right" title="Accéder à la déclaration"></i>
                                        </a>
                                    <?php endif ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </details>
                <?php endif ?>
            </div>
        </div>
    </li>
    <?php if (isset($timeline['events'])): foreach ($timeline['events'] as $date => $events): ?>
        <li class="timeline-item">
            <div class="timeline-body">
                <div class="timeline-meta"><?php echo DateTime::createFromFormat('Y-m-d', $date)->format("d M Y") ?></div>
                <div class="timeline-content">
                    <?php foreach ($events as $e): ?>
                        <?php if ($e->date_debut === $date): ?>
                            <div class="opacity-50 pb-3">
                                Ouverture de : <a href="<?php echo Base::instance()->alias('event', ['evenement' => $e->id], Base::instance()->get('activefiltersparams')) ?>"><?php echo $e->nom ?></a>
                            </div>
                        <?php else: ?>
                            <div class="pb-3">
                                Fermeture de : <a href="<?php echo Base::instance()->alias('event', ['evenement' => $e->id], Base::instance()->get('activefiltersparams')) ?>"><?php echo $e->nom ?></a><br/>
                                <span class="opacity-50">Ouvert depuis le : <?php echo DateTime::createFromFormat('Y-m-d', $e->date_debut)->format("d F Y") ?></span>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
            </div>
        </li>
    <?php endforeach; endif; ?>
  </ul>
</div>
