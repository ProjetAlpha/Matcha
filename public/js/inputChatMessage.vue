<template>

  <div class="input-field col s12 m6 offset-m3 l6 offset-l3 grey lighten-2 search-border" style="position:relative;bottom:0;">
    <i class="material-icons prefix" style="top:10%!important">message</i>
    <textarea placeholder="Écrivez un message" id="textarea1" v-model="message" class="materialize-textarea" style="border-bottom:0!important;box-shadow:0 0px!important"></textarea>
    <a class="right mr-r-3" @click="sendMessage"><i class="material-icons small center" style="float:right">navigate_next</i>Envoyer</a>
  </div>


</template>

<script>

export default{
  props:['roomId', 'userId', 'user'],

  created(){
    //console.log(this.roomId)
  },

  data(){
    return {
      message:''
    }
  },

  methods:{
    sendMessage(){
      // ajouter 1 message pour room X.
      // toute les 1 secondes refech les news messages -- les ajouter + resort.
      // push new msg dans la room... push a la fin.
      const time = this.getDate()
      //console.log("room id" + time)
      this.$http.post('/chat/addMessage', {roomId:this.roomId, message:this.message, time:time}).then((response) => {
          //console.log(response.data)
      });
      //Y-m-d H:i:s
      //console.log(time)
      this.$emit('addRoomMsg', {roomId:this.roomId, content:this.message, msg_time:time, user_msg_id:this.user.id});
      this.message = '';
    },

    getDate(){
      const currentdate = new Date();
      const datetime = currentdate.getFullYear() + "/"
                + (currentdate.getMonth()+1)  + "/"
                + currentdate.getDate() + " "
                + currentdate.getHours() + ":"
                + currentdate.getMinutes() + ":"
                + currentdate.getSeconds();
      return (datetime);
    }
  }
}

</script>
