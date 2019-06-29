<template>
  <div :class="hideMessage ? 'hide row' : 'row'">
    <div class="row">
      <div class="col">
        <a @click="showHistoric"><i class="material-icons medium left">keyboard_arrow_left</i>Revenir en arriére</a>
      </div>
    </div>
    <div class="col s12 m10 push-m1 l8 offset-l2" style="overflow:auto;height:70%;">
      <ul class="collection">
        <li class="row collection-item avatar">
          <div class="row" style="padding:0!important;margin:0!important" v-for="(value, name, index) in messages">
            <div class="col s12 m6 offset-m2 l8 offset-l2">
              <div :class="value.user_msg_id == user.id && messages.length !== 1 ? 'right' : ''">
                {{new Date(value.msg_time).toLocaleDateString("fr-FR", { month: 'long', day: 'numeric', hour: "numeric", minute:"numeric"})}}
              </div>
            </div>
            {{index}}
            <div class="col s12 m6 offset-m2 l8 offset-l2">
                <div :class="value.user_msg_id == user.id && messages.length !== 1 ? 'chip blue white-text right' : 'chip grey lighten-2 black-text'">
                  {{value.content}}
                </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <input-chat-message @addRoomMsg="addMessageToRoom($event)" :room-id="messages[0].room_id" :user="user"></input-chat-message>
  </div>
</template>


<script>

export default{
  props:['roomId', 'messages','user'],


  created(){
    // si on a des news messages, update les msgs.

  },

  data(){
    return {
      hideMessage:'',
      showMainChat:''
    }
  },

  methods:{
    updateMessage(){
      // si on a des news messages, update.

    },

    showHistoric(){
      this.hideMessage = true
      this.showMainChat = true
      this.$emit('showMainChat', this.showMainChat)
      // emit un event pour show l'historic des datas.
    },

    addMessageToRoom(e){
      this.messages.push(e)
      //console.log(this.messages)
      // time..
      //e.roomId =
    }
  }
}

</script>
