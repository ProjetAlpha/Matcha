<template>
  <div class="row fixed-search fixed-top" :style="customStyle">
      <div :class="setStyle.value" :style="customStyleCard">
        <div class="card-content white-text" style="padding:1em!important">
          <p class="black-text center-align mr-b-1">{{ title.name }}</p>
          <hr style="margin-bottom:2%!important;margin-top:1%!important">
          <div class="row" v-for="(value, name, index) in rangeFilter" :key="index" >
            <p class="black-text center-align mr-b-3">{{ name }}</p>
            <div :id="setId(name, index)" :value="value" :name="name"></div>
          </div>
          <div class="row" style="margin-bottom:0!important">
            <div class="input-field col s12" style="margin:0!important">
              <input class="validate" @change="sendInput($event.target.value)" :id="createLoc(filterId.id)" type="text">
              <label :for="createLoc(filterId.id)">Ville</label>
            </div>
          </div>
          <div class="chips chips-autocomplete mr-b-1" id="chips-filter" style="margin-top:0!important"></div>
          <!--<div v-if="actionBtn.name" class="card-action mr-t-2" style="border-top:none;">
            <button type="" @click="sendData()" class="btn-small green waves-effect waves-light" value="">{{ actionBtn.name }} </button>
          </div>-->
        </div>
      </div>
  </div>
</template>

<script>

'use strict'

export default {
  props:['actionBtn', 'rangeFilter', 'sortFilter', 'sortFilterName', 'title', 'customStyle', 'customStyleCard', 'setStyle', 'filterId'],

  mounted(){
    this.initSlider()
    this.initChips()
    this.isDomReady = true
  },

  data(){
    return {
      value:'',
      localisation:'',
      isDomReady:false,
      id : [],
      selectedSortFilter:'',
      tags:[]
    }
  },

  methods:{
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
          var range = this.get()
          var target = this.target.id.split('-')[0]
          vm.$emit('sendFilterData', {type:'slider', name:this.target.getAttribute('name'), range:range, target:target})
        });
      });
    },
    setId(name, index){
      const id = name+'-'+index;
      if (this.isDomReady === false){
        this.id = [...this.id, id]
      }
      return (id)
    },

    createLoc(id){
        const target = 'filter'+id
        return (target)
    },

    initChips(){
      var elems = document.getElementById('chips-filter')
      var vm = this
      var options = {
        placeholder: 'Entrer un tag',
        secondaryPlaceholder: '+Tag',
        autocompleteOptions: {
          data: {
            'Php': null,
            'Java': null,
            'Js': null,
            'Music': null,
            'Film': null,
            'Google': null,
            'Microsoft': null,
            'Ola': null
          },
          limit: Infinity
        },
        onChipAdd(e, data){ vm.chipAdded(e, data); },
        onChipDelete(e, data) { vm.chipDelete(e, data); }
      };
      var instances = M.Chips.init(elems, options);
    },

    chipAdded(e, data){
      this.tags = [...this.tags, data.childNodes[0].textContent]
      this.$emit('sendFilterData', {type:'tags', value:this.tags})
    },

    chipDelete(e, data){
      const index = this.tags.indexOf(data.childNodes[0].textContent)
      if (index !== -1)
        this.tags.splice(index, 1);
      this.$emit('sendFilterData', {type:'tags', value:this.tags})
    },

    sendInput(value){
      this.$emit('sendFilterData', {type:'localisation', value:value})
    },

    sendData(){
      this.$emit('sendFilterData', 'sendData')
    }
  }
}
</script>
