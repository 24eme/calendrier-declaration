<a href="/" class="text-start">
    <img src="/images/logos/civp.png" height="150px" alt="logo"/>
</a>
<div class="footer-links container pb-4">
  <ul class="footer-nav list-unstyled my-0" role="menubar">
    <li class="nav-item d-inline-block" id="nav-item-civp" role="menuitem">
      <a class="nav-link" id="nav-link-civp" href="https://www.vinsdeprovence.com/civp">CIVP</a>
    </li>
    <li class="nav-item d-inline-block mx-2" id="nav-item-contact" role="menuitem">
      <a class="nav-link" id="nav-link-contact" href="https://www.vinsdeprovence.com/contact">Contact</a>
    </li>
    <li class="nav-item d-inline-block mx-2" id="nav-item-mentions-legales" role="menuitem">
      <a class="nav-link" id="nav-link-mentions-legales" href="/pages/mentions-legales">Mentions légales</a>
    </li>
    <li class="nav-item d-inline-block mx-2" id="nav-item-admin" role="menuitem">
      <a class="nav-link" id="nav-link-admin" href="<?php echo Base::instance()->alias('login') ?>"><i class="fas fa-user-lock"></i> Administration</a>
    </li>
    <?php if(Base::instance()->get('SESSION.user')): ?>
    <li class="nav-item d-inline-block mx-2" id="nav-item-admin" role="menuitem">
      <a class="nav-link" id="nav-link-admin" href="https://matomo.24eme.fr/index.php?idSite=3" target="_blang"><i class="fas fa-user-lock"></i> Stats</a>
    </li>
    <?php endif; ?>
  </ul>
</div>
