<template>


  <!-- Dropdown Structure -->
<ul :id="notificationId" class='dropdown-content'>
  <div class="row" v-for="(value, name, index) in notificationData">
        <li v-if="value.type == 'like'" style="line-height:0!important;">
          <a :href="/profil/+value.id">
            <i class="material-icons">thumb_up</i>
            <strong>{{value.firstname}}, {{value.lastname}}</strong> vous a like
          </a>
        </li>
        <li v-if="value.type == 'like'" class="divider" tabindex="-1"></li>
        <li v-if="value.type == 'visiter'" style="line-height:0!important;">
          <a :href="/profil/+value.id"><i class="material-icons">visibility</i>
            <strong>{{value.firstname}}, {{value.lastname}}</strong> a visite votre profil
          </a>
        </li>
        <li v-if="value.type == 'visiter'" class="divider" tabindex="-1"></li>
        <li v-if="value.type == 'newMessage'" style="line-height:0!important;">
          <a :href="/profil/+value.id">
            <i class="material-icons">message</i>
            <strong>{{value.firstname}}, {{value.lastname}}</strong> vous a envoye um message
          </a>
        </li>
        <li v-if="value.type == 'newMessage'" class="divider" tabindex="-1"></li>
        <li v-if="value.type == 'match'" style="line-height:0!important;">
          <a :href="/profil/+value.id">
            <i class="material-icons">thumb_up</i>
            <strong>{{value.firstname}}, {{value.lastname}}</strong> vous a envoye un like en retour
          </a>
        </li>
        <li v-if="value.type == 'match'" class="divider" tabindex="-1"></li>
        <li v-if="value.type == 'unmatch'" style="line-height:0!important;">
          <a :href="/profil/+value.id">
            <i class="material-icons">thumb_down</i>
            <strong>{{value.firstname}}, {{value.lastname}}</strong> matche ne vous like plu
          </a>
        </li>
  </div>
</ul>

</template>


<script>

// closeOnClick : false
// qd on a une notif recalcul le drop down: instance.recalculateDimensions();
// requete toute les 1 secondes.
  export default{
      props:['notificationId', 'notificationData'],


      created(){

      },

      watch:{
        notificationData(){
          console.log(this.notificationData)
        }
      },

      data(){
        return {

        }
      },

      methods:{

      }
  }

</script>
