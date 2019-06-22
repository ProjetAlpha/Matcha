<template>

  <div class="container" style="max-width:100%!important">
    <div class="row">
      <div class="col push-l1 l10 m12 s12">
        <div class="card-panel teal lighten-5 lighten-5 z-depth-1" style="width:100%!important">
          <div class="row" style="margin-bottom:0!important">
            <ul class="collection">
              <li class="row ml-v-align collection-item avatar">
                <div class="col push-s2 s8 m4 l3">
                  <div class="image is-square">
                  <img :src="'data:image/png;base64,'+profilPicSrc" alt="" class="responsive-img" style="border-radius:50%" />
                    <button class="btn-small blue waves-effect waves-light text-img basic-txt"
                    href="/edit" style="border-radius: 12px;" v-if="type === 'userProfilOwner'">
                      <a class="white-text" href="/profil/edit"><i class="material-icons" style="float:right">edit</i>Editer</a>
                    </button>
                  </div>
                </div>
                <div class="col s12 m6 l6">
                  <!-- si on consulte le profil -->
                  <div class="row" v-if="type === 'consultUserProfil'">
                    <span style="float:right"><i class="material-icons" style="color:#4caf50;">lens</i>En ligne</span>
                  </div>
                  <p class="black-text mr-t-4" v-if="profilData.hasOwnProperty('firstname') && profilData.hasOwnProperty('lastname')">
                    {{profilData.firstname}} {{profilData.lastname}} <br>
                    <span class="black-text" v-if="profilData.hasOwnProperty('age') && profilData.age !== null">
                      {{profilData.age}} ans
                    </span> <br>
                    <span class="black-text" v-if="profilData.hasOwnProperty('localisation') && profilData.localisation !== null">
                      {{profilData.localisation}}
                    </span>
                  </p>
                  <div class="row mr-t-4" v-if="profilData.hasOwnProperty('tags') && Array.isArray(profilData.tags) && profilData.tags.length > 0">
                    <div class="chip blue white-text" v-for="(value, name, index) in profilData.tags">
                      #{{value}}
                    </div>
                  </div>
                  <!-- si ce user a like + consulte le profil d'un autre user + a au moins une photo -->
                  <div class="row">
                    <div class="col s8 m8 l6" v-if="type === 'consultUserProfil' && likesBy !== ''">
                      <span href="#" class="mr-t-4"><i class="material-icons">info_outline</i>{{likesBy}} vous a like</span>
                    </div>
                    <div class="col s7 m6 l6" v-if="type === 'consultUserProfil' && profilPicName !== 'default-profile.png'">
                      <a href="#" v-if="isLiked === false" @click="setLike"><i class="material-icons">thumb_up</i>J'aime</a>
                      <a href="#" v-if="isLiked === true" @click="setDislike"><i class="material-icons">thumb_down</i>Je n'aime pas</a>
                    </div>
                  </div>

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
              <a :href="'/report/add/'" class="btn-small blue waves-effect waves-light center-align" style="width:50%">
                Reporter l'utilisateur</a>
              </p>
              <p class="center-align mr-t-2">
                <a :href="'/block/add/'" class="btn-small red lighten-1 waves-effect waves-light" style="width:50%">
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
    this.isLikedByUser();
    this.getLikeProfilByUser();
  },

  data(){
    return {
      isLiked:'',
      likesBy:'',
      profilPicName:'',
      profilPicSrc:'',
      user:false
    }
  },

  methods:{
    setLike(e){
      this.$http.post('/like/setLike', {profilId:this.profilData.user_id});
      this.isLiked = true;
    },

    setDislike(){
      this.$http.post('/like/setDisLike', {profilId:this.profilData.user_id});
      this.isLiked = false;
    },

    isLikedByUser(){
      this.$http.post('/like/isLikedByUser', {profilId:this.profilData.user_id}).then((response) => {
        if (response.data){
          this.isLiked = response.data.isLiked;
        }
      })
    },

    getLikeProfilByUser(){
      this.$http.post('/like/getLikeByUser', {profilId:this.profilData.user_id}).then((response) => {
        if (response.data && response.data.name !== null){
          this.likesBy = response.data.name;
        }
      })
    },

    isOnline(){

    }
  }
}
</script>
