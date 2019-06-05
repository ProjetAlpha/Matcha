<template>
  <div class="row">
    <div :class="setStyle.value" :style="customStyle">
      <div class="card-content white-text">
        <div class="row">
          <p class="black-text center-align mr-b-1">{{ title.name }}</p>
        </div>
        <hr>
        <!--<div class="row mr-b-2"> compo[0].data | compo[1].data
           <select @change="onChange($event)">
            <option value="" disabled selected>{{ sortFilterName.name }}</option>
            <option v-for="(value, name, index) in sortFilter" :value="name">{{ name }}</option>
          </select>
          <label>Selectionner un filtre</label>
        </div> -->
        <div class="row" v-for="(value, name, index) in rangeFilter" :key="index">
          <p class="black-text center-align mr-b-3">{{ name }}</p>
          <div :id="setId(name, index)" :value="value" :name="name"></div>
        </div>
        <div class="row">
          <div class="input-field col s12">
            <input  v-bind:value="value" v-on:change="$emit('input', $event.target.value)" :id="createLoc(filterId.id)" type="text" class="validate">
            <label :for="createLoc(filterId.id)">Localisation</label>
          </div>
        </div>
        <p>
          <label>
            <input type="checkbox" ref="tag1"/>
            <span>Tag 1</span>
          </label>
        </p>
        <p>
          <label>
            <input type="checkbox" ref="tag2"/>
            <span>Tag 2</span>
          </label>
        </p>
        <p>
          <label>
            <input type="checkbox" ref="tag3"/>
            <span>Tag 3</span>
          </label>
        </p>
        <div v-if="actionBtn.name" class="card-action mr-t-2">
          <button type="submit" @click="sendData()" class="btn green waves-effect waves-light" value="">{{ actionBtn.name }} </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  props:['actionBtn', 'rangeFilter', 'sortFilter', 'sortFilterName', 'title', 'customStyle', 'setStyle', 'filterId'],

  mounted(){
    this.initSlider()
    this.isDomReady = true
  },

  data(){
    return {
      value:'',
      filterLocalisation:[],
      localisation:[],
      isDomReady:false,
      id : [],
      noUiEvent:[],
      selectedSortFilter:''
    }
  },

  methods:{
    // quand on clic envoie this.noUiEvent ou this.selectedSortFilter / tags (si this.$refs.cheked => span value) / filterLocalisation
    // et actualise les resultats...(emit un event => fetch new data + actualise le DOM).
    // tags = depend ID du filtre...
    //
    onChange(event) {
        this.selectedSortFilter = event.target.value
    },
    initSlider(){
      if (this.id.length === 0)
        return ;
      var vm = this;
      vm.id.forEach(function(value){
        var id = document.getElementById(value)
        vm.$noUiSlider.create(id, {
          start: [0, 0],
          connect: true,
          step: 1,
          orientation: 'horizontal',
          range: {
            'min': 0,
            'max': 100
          },
          format: wNumb({
            decimals: 0
          })
        });
        id.noUiSlider.on('update', function (value, handle) {
          let range = this.get()
          var target = this.target.id.split('-')[0]
          vm.noUiEvent.forEach(function(value, index){
            if (target !== undefined && value.name == target){
              vm.noUiEvent[index].minRange = range[0]
              vm.noUiEvent[index].maxRange = range[1]
            }
          });
        });
      });
    },
    setId(name, index){
      // qd on clic sur confirmer prend toutes les datas associes avec cette ID et send les DATA..
      const id = this.makeid(10)+'-'+index;
      if (this.isDomReady === false){
        this.id = [...this.id, id]
        const obj = {id:this.filterId, name: name, maxRange:0, minRange:0}
        this.noUiEvent = [...this.noUiEvent, obj]
      }
      return (id)
    },

    makeid(length){
      var result           = '';
      var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
      var charactersLength = characters.length;
      for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
      }
      return result
    },

    createLoc(id){
      console.log(this.filterLocalisation)
        const target = 'filter'+id
        if (this.isDomReady === false){
          this.localisation = [...this.localisation, {id:target, name:''}]
        }
        return (target)
    },
    input(val){
      console.log(val)
      /*const val = event.target.value
      console.log(val)
      if (this.isDomReady === false){
        this.filterLocalisation.forEach(function(value, index){
          if (value.id == this.filterId){
            this[index].name = val
          }
        });
        console.log(this.filterLocalisation)
      }*/
    }
  }
}
</script>
