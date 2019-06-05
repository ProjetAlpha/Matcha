<template>

<div class="container" style="height:100%">
  <user-filter
  :custom-style="{width:'50%'}"
  :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s8 push-s2 m6 push-m2 l3 push-l2'}"
  :title="{name:'Rechercher'}"
  :range-filter="{age:'Age', popularite:'Popularite'}"
  :sort-filter="{name:'Age', localisation:'Localisation', popularite:'Popularite', tags:'Tags'}"
  :sort-filter-name="{name:'Trier les résultats'}"
  :action-btn="{name:'Confirmer'}"
  :filter-id="{id:'1'}">
  </user-filter>

    <user-filter
    :custom-style="{width:'50%'}"
    :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s8 push-s2 m6 push-m2 l3 push-l2'}"
    :title="{name:'Filtrer les résultats'}"
    :range-filter="{age:'Age', popularite:'Popularite'}"
    :sort-filter="{name:'Age', localisation:'Localisation', popularite:'Popularite', tags:'Tags'}"
    :sort-filter-name="{name:'Trier les résultats'}"
    :action-btn="{name:''}"
    :filter-id="{id:'2'}">
    </user-filter>
</div>


</template>

<script>

import userFilter from './userFilter.vue'

export default {

  mounted() {
    console.log(this.localisation)
    //this.initSlider();
  },

  data() {
    return {
      activateTag:false,
      localisation:''
    }
  },

  methods: {
    initSlider() {
      const slider = this.$refs.testSlider;
      this.$noUiSlider.create(slider, {
        start: [0, 0],
        connect: true,
        step: 1,
        orientation: 'horizontal', // 'horizontal' or 'vertical'
        range: {
          'min': 0,
          'max': 100
        },
        format: wNumb({
          decimals: 0
        })
      });
      const slider2 = this.$refs.testSlider2;
      this.$noUiSlider.create(slider2, {
        start: [0, 0],
        connect: true,
        step: 1,
        orientation: 'horizontal', // 'horizontal' or 'vertical'
        range: {
          'min': 0,
          'max': 100
        },
        format: wNumb({
          decimals: 0
        })
      });
    },

    sendData(){
      // this.localisation && slider value... && tags value = refs
      console.log(this.$refs)
    }
  }
}

</script>
