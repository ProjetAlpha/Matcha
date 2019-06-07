<template>

  <div class="row" style="margin:0;padding:0">
    <div class="col card teal lighten-5 hoverable s8 m6 l3 s-responsive-row" style="margin:0!important;width:100%!important;">
      <div class="card-content">
        <h6 class="center-align">Trier age / popularite </h6>
        <hr>
        <div class="input-field col s12">
          <select class="icons" @change="getSortTypeValue">
            <option value="" disabled selected>Trier par ordre</option>
            <option value="croissant">Croissant</option>
            <option value="decroisant">Décroissant</option>
          </select>
          <label class="mr-b-1">Séléctionner un ordre</label>
        </div>
        <div class="input-field col s12">
          <select class="icons" @change="getSortValue">
            <option value="" disabled selected>Trier par type</option>
            <option value="user-Age">Age</option>
            <option value="popularite">Popularité</option>
          </select>
          <label class="mr-b-1">Séléctionner un type</label>
        </div>
        <h6 class="center-align">Trier par localisation / tags</h6>
        <hr>
        <div class="row" style="margin-top:0!important">
          <div class="input-field col s12" style="margin:0!important;">
            <input  @change="sendInput($event.target.value)" id="sortLocalisation" type="text" class="validate">
            <label for="sortLocalisation">Localisation</label>
          </div>
        </div>
        <div class="chips chips-autocomplete" id="sort-chips" style="margin-top:0!important"></div>
        <div class="card-action mr-t-2" style="border-top:none;">
          <button type="" @click="sendData()" class="btn green waves-effect waves-light" value="">Confirmer</button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
  export default {

    mounted(){
      this.initChips()
    },

    data(){
      return {
        tags:[],

      }
    },

    methods:{
      getSortValue(e){
        if (e.target.options.selectedIndex > -1){
          this.$emit('sendSortData', {type:'selectedSortVal', value:e.target.options[e.target.options.selectedIndex].value});
        }
      },

      getSortTypeValue(e){
        if (e.target.options.selectedIndex > -1){
          this.$emit('sendSortData', {type:'selectedSortType', value:e.target.options[e.target.options.selectedIndex].value});
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
        var instances = M.Chips.init(elems, options);
      },

      chipAdded(e, data){
        this.tags = [...this.tags, data.childNodes[0].textContent]
        this.$emit('sendSortData', {type:'tags', value:this.tags})
      },

      chipDelete(e, data){
        const index = this.tags.indexOf(data.childNodes[0].textContent)
        if (index !== -1)
          this.tags.splice(index, 1);
        this.$emit('sendSortData', {type:'tags', value:this.tags})
      },

      sendInput(value){
        this.$emit('sendSortData', {type:'localisation', value:value})
      },

      sendData(){
        this.$emit('sendSortData', 'sendData')
      }
    }

  }
</script>
