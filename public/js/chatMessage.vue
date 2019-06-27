<template>
  <div :class="hideMessage ? 'hide row' : 'row'">
    <div class="row">
      <div class="col">
        <a @click="showHistoric"><i class="material-icons medium left">keyboard_arrow_left</i>Revenir en arriére</a>
      </div>
    </div>
    <div class="col s12 m10 push-m1 l9 push-l1" style="overflow:auto;height:70%;width:100%">
      <ul class="collection">
        <li class="row collection-item avatar">
          <div class="row" style="padding:0!important;margin:0!important">
            <div class="col s8 m5 l4">
                <div class="chip grey black-text">
                  Msg.
                </div>
            </div>
          </div>
          <div class="row" style="padding:0!important;margin:0!important">
            <div class="col right">
                <div class="chip blue white-text right">
                  Msg.
                </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <input-chat-message ></input-chat-message>
  </div>
</template>


<script>

export default{
  props:['roomId'],

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
      // emit un event pour show l'historic des datas.
    }
  }
}

</script>
