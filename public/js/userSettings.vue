<template>
  <div class="hero-body" style="width:100%;height:100%">
    <div class="row valign-wrapper" style="width:100%;height:100%">
      <div class="col card teal lighten-5 hoverable s10 pull-s1 m7 pull-m2 l6 pull-l3">
        <div class="card-content" style="width:100%;height:100%">
          <div class="mr-t-3 mr-b-2" v-for="(value, name, index) in data">
            <span class="card-title">{{ title[name] }} </span>
            <div :class="classManager[name] ? offClass : logoClass" v-on:click="activateData(name)">
              <p class="" style="width:10%;font-size:1em"> {{ data[name] }} </p>
              <p class="right-align" style="width:100%;font-size:1vw!important">
                <a class="btn-small green waves-effect waves-light basic-txt" href="#">
                  <i class="material-icons right">edit</i>Modifier</a>
                </p>
              </div>
              <div :class="classManager[name] ? onClass : offClass">
                <label :for="name" style="color:black!important"></label>
                <input type="text" v-model="data[name]" class="validate" :name="name" :id="name" />
                <div class="card-action right-align valign-wrapper" style="border-top:none!important; width:100%;">
                  <button type="submit" v-on:click="resetData(name)" class="right-align mr-r-3 basic-txt btn-small green waves-effect waves-light" value="">Confirmer</button>
                  <button type="submit" v-on:click="cancelData(name)" class="center-align basic-txt btn-small green waves-effect waves-light" value="">Annuler</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </template>

<script>
  export default {
      props:['title'],

      created() {
        // server request fetch data.
        // function fetch data...
        this.classManager = this.initObject(this.data, false)
        this.tmpData = this.initObject(this.data, '')
      },

      data(){
        return {
          tmpData: '',
          data: {
            name:'joe',
            lastname:'doh',
            email:'test123@hotmail.fr',
            password:'******'
          },
          onClass: 'input-field col s12',
          logoClass:'valign-wrapper',
          offClass:'none',
          classManager: ''
        }
      },

      methods:{
        activateData(key){
          this.copyData();
          if (this.classManager.hasOwnProperty(key)){
            this.classManager[key] =  this.classManager[key] ? false : true;
          }
        },
        resetData(key){
          if (this.classManager.hasOwnProperty(key))
            this.classManager[key] = false;
          // ---------- server request... avec new data value.
        },
        cancelData(key){
          this.resetData(key);
          if (this.data.hasOwnProperty(key) && this.tmpData.hasOwnProperty(key))
              this.data[key] = this.tmpData[key];
        },
        isEmptyObject(obj){
          return (Object.entries(obj).length === 0 && obj.constructor === Object);
        },
        copyData(){
          this.tmpData = Object.assign({}, this.data)
        },

        initObject(src, type){
          let dst = {};
          Object.entries(src).forEach(
            ([key, value]) => dst[key] = type
          );
          return (dst);
        }
      }
  }
</script>
