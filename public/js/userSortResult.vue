<template>

  <div class="row fixed-search fixed-bottom" style="margin:auto;">
    <div class="col card teal lighten-5 hoverable s12 m8 l6 s-responsive-row" style="margin:0!important;width:100%!important">
      <div class="card-content" style="padding:1em!important">
        <p class="black-text center-align mr-b-1">Trier</p>
        <hr style="margin-bottom:2%!important;margin-top:1%!important">
        <div class="row" style="margin-bottom:0!important;margin-top:0!important">
          <div class="input-field col s12">
            <select class="icons" @change="getSortValue">
              <option value="" disabled selected>Trier par</option>
              <option value="user-Age">Age</option>
              <option value="score">Score</option>
            </select>
            <label class="mr-b-1">Séléctionner un type</label>
          </div>
        </div>
        <div class="row" style="margin-bottom:0!important;margin-top:0!important">
          <div class="input-field col s12" style="margin:0!important">
            <input  @change="sendInput($event.target.value)" id="sortLocalisation" type="text" class="validate">
            <label for="sortLocalisation">Ville</label>
          </div>
        </div>
        <div class="chips chips-autocomplete mr-b-1" id="sort-chips" style="margin-top:0!important"></div>
        <div class="card-action mr-t-2" style="border-top:none;">
          <button type="" @click="sendData()" class="btn-small green waves-effect waves-light basic-txt right mr-b-3" value="">Confirmer</button>
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
