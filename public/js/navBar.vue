<template>
  <div>
    <nav>
      <div class="nav-wrapper teal lighten-1">
        <a href="/" class="brand-logo"><i class="material-icons">cloud</i>Matcha</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li><a href="/profil"><i class="material-icons">person</i></a></li>
          <li><a href="/settings"><i class="material-icons">settings</i></a></li>
          <li><a href="/notifications"><i class="material-icons">notifications</i></a></li>
          <li><a href="/chat"><i class="material-icons">chat_bubble</i></a></li>
          <li><a href="/search"><i class="material-icons">search</i></a></li>
          <li>
            <a href="/login" class="btn green waves-effect waves-light">{{loginType}}</a>
          </li>
          <li>
            <a href="/register" class="btn green waves-effect waves-light">{{loginType}}</a>
          </li>
          <li>
            <a href="/reset" class="btn green waves-effect waves-light">{{loginType}}</a>
          </li>
        </ul>
      </div>
    </nav>
    <ul class="sidenav" id="mobile-demo">
      <li class="blue mr-b-3">
        <a href="/" class="brand-logo white-text"><i class="material-icons white-text">cloud</i>Matcha</a>
      </li>
      <li><a href="/profil"><i class="material-icons">person</i>Profil</a></li>
      <li><a href="/settings"><i class="material-icons">settings</i>Parametres</a></li>
      <li><a href="/notifications"><i class="material-icons">notifications</i>Notifications</a></li>
      <li><a href="/chat"><i class="material-icons">chat_bubble</i>Chat</a></li>
      <li><a href="/search" class="mr-t-3"><i class="material-icons">search</i>Rechercher</a></li>
      <hr>
      <li>
        <a href="/login" class="btn green waves-effect waves-light">
          {{loginType}}
        </a>
      </li>
    </ul>
  </div>
</template>

<script>

// handle les notifs + le chat + profil user.
export default{
    data(){
        return {
            // si on est log change le bail.
            loginType:'Login'
        }
    }
}

</script>
