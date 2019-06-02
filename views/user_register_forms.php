
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<section class="hero is-light is-fullheight-with-navbar" id="app">
    <nav-bar></nav-bar>
    <?php if (isset($type) && $type == 'login'): ?>
      <user-register action="/doLog" title="Identifiants" :inputs="{email:'Email', password:'Mot de passe'}"
      :submit="{name:'Se connecter', value:'login'}" :type="['email', 'password']"></user-register>
    <?php endif; ?>

    <?php if (isset($type) && $type == 'reset'): ?>
      <user-register action="/doReset" title="Réinitialiser le mot de passe" :inputs="{password:'Mot de passe'}"
      :submit="{name:'Confirmer', value:'password'}" :type="['password']"></user-register>
    <?php endif; ?>

    <?php if (isset($type) && $type == 'register'): ?>
      <user-register action="/doRegister" title="Inscription" :inputs="{first_name:'Nom', email:'Email', password:'Mot de passe'}"
      :submit="{name:'S\'inscrire', value:'register'}" :type="['text', 'email', 'password']"></user-register>
    <?php endif; ?>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
