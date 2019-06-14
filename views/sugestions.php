<?php require_once(dirname(__DIR__).'/views/header.php'); ?>


<section class="hero blue-grey lighten-5 is-fullheight-with-navbar" id="app">
  <seeder number="100" nationalite="fr"></seeder>
  <nav-bar></nav-bar>
  <?php if (isAuth()): ?>
    <div class="hero-body" style="display:block!important">
      <search-match type="result"></search-match>
    </div>
  <?php else: ?>
    <div class="hero-body" style="display:block!important">
      <article class="message">
                <div class="message-body">
                    <a href="/register"> Creér un compte </a>
                </div>
      </article>
    </div>
  <?php endif; ?>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
