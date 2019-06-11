<template>


  <!-- Dropdown Structure -->
<ul :id="notificationId" class='dropdown-content a-wrap'>
        <li style="line-height:0!important"><a href="#!"><i class="material-icons">thumb_up</i>User X vous a like</a></li>
        <li class="divider" tabindex="-1"></li>
        <li style="line-height:0!important"><a href="#!"><i class="material-icons">visibility</i>User X a visite votre profil</a></li>
        <li class="divider" tabindex="-1"></li>
        <li><a href="#!"><i class="material-icons">message</i>User X vous a envoye um message</a></li>
        <li class="divider" tabindex="-1"></li>
        <li><a href="#!"><i class="material-icons">thumb_up</i>User X vous a envoye um like en retour</a></li>
        <li class="divider" tabindex="-1"></li>
        <li><a href="#!"><i class="material-icons">thumb_down</i>User X matche ne vous like plu</a></li>
</ul>

</template>


<script>

// closeOnClick : false
// qd on a une notif recalcul le drop down: instance.recalculateDimensions();
// requete toute les 1 secondes.
  export default{
      props:['notificationId'],
      data(){
        return {

        }
      },

      methods:{

      }
  }

</script>
