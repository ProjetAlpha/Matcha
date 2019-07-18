<?php require_once(dirname(__DIR__).'/views/header.php'); ?>


<section class="hero blue-grey lighten-5 is-fullheight-with-navbar" id="app">
    <nav-bar></nav-bar>
    <div class="hero-body" style="align-items:;padding:2%!important">
      <?php if (isset($type) && $type == 'search'): ?>
        <search-match type="search"></search-match>
      <?php endif; ?>
      <?php if (isset($type) && $type == 'result'): ?>
        <search-match type="result"></search-match>
      <?php endif; ?>
    </div>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
