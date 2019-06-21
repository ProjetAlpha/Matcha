<template>

  <div class="container" style="max-width:100%!important">
    <div class="row">
      <div class="col push-l2 l7 m12 s12">
        <div class="card-panel teal lighten-5 lighten-5 z-depth-1" style="width:100%!important">
          <div class="row" style="margin-bottom:0!important">
            <ul class="collection">
              <li class="row ml-v-align collection-item avatar">
                <div class="col s12 m6 l6">
                  <div class="image is-square">
                  <img :src="'data:image/png;base64,'+profilPicSrc" alt="" class="responsive-img" style="border-radius:50%" />
                    <button class="btn-small blue waves-effect waves-light text-img basic-txt"
                    href="/edit" style="border-radius: 12px;" v-if="type === 'userProfilOwner'">
                      <a class="white-text" href="/profil/edit"><i class="material-icons" style="float:right">edit</i>Editer</a>
                    </button>
                  </div>
                </div>
                <div class="col s12 m4 l4">
                  <!-- si on consulte le profil -->
                  <a href="/profil/" v-if="type === 'consultUserProfil'"><i class="material-icons" style="color:#4caf50;">lens</i>En ligne</a>
                  <p class="black-text mr-t-4" v-if="profilData.hasOwnProperty('firstname') && profilData.hasOwnProperty('lastname')">
                    {{profilData.firstname}} {{profilData.lastname}} <br>
                    <span class="black-text" v-if="profilData.hasOwnProperty('age') && profilData.age !== null">
                      {{profilData.age}} ans
                    </span>
                  </p>
                  <div class="row mr-t-4" v-if="profilData.hasOwnProperty('tags') && Array.isArray(profilData.tags) && profilData.tags.length > 0">
                    <div class="chip blue white-text" v-for="(value, name, index) in profilData.tags">
                      #{{value}}
                    </div>
                  </div>
                  <!-- si ce user a like + consulte le profil d'un autre user + a au moins une photo -->
                  <li href="#" class="mr-t-4" v-if="type === 'consultUserProfil'"><i class="material-icons mr-t-3">info_outline</i>Thomas vous a like</li>
                  <!-- si on consulte 1 profil -->
                  <a href="#" v-if="type === 'consultUserProfil'"><i class="material-icons">thumb_up</i>Like</a>
                  <a href="#" v-if="type === 'consultUserProfil'"><i class="material-icons">thumb_down</i>Dislike</a>
                </div>
              </li>
              <li class="mr-t-3 teal lighten-4 collection-item avatar" v-if="profilData.hasOwnProperty('orientation') && profilData.orientation !== null">
                <span class="title">
                  Orientation sexuelle</span> <br>
                {{profilData.orientation}}
              </li>
              <li class="cyan lighten-4 collection-item avatar" v-if="profilData.hasOwnProperty('bio') && profilData.bio !== null">
                <span class="title">Bio</span>
                <p class="black-text">
                  {{profilData.bio}}
                </p>
              </li>
              <li class="purple lighten-4 collection-item avatar" v-if="profilData.hasOwnProperty('score') && profilData.score !== null">
                <span class="title">Score de popularité</span>
                <a class="black-text right-align mr-l-1">
                  {{profilData.score}}
                </a>
              </li>
            </ul>
          </div>
          <div class="row" v-if="type === 'consultUserProfil'">
            <p class="center-align">
              <a :href="'/report/add/'" class="btn-small blue waves-effect waves-light center-align" style="width:60%">
                Reporter l'utilisateur</a>
              </p>
              <p class="center-align mr-t-2">
                <a :href="'/block/add/'" class="btn-small red lighten-1 waves-effect waves-light" style="width:60%">
                  Bloquer l'utilisateur</a>
                </p>
              </div>
            </div>
          </div>
          <!-- si on est log + que le current user === user id du profil -->
          <user-profil-info v-if="type === 'userProfilOwner'"></user-profil-info>
        </div>
      </div>
</template>

<script>

export default{

  props:['profilData', 'type'],

  created(){
    let request = '';
    this.$checkIfLogged().then(response => {
      this.user = response ? response : false;
    })
    .catch(error => console.log(error));
    if (this.type == 'consultUserProfil'){
      this.$http.post('/profil/visit/getConsultedProfilPic', {userId:this.profilData.visitedUserId}).then((response) => {
        if (response.data && response.data.name !== null && response.data.path !== null){
          this.profilPicName = response.data.name;
          this.profilPicSrc = response.data.path;
        }
      });
    }
    if (this.type == 'userProfilOwner'){
      this.$http.get('/profil/edit/getProfilPic').then((response) => {
        if (response.data && response.data.name !== null && response.data.path !== null){
          this.profilPicName = response.data.name;
          this.profilPicSrc = response.data.path;
        }
      });
    }
  },

  data(){
    return {
      intrestedBy:'',
      profilPicName:'',
      profilPicSrc:'',
      user:false
    }
  },

  methods:{
    // users qui on visiter le profil de M. X
    // user qui ont like le profil de M. X
    setLike(){

    },

    setDislike(){

    },

    isLikedByUser(){

    },

    isOnline(){

    }
  }
}
</script>
