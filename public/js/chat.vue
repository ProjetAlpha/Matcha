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
              <load-async-image needInfo="1" :user-id="value[0].user_profil_id" :profil-id="value[0].user_profil_id" img-style="center-img responsive-img rounded-img"></load-async-image>
              <online-user-info :user-id="value[0].user_profil_id"></online-user-info>
            </div>
            <div class="row mr-t-4">
                <div class="col s8 m6 l6">

                      <a style="" @click="loadMessage(value, name)">
                          <h6 class="truncate">
                            <span v-if="value[value.length - 1].user_msg_id == user.id">
                              Vous :
                            </span>
                            <span v-else-if="user !== ''">
                              {{value[value.length - 1].firstname}} :
                            </span>
                            {{value[value.length - 1].content}}
                          </h6>
                      </a>
                  </div>
              </div>
          </li>
        </ul>
      </div>
    </div>
    <div v-if="isMessageLoaded === true">
      <chat-message @showMainChat="resetloadedMessage($event)" :messages="selectedRoom" :user="user"></chat-message>
    </div>
  </div>

</template>

<script>

export default {
  created(){
    this.fetchConversation()
    this.$checkIfLogged().then(response => {
      this.user = response ? response : false;
    });
  },

  updated(){
    //this.selectedRoom = this.matchedUserChat[this.currentRoomId]
  },

  data(){
      return {
        currentLastname:'',
        currentFirstname:'',
        currentRoomId:'',
        lastname:[],
        firstname:[],
        dstUser:'',
        selectedRoom:'',
        user:'',
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

    compareMsgTime(a, b){

      const msgATime = new Date(a.post_msg_time)
      const msgBTime = new Date(b.post_msg_time)

      let compare = 0;
      if (msgATime > msgBTime){
        compare = 1
      }else if (msgATime < msgBTime){
        compare = -1
      }
      return compare
    },

    sortMsgTime(room){
      room.sort(this.compareMsgTime)
      return ;
    },

    fetchConversation(){
      this.$http.get('/chat/fetchMatchedUser').then((response) => {
        if (response.data){
          this.matchedUserChat = response.data.matched
          this.selectedRoom = this.matchedUserChat[this.currentRoomId]
          for (const property in this.matchedUserChat){
            if (this.matchedUserChat.hasOwnProperty(property)){
                this.sortMsgTime(this.matchedUserChat[property])
              }
            }
          }
      });

      setInterval(() => {this.$http.get('/chat/fetchMatchedUser').then((response) => {
        //console.log(response.data)
        if (response.data){
          this.matchedUserChat = response.data.matched
          this.selectedRoom = this.matchedUserChat[this.currentRoomId]
          for (const property in this.matchedUserChat){
            if (this.matchedUserChat.hasOwnProperty(property)){
                this.sortMsgTime(this.matchedUserChat[property])
              }
            }
          }
        });
      }, 1000)
    },

    setProfilName(e, room){
      if (e.firstname && e.lastname && !this.matchedUserChat[room].hasOwnProperty('firstname')){
        this.matchedUserChat[room].firstname = e.firstname
        this.matchedUserChat[room].lastname = e.lastname
      }
      this.isUpdated = 1
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

    loadMessage(roomMsg, name){
      // load les messages de la room_id.
      this.isMessageLoaded = true
      //this.sortMsgTime(roomMsg)
      this.currentRoomId = name
      this.selectedRoom = roomMsg
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
