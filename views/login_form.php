
<?php require_once(dirname(__DIR__).'/views/header.php'); ?>

<section class="hero is-light is-fullheight-with-navbar" id="app">
    <nav-bar></nav-bar>
    <div class="hero-body">
            <div class="valign-wrapper row login-box" style="width:100%;height:100%">
                <div class="col card teal lighten-5 hoverable s10 pull-s1 m6 pull-m3 l4 pull-l4">
                    <form method="POST" action="/authenticate">
                        <div class="card-content">
                            <span class="card-title">Identifiants</span>
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="email" style="color:black!important">Email</label>
                                    <input type="email" class="validate" name="email" id="email" />
                                </div>
                                <div class="input-field col s12">
                                    <label for="password" style="color:black!important">Mot de passe</label>
                                    <input type="password" class="validate" name="password" id="password" />
                                </div>
                            </div>
                        </div>
                        <div class="card-action right-align">
                            <button type="reset" id="reset" class="btn-flat waves-effect">Reset</button>
                            <button type="submit" class="btn green waves-effect waves-light" value="Login">Login</button>
                        </div>
                    </form>
                </div>
            </div>
    </div>
</section>

<?php include_once(dirname(__DIR__)."/views/footer.php"); ?>
