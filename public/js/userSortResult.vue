<template>

  <div class="mr-t-6">
    <p class="black-text center-align mr-b-1"><strong>Trier</strong></p>
    <hr style="margin-bottom:2%!important;margin-top:1%!important">
    <div class="row" style="margin-bottom:0!important;margin-top:0!important">
      <div class="input-field col s12">
        <select class="icons" id="type" @change="getSortValue">
          <option value="begin" disabled selected>Trier par</option>
          <option value="user-Age">Age</option>
          <option value="score">Score</option>
        </select>
        <label class="mr-b-1">Séléctionner un type</label>
      </div>
    </div>
    <div class="row" style="margin-bottom:0!important;margin-top:0!important">
      <div class="input-field col s12" style="margin:0!important">
        <input  v-model="localisation" @change="sendInput($event.target.value)" id="sortLocalisation" type="text" class="validate">
        <label for="sortLocalisation">Ville</label>
      </div>
    </div>
    <div class="chips chips-autocomplete mr-b-1" id="sort-chips" style="margin-top:0!important"></div>
  </div>
</div>
</template>


<script>
  export default {

    props:['refresh'],

    mounted(){
      this.initChips()
    },

    watch:{
      refresh(value){
        if (value === true){
            this.initChips()
            this.tags = []
            this.localisation = ''
            this.selectedType = ''
            this.$emit('sendSortData', 'resetRefresh')
        }
      }
    },

    data(){
      return {
        tags:[],
        localisation:'',
        selectedType:'',
        chipsInstance:''
      }
    },

    methods:{
      getSortValue(e){
        if (e.target.options.selectedIndex > -1){
          this.selectedType = e.target.options[e.target.options.selectedIndex].value
          this.$emit('sendSortData', {type:'selectedSortType', value:this.selectedType, data:this});
        }
      },

      initChips(){
        var elems = document.getElementById('sort-chips');
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
        M.Chips.init(elems, options)
        this.chipsInstance = M.Chips.getInstance(elems)
      },

      chipAdded(e, data){
        if (data === (null || undefined))
          return ;
        this.tags = [...this.tags, data.childNodes[0].textContent]
        this.$emit('sendSortData', {type:'tags', value:this.tags, data:this})
      },

      chipDelete(e, data){
        if (data === (null || undefined))
          return ;
        const index = this.tags.indexOf(data.childNodes[0].textContent)
        if (index !== -1)
          this.tags.splice(index, 1);
        this.$emit('sendSortData', {type:'tags', value:this.tags, data:this})
      },

      sendInput(value){
        this.$emit('sendSortData', {type:'localisation', value:value, data:this})
      }
    }

  }
</script>
