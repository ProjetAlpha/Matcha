<template>

  <div class="container" style="max-width:100%!important">
    <div :class="isMessageLoaded ? 'row hide' : 'row'">
      <div class="input-field col s12 m10 push-m1 l9 push-l1 grey lighten-2 search-border">
        <i class="material-icons prefix">search</i>
        <input placeholder="Rechercher" id="icon_prefix" type="text" class="validate" style="border-bottom:0!important;box-shadow:0 0px!important">
        <label for="icon_prefix"></label>
      </div>
    </div>
    <div :class="isMessageLoaded ? 'row hide' : 'row'">
      <div class="col s12 m10 push-m1 l9 push-l1">
        <ul class="collection" v-for="(value, name, index) in matchedUserChat">
          <li class="row collection-item avatar">
            <div class="col s8 m6 l6">
              <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
            </div>
            <div class="row">
              <div class="col s8 m5 l4">
                <div class="vertical-center">
                  <a @click="loadMessage"><p class="flow-text">
                    {{value[0].content}}
                  </p></a>
                </div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div v-if="isMessageLoaded === true">
      <chat-message @showMainChat="resetloadedMessage($event)"></chat-message>
    </div>
  </div>

</template>

<script>

export default {
  created(){
    this.fetchConversation()
  },

  data(){
      return {
        isMessageLoaded:'',
        matchedUserSearch:'',
        matchedUserChat:''
      }
  },

  methods:{
    // Rechercher la personne matche => nouvelle conversation ou reprendre la conversation.
    // vue pour les messages des users (user_id | room_id [user_id1, user_id2])
    // bouton ajouter une conversation : liste des personnes matches (like mutuelle).
    // user_id 1 et user_id2 => room_id => tout les messages = room_id | user_id (user_id doit etre assoces a room_id, sinon nop).
    // like mutuelle => match => peut chat.
    // liste des personnes match dans l'apercu du chat.
    //
    search(){
      // chercher les users matches + les conversations associees si elles existe.
      this.$http.get('/chat/searchMatchedUser').then((response) => {
        if (response.data){
          this.matchedUserSearch = reponse.data
        }
      });
      // filtrer en tps reel le nom de la personne si conversation ou matchée. (v-model + watcher!)
      // en dessous de search affiche le resultat.
      // qd on clique sur le resultat => fire message
    },

    fetchConversation(){
      this.$http.get('/chat/fetchMatchedUser').then((response) => {
        console.log(response.data)
        if (response.data){
          this.matchedUserChat = response.data.matched
        }
      });
    },

    getRooms(){
      // si la room existe, charge la room et les message associes.
    },

    createRoom(){
      // si la room n'existe pas => creer une room pour les 2 users.
    },

    getMessage(){
      // prendre tout les messages associes avec cette room.
    },

    addMessage(){
      // date + text.
      // ajouter un message avec cette room.
    },

    loadMessage(){
      // load les messages de la room_id.
      this.isMessageLoaded = true
    },

    resetloadedMessage(event){
      if (event === true){
        this.isMessageLoaded = false
        //event = false
      }
      //event === true ? isMessageLoaded = false : 0;
      //this.$emit('resetMsg')
    }
  }
}

</script>
