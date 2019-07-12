<template>
  <div>
    <p class="black-text center-align mr-b-1"><strong>{{ title.name }}</strong></p>
    <hr style="margin-bottom:2%!important;margin-top:1%!important">
    <div class="row" v-for="(value, name, index) in rangeFilter" :key="index" >
      <p class="black-text center-align mr-b-3">{{ name.charAt(0).toUpperCase() + name.slice(1) }}</p>
      <div :id="setId(name, index)" :value="value" :name="name"></div>
    </div>
    <div class="row" style="margin-bottom:0!important">
      <div class="input-field col s12" style="margin:0!important">
        <input class="validate" v-model="localisation" @change="sendInput($event.target.value)" :id="createLoc(filterId.id)" type="text">
        <label :for="createLoc(filterId.id)">Ville</label>
      </div>
    </div>
    <div class="chips chips-autocomplete mr-b-1" id="chips-filter" style="margin-top:0!important"></div>
  </div>
</template>

<script>

export default {
  props:[
  'actionBtn', 'rangeFilter',
  'sortFilter', 'sortFilterName', 'title',
  'customStyle', 'customStyleCard', 'setStyle',
  'filterId', 'refresh'
  ],

  mounted(){
    this.initSlider()
    this.initChips()
    this.isDomReady = true
  },

  watch:{
    refresh(value){
      if (value === true){
          //this.resetSlider()
          this.initChips()
          this.tags = []
          this.localisation = ''
          this.$emit('sendFilterData', 'resetRefresh')
      }
    }
  },

  data(){
    return {
      value:'',
      localisation:'',
      isDomReady:false,
      id : [],
      selectedSortFilter:'',
      tags:[],
      chipsInstance:''
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
          start: [18, 45],
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

    resetSlider(){
      this.id.forEach((value) => {
        const target = document.getElementById(value)
        target.noUiSlider.reset()
      })
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
          limit: 10
        },
        onChipAdd(e, data){ vm.chipAdded(e, data); },
        onChipDelete(e, data) { vm.chipDelete(e, data); }
      };
      M.Chips.init(elems, options)
      this.chipInstance = M.Chips.getInstance(elems)
    },

    chipAdded(e, data){
      this.tags = [...this.tags, data.childNodes[0].textContent]
      this.$emit('sendFilterData', {type:'tags', value:this.tags})
    },

    chipDelete(e, data){
      if (data === null || data === undefined)
        return ;
      const index = this.tags.indexOf(data.childNodes[0].textContent)
      if (index !== -1)
        this.tags.splice(index, 1);
      this.$emit('sendFilterData', {type:'tags', value:this.tags})
    },

    sendInput(value){
      this.$emit('sendFilterData', {type:'localisation', value:value})
    }
  }
}
</script>
