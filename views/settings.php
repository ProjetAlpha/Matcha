<?php require_once(dirname(__DIR__).'/views/header.php'); ?>


<section class="hero blue-grey lighten-5 is-fullheight-with-navbar" id="app">
  <nav-bar></nav-bar>
  <user-settings :title="{name:'Nom', lastname:'Prenom', email:'Email', password:'Mot de passe'}"></user-settings>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
