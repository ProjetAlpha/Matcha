
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<section class="hero blue-grey lighten-5 is-fullheight-with-navbar" id="app">
    <nav-bar></nav-bar>
    <?php if (isset($registerType) && $registerType == 'login'): ?>
      <user-register action="/doLogin" title="Identifiants" :inputs="{username:'Nom d\'utilisateur', password:'Mot de passe'}"
      :submit="{name:'Se connecter', value:'login'}" :type="['text', 'password']"
      message="<?php if (isset($warning)) {
    echo $warning;
}?>"></user-register>
    <?php endif; ?>

    <?php if (isset($registerType) && $registerType == 'reset'): ?>
      <user-register action="/doReset" title="Réinitialiser le mot de passe" :inputs="{password:'Mot de passe'}"
      :submit="{name:'Confirmer', value:'password'}" :type="['password']"
      message="<?php if (isset($warning)) {
    echo $warning;
}?>">
      </user-register>
    <?php endif; ?>

    <?php if (isset($registerType) && $registerType == 'register'): ?>
      <user-register action="/create" title="Inscription"
      :inputs="{username:'Nom d\'utilisateur', lastname:'Nom', firstname:'Prenom', email:'Email', password:'Mot de passe'}"
      :submit="{name:'S\'inscrire', value:'register'}" :type="['text', 'text', 'text', 'email', 'password']"
      message="<?php if (isset($warning)) {
    echo $warning;
}?>"></user-register>
    <?php endif; ?>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
