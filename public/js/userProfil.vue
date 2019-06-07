<template>

  <div class="container" style="max-width:100%!important">
    <div class="row">
      <div class="col push-l2 l7 push-m1 m10 s12">
        <div class="card-panel teal lighten-5 lighten-5 z-depth-1" style="width:100%!important">
          <div class="row">
            <ul class="collection">
              <li class="collection-item avatar" style="height:100%!important">
                <img src="https://lorempixel.com/100/190/nature/6" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                </p>
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
              <li class="teal lighten-4 collection-item avatar">
                <span class="title">Genre</span> <br>
                  Masculin
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
              <li class="light-blue lighten-4 collection-item avatar">
                <span class="title">Score de popularité</span>
                <a class="black-text right-align mr-l-1">
                  100
                </a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
            </ul>
          </div>
          <div class="row">
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
          <div class="row">
            <a href="#"><i class="material-icons">thumb_up</i>Like</a>
            <a href="#"><i class="material-icons">thumb_down</i>Dislike</a><br>
            <span class="black-text">Cette utilisateur vous a like.</span>
          </div>
          <div class="row">
            <button class="btn blue waves-effect waves-light">Reporter l'utilisateur</button>
            <button class="btn red lighten-1 waves-effect waves-light">Bloquer l'utilisateur</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Accordion : voir les personnes qui l'ont like + voir les peronnes qui ont visitees son profil -->
    <div class="row">
      <ul class="col push-l2 l7 push-m1 m10 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
        <li>
          <div class="collapsible-header"><i class="material-icons">thumb_up</i>Utilisateurs qui ont like
            <span class="new badge" data-badge-caption="nouveaux likes">4</span>
          </div>
          <div class="collapsible-body">
            <ul class="collection">
              <li class="collection-item avatar">
                <img src="https://lorempixel.com/100/190/nature/6" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                </p> <br>
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
              <li class="collection-item avatar">
                <img src="https://lorempixel.com/100/190/nature/6" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                </p> <br>
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
            </ul>
          </div>
        </li>
        <li>
          <div class="collapsible-header"><i class="material-icons">remove_red_eye</i>Utilisateurs qui ont visités votre profil
            <span class="new badge" data-badge-caption="nouveaux vues">4</span>
          </div>
          <div class="collapsible-body">
            <ul class="collection">
              <li class="collection-item avatar">
                <img src="https://lorempixel.com/100/190/nature/6" alt="" class="circle responsive-img"> <!-- notice the "circle" class -->
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                </p> <br>
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
                <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
              </li>
            </ul>
          </div>
        </li>
      </ul>
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
