<template>
  <div class="row">
    <ul class="col push-l1 l8 offset-l1 push-m1 m10 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
      <li>
        <div class="collapsible-header"><i class="material-icons">thumb_up</i>Utilisateurs qui ont like
          <span class="new badge" data-badge-caption="nouveaux likes">4</span>
        </div>
        <div class="collapsible-body">
          <ul class="collection">
            <li class="row ml-v-align collection-item avatar">
              <div class="col s12 m6 l6">
                <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
              </div>
              <div class="col s8 m7 l7">
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                  <br>
                  <span class="black-text">
                    Toulouse
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
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
              </div>
              <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
            </li>
            <li class="row ml-v-align collection-item avatar">
              <div class="col s12 m6 l6">
                <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
              </div> <!-- notice the "circle" class -->
              <div class="col s12 m7 l7">
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                  <br>
                  <span class="black-text">
                    Toulouse
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
              </div> <br>
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
            <li class="row ml-v-align collection-item avatar">
              <div class="col s12 m6 l6">
                <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
              </div>
              <div class="col s8 m4 l4">
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span>
                  <br>
                  <span class="black-text">
                    Toulouse
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
              </div>
              <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
              <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>


<script>

// user qui ont like le profil : nom, prenom, age, localisation, tags, isOnline.
// user qui ont visités le profil : nom, prenom, age, localisation, tags, isOnline[user_id]
// nouveaux likes / vues = difference previous like..
  export default {
      created(){
        this.getProfilViews();
      },

      data(){
        return {
          profilLike:'',
          profilView:''
        }
      },

      methods:{
        getProfilLike(){

        },

        getProfilViews(){
          this.$http.get('/profil/getProfilViews').then((response) => {
            console.log(response.data);
          });
        }
      }
  }
</script>
