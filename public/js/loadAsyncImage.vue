<template>
      <a :href="/profil/+profilId" target="_blank"><img :src="link" alt="" :class="imgStyle"/></a>
</template>


<script>
export default {

  props:['userId', 'profilId', 'imgStyle'],

  created(){
    this.loadPic(this.userId)
  },

  data(){
    return {
      link:''
    }
  },

  methods:{
    getProfilPicById(id){
      return new Promise((resolve, reject) => {
        this.$http.post('/profil/getProfilPicById', {user_id:id}).then((response) => {
          resolve(response.data.path)
        });
      })
    },

    async fetchImgPic(id){
      return await this.getProfilPicById(id)
    },

    loadPic(id){
      this.fetchImgPic(id).then((response) => {
        if (response !== null && response !== undefined){
          this.link = 'data:image/png;base64,'+response;
        }
      });
    }
  }
}
</script>
