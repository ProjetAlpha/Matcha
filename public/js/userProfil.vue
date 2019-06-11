<template>

  <div class="container" style="max-width:100%!important">
    <div class="row">
      <div class="col push-l2 l7 m12 s12">
        <div class="card-panel teal lighten-5 lighten-5 z-depth-1" style="width:100%!important">
          <div class="row" style="margin-bottom:0!important">
            <ul class="collection">
              <li class="row ml-v-align collection-item avatar">
                <div class="col s12 m6 l6">
                  <div class="image">
                  <img src="/Photo_profil.jpg" alt="" class="responsive-img" style="border-radius:50%" />
                    <button class="btn-small blue waves-effect waves-light text-img basic-txt"
                    href="/edit" style="border-radius: 12px;">
                      <a class="white-text" href="/profil/edit"><i class="material-icons" style="float:right">edit</i>Editer</a>
                    </button>
                  </div>
                </div>
                <div class="col s12 m4 l4">
                  <a href="#!"><i class="material-icons" style="color:#4caf50;">lens</i>En ligne</a>
                  <p class="black-text mr-t-4">
                    Thomas Broussoux <br>
                    <span class="black-text">
                      23 ans
                    </span>
                  </p>
                  <div class="row mr-t-4">
                    <div class="chip blue white-text">
                      #php
                    </div>
                    <div class="chip blue white-text">
                      #java
                    </div>
                    <div class="chip blue white-text">
                      #css
                    </div>
                  </div>
                  <li href="#" class="mr-t-4"><i class="material-icons mr-t-3">info_outline</i>Thomas vous a like</li>
                  <a href="#"><i class="material-icons">thumb_up</i>Like</a>
                  <a href="#"><i class="material-icons">thumb_down</i>Dislike</a>
                </div>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
              <li class="mr-t-3 teal lighten-4 collection-item avatar">
                <span class="title">Orientation sexuelle</span> <br>
                Homme
                <p class="black-text">
                  Interésse par des femmes
                </p>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
              <li class="cyan lighten-4 collection-item avatar">
                <span class="title">Bio</span>
                <p class="black-text">
                  Ma bioooooo o oeowfoweofo o oewfo oewfoowe ofo Ma bioooooo o oeowfoweofo o oewfo oewfoowe ofo Ma bioooooo
                  o oeowfoweofo o oewfo oewfoowe ofo   o oeowfoweofo o oewfo oewfoowe ofo
                </p>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
              <li class="purple lighten-4 collection-item avatar">
                <span class="title">Score de popularité</span>
                <a class="black-text right-align mr-l-1">
                  100
                </a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
            </ul>
          </div>
          <div class="row">
            <p class="center-align">
              <a class="btn-small blue waves-effect waves-light center-align" style="width:60%">
                Reporter l'utilisateur</a>
              </p>
              <p class="center-align mr-t-2">
                <a class="btn-small red lighten-1 waves-effect waves-light" style="width:60%">
                  Bloquer l'utilisateur</a>
                </p>
              </div>
            </div>
          </div>
          <!-- si on est log -->
          <user-profil-info></user-profil-info>
        </div>
      </div>
</template>

<script>

export default{
    data(){
      return {

      }
    },

    methods:{

    }
}
</script>
