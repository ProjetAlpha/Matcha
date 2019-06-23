<template>
  <div class="row">
    <ul class="col push-l1 l8 offset-l1 push-m1 m10 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
      <li>
        <div class="collapsible-header"><i class="material-icons">thumb_up</i>Utilisateurs qui ont like votre profil
          <span class="new badge" v-if="visiterLikesCount > 0" :data-badge-caption="likesFormat">{{visiterLikesCount}}</span>
        </div>
        <div class="collapsible-body">
          <ul class="collection">
            <li class="row ml-v-align collection-item avatar" v-for="(value, name, index) in visiterLikes">
              <div class="col s12 m4 l4">
                <load-async-image :id="value.id" img-style="center-img responsive-img rounded-img"></load-async-image>
              </div>
              <div class="col s8 m7 l7">
                <p class="black-text">
                  {{value.firstname}} {{value.lastname}} <br>
                  <span class="black-text" v-if="value.age">
                    {{value.age}} ans
                  </span>
                  <br>
                  <span class="black-text">
                    {{value.localisation}}
                  </span>
                </p>
                <div class="row mr-t-4" v-if="visiterLikesTags !== ''">
                  <div class="chip blue white-text" v-for="(value, name, index) in visiterLikesTags[value.id]">
                    #{{value.name}}
                  </div>
                </div>
                <online-user-info :id="value.id"></online-user-info>
              </div>
            </li>
          </ul>
        </div>
      </li>
      <li>
        <div class="collapsible-header"><i class="material-icons">remove_red_eye</i>Utilisateurs qui ont visités votre profil
          <span class="new badge" v-if="visiterViewsCount > 0" :data-badge-caption="viewFormat">{{visiterViewsCount}}</span>
        </div>
        <div class="collapsible-body">
          <ul class="collection">
            <li class="row ml-v-align collection-item avatar" v-for="(value, name, index) in visiterViews">
              <div class="col s12 m4 l4">
                <load-async-image :id="value.id" img-style="center-img responsive-img rounded-img"></load-async-image>
              </div>
              <div class="col s8 m7 l7">
                <p class="black-text">
                  {{value.firstname}} {{value.lastname}} <br>
                  <span class="black-text" v-if="value.age">
                    {{value.age}} ans
                  </span>
                  <br>
                  <span class="black-text">
                    {{value.localisation}}
                  </span>
                </p>
                <div class="row mr-t-4" v-if="visiterViewsTags !== ''">
                  <div class="chip blue white-text" v-for="(value, name, index) in visiterViewsTags[value.id]">
                    #{{value.name}}
                  </div>
                </div>
                <online-user-info :id="value.id"></online-user-info>
              </div>
            </li>
          </ul>
        </div>
      </li>
    </ul>
  </div>
</template>


<script>

export default {
      created(){
        this.getProfilViews();
        this.getProfilLike();
      },

      data(){
        return {
          likesFormat:'',
          viewFormat:'',
          visiterViewsTags:'',
          visiterViews:'',
          visiterViewsCount:0,
          visiterLikes:'',
          visiterLikesTags:'',
          visiterLikesCount:0
        }
      },

      methods:{
        getProfilLike(){
          this.$http.get('/profil/getProfilLikes').then((response) => {
            if (response.data.visiterLikes !== null && response.data.visiterLikes !== undefined){
              this.visiterLikes = response.data.visiterLikes;
              this.visiterLikesTags = response.data.visiterLikes.likesTags;
              delete this.visiterLikes['likesTags'];
              this.visiterLikesCount = Object.keys(this.visiterLikes).length
              this.likesFormat = this.visiterLikesCount > 1 ? 'likes' : 'like'
            }
          });
        },

        getProfilViews(){
          this.$http.get('/profil/getProfilViews').then((response) => {
            if (response.data.visiterViews !== null){
              this.visiterViews = response.data.visiterViews;
              this.visiterViewsTags = response.data.visiterViews.visiterTags;
              delete this.visiterViews['visiterTags'];
              this.visiterViewsCount = Object.keys(this.visiterViews).length
              this.viewFormat = this.visiterViewsCount > 1 ? 'vues' : 'vue'
            }
          });
        }
      }
  }
</script>
