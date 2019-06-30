<template>
  <div :class="hideMessage ? 'hide row' : 'row'">
    <div class="row">
      <div class="col">
        <a @click="showHistoric"><i class="material-icons medium left">keyboard_arrow_left</i>Revenir en arriére</a>
      </div>
    </div>
    <div class="col s12 m10 push-m1 l8 offset-l2" style="overflow:auto;height:70%;">
      <ul class="collection">
        <li class="row collection-item avatar" v-if="Array.isArray(messages) && messages[0].hasOwnProperty('content')">
          <div class="row" style="padding:0!important;margin:0!important" v-for="(value, name, index) in messages">
            <div class="col s12 m6 offset-m2 l8 offset-l2">
              <div :class="value.hasOwnProperty('user_msg_id')
              && value.user_msg_id == user.id ? 'right' : ''">
                {{new Date(value.msg_time).toLocaleDateString("fr-FR", { month: 'long', day: 'numeric', hour: "numeric", minute:"numeric"})}}
              </div>
            </div>
            {{index}}
            <div class="col s12 m6 offset-m2 l8 offset-l2">
                <div :class="value.hasOwnProperty('user_msg_id')
                && value.user_msg_id == user.id ? 'chip blue white-text right' : 'chip grey lighten-2 black-text'">
                  {{value.content}}
                </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <input-chat-message @addRoomMsg="addMessageToRoom($event)" :room-id="Array.isArray(messages) && messages[0].room_id" :user="user"></input-chat-message>
  </div>
</template>


<script>

export default{
  props:['roomId', 'messages','user'],

  data(){
    return {
      hideMessage:'',
      showMainChat:''
    }
  },

  methods:{

    showHistoric(){
      this.hideMessage = true
      this.showMainChat = true
      this.$emit('showMainChat', this.showMainChat)
    },

    addMessageToRoom(e){
      if (this.messages !== '' && this.messages !== undefined)
        this.messages.push(e)
    }
  }
}

</script>
