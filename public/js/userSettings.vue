<template>
  <div class="hero-body">
    <div class="row valign-wrapper login-box" style="width:100%;height:100%">
      <div class="col card teal lighten-5 hoverable s12 pull-s1 m7 pull-m2 l6 pull-l3">
        <div class="card-content">
          <span class="card-title">Nom </span>
          <button :class="classManager.name ? offClass : logoClass" v-on:click="activateData('name')">
            {{ data.name }}
            <i class="material-icons">edit</i>
          </button>
          <div :class="classManager.name ? onClass : offClass">
            <label for="name" style="color:black!important"></label>
            <input type="text" v-model="data.name" class="validate" name="name" id="name" />
            <div class="card-action right-align" style="border-top:none!important">
              <button type="submit" v-on:click="resetData('name')" class="btn green waves-effect waves-light" value="">Confirmer</button>
            </div>
          </div>
          <span class="card-title mr-t-2">Prenom </span>
          <button :class="classManager.lastname ? offClass : logoClass" v-on:click="activateData('lastname')">
            {{ data.lastname }}
            <i class="material-icons">edit</i>
          </button>
          <div :class="classManager.lastname ? onClass : offClass">
            <label for="lastname" style="color:black!important"></label>
            <input type="text" v-model="data.lastname" class="validate" name="lastname" id="lastname" />
            <div class="card-action right-align" style="border-top:none!important">
              <button type="submit" v-on:click="resetData('lastname')" class="btn green waves-effect waves-light" value="">Confirmer</button>
            </div>
          </div>
          <div class="input-field col s12">

          </div>
          <div class="input-field col s12">

          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
      data(){
        return {
          // server request fetch data.
          data: {
            name:'joe',
            lastname:'doh'
          },
          onClass: 'input-field col s12',
          logoClass:'mr-l-4 mr-b-3 fs-1 btn blue-grey darken-3 waves-effect waves-light basic-txt',
          offClass:'none',
          classManager: {
            name:false,
            lastname:false,
            email:false,
            pwd:false
          }
        }
      },

      methods:{
        activateData(key){
          if (this.classManager.hasOwnProperty(key)){
            if (this.classManager[key] === true)
              this.classManager[key] = false;
            if (this.classManager[key] === false)
              this.classManager[key] = true;
          }
        },
        resetData(key){
          if (this.classManager.hasOwnProperty(key))
            this.classManager[key] = false;
          // server request... avec new data value.
        }
      }
  }
</script>
