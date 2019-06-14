<template>
  <div>
    <nav>
      <div class="nav-wrapper teal lighten-1">
        <a href="/" class="brand-logo"><i class="material-icons">cloud</i>Matcha</a>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
          <li v-if="user.isAuth"><a href="/profil"><i class="material-icons">person</i></a></li>

          <ul id='dropdown1' class='dropdown-content' v-if="user.isAuth">
            <li><a href="/settings"><i class="material-icons">settings_applications</i>Compte</a></li>
            <li><a href="/profil/edit"><i class="material-icons">account_circle</i>Profil</a></li>
          </ul>

          <li v-if="user.isAuth"><a class='dropdown-trigger' data-target='dropdown1'>
              <i class="material-icons">settings</i></a>
          </li>
          <!-- <li><a href="/settings"><i class="material-icons">settings</i></a></li> -->
          <li v-if="user.isAuth"><a class='dropdown-trigger' data-target='dropdown3'><i class="material-icons">notifications</i></a></li>
          <notifications notification-id="dropdown3" v-if="user.isAuth"></notifications>
          <li v-if="user.isAuth"><a href="/chat"><i class="material-icons">chat_bubble</i></a></li>
          <li><a href="/search"><i class="material-icons">search</i></a></li>
          <li v-if="!user.isAuth">
            <a href="/login" class="btn green waves-effect waves-light">Se connecter</a>
          </li>
          <li v-if="!user.isAuth">
            <a href="/register" class="btn green waves-effect waves-light">S'inscrire</a>
          </li>
          <li v-if="user.isAuth">
            <a href="/logout" class="btn green waves-effect waves-light">Déconnexion</a>
          </li>
        </ul>
      </div>
    </nav>
    <ul class="sidenav" id="mobile-demo">
      <li class="blue mr-b-3">
        <a href="/" class="brand-logo white-text"><i class="material-icons white-text">cloud</i>Matcha</a>
      </li>
      <li v-if="user.isAuth"><a href="/profil"><i class="material-icons">person</i>Profil</a></li>
      <ul class="collapsible" v-if="user.isAuth">
        <li>
          <div class="collapsible-header mr-l-5"><i class="material-icons">settings</i><li class="mr-l-5" style="color:rgba(0,0,0,0.87);font-weight:500;height:48px;font-size:14px">Paramétres</li></div>
          <div class="collapsible-body">
            <li><a href="/settings" class="mr-l-4"><i class="material-icons">settings_applications</i>Compte</a></li>
            <li><a href="/profil/edit" class="mr-l-4"><i class="material-icons">account_circle</i>Profil</a></li>
          </div>
        </li>
      </ul>
      <li v-if="user.isAuth"><a class='dropdown-trigger' data-target='dropdown4'><i class="material-icons">notifications</i>Notifications</a></li>
      <notifications notification-id="dropdown4"></notifications>
      <li v-if="user.isAuth"><a href="/chat"><i class="material-icons">chat_bubble</i>Chat</a></li>
      <li><a href="/search" class="mr-t-3"><i class="material-icons">search</i>Rechercher</a></li>
      <hr>
      <li v-if="!user.isAuth">
        <a href="/login" class="btn green waves-effect waves-light">
          Se connecter
        </a>
      </li>
      <li v-if="!user.isAuth">
        <a href="/register" class="btn green waves-effect waves-light">
          S'inscrire
        </a>
      </li>
      <li v-if="user.isAuth">
        <a href="/reset" class="btn green waves-effect waves-light">Déconnexion</a>
      </li>
    </ul>
  </div>
</template>

<script>

// handle les notifs + le chat + profil user.
export default{
    data(){
        return {
            user:false,
            isDropDownDisplayed:false
        }
    },

    updated(){
      if (this.user.isAuth && this.isDropDownDisplayed === false){
        this.initDropDown();
        this.initCollapse();
        this.isDropDownDisplayed = true;
      }
    },

    created(){
      this.$checkIfLogged().then(response => {
        this.user = response ? response : false;
      })
      .catch(error => console.log(error));
    },

    methods:{
      initDropDown(){
        var elems = document.querySelectorAll('.dropdown-trigger');
        var instances = M.Dropdown.init(elems, {
          inDuration: 350,
          outDuration: 350,
          coverTrigger: false,
          constrainWidth: false
        });
      },

      initCollapse(){
        var elems = document.querySelectorAll('.collapsible');
        var instances = M.Collapsible.init(elems, {
          inDuration: 350,
          outDuration: 350,
          accordion: false
        });
      }
    }
}

</script>
