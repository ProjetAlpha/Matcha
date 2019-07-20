<?php require_once(dirname(__DIR__).'/views/header.php'); ?>


<section class="hero blue-grey lighten-5 is-fullheight-with-navbar" id="app">
  <nav-bar></nav-bar>
  <?php if (isAuth()): ?>
    <div class="hero-body" style="display:block!important;padding:3%!important">
      <search-match type="result" :is-search="false"></search-match>
    </div>
  <?php else: ?>
    <div class="hero-body">
      <div class="container">
        <div class="row">
          <div class="col">
            <article class="message is-success mr-b-4">
              <div class="message-body">
                <p class="flow-text">
                  Matcha est un site de rencontre destiné à trouver la personne qui correspond à vos besoins, vous n'arrivez pas à trouver une relation durable ou
                  vous chercher une aventure ?
                  <br>
                  <a href="/register"> Creér un compte </a> dès maintenant et trouver la relation qui vous correspond.
                </p>
              </div>
            </article>
          </div>
        </div>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
