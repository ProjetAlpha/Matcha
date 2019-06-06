<template>

  <div class="container" style="width:100%!important;height:100%!important;max-width:80%!important">
    <div v-if="type === 'result'" class="row s-v-align">
      <div class="col s12 m4 l4">
      <user-filter
      :custom-style="{width:'100%', height:'100%'}"
      :custom-style-card="{width:'100%', height:'100%'}"
      :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s8 m6 l3 s-responsive-row'}"
      :title="{name:'Filter'}"
      :range-filter="{age:'Age', popularite:'Popularite'}"
      :sort-filter="{name:'Age', localisation:'Localisation', popularite:'Popularite', tags:'Tags'}"
      :sort-filter-name="{name:'Trier les résultats'}"
      :action-btn="{name:'Confirmer'}"
      :filter-id="{id:'1'}"
      v-on:sendFilterData="handleData($event)">
      <!--
          - Mettre un component qui affiche les resultats...  (resultats des suggestions ou de la recherche).
          - Cards horizontal avec photo de profil + les infos a droite.
          - Pagination des resultats ==> n_resulat par page (injecte le numero de la page via la vue).
          - Quand on update le filtre + confirme ==>
      -->
    </user-filter>
  </div>
    <div class="col s12 m10 l10">
      <div class="card horizontal">
        <div class="card-image">
          <img class="responsive-image circle" src="https://lorempixel.com/100/190/nature/6">
        </div>
        <div class="card-stacked">
          <div class="card-content">
            <p>I am a very simple card. I am good at containing small bits of information.</p>
          </div>
          <div class="card-action">
            <a href="#">Consulter le profil</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div v-if="type === 'search'" class="row">
    <user-filter
    :custom-style="{width:'60%', height:'100%'}"
    :custom-style-card="{width:'100%', height:'100%'}"
    :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s8 m6 push-m2 push-s2 push-l2 l3'}"
    :title="{name:'Rechercher'}"
    :range-filter="{age:'Age', popularite:'Popularite'}"
    :sort-filter="{name:'Age', localisation:'Localisation', popularite:'Popularite', tags:'Tags'}"
    :sort-filter-name="{name:'Trier les résultats'}"
    :action-btn="{name:'Confirmer'}"
    :filter-id="{id:'1'}"
    v-on:sendFilterData="handleData($event)">
  </user-filter>
  </div>
</div>
</template>

<script>

import userFilter from './userFilter.vue'

export default {

  props:['type'],
  data() {
    return {
      isSearch:'',
      isFilter:'',
      activateTag:false,
      localisation:'',
      sliderData:[],
      tags:[]
    }
  },

  methods: {
    handleData(filterData){
      if (filterData.type == 'tags')
        this.tags = filterData.value;
      if (filterData.type == 'localisation')
        this.localisation = filterData.value;
      if (filterData.type == 'slider'){
        let filter = filterData;
        this.sliderData[filterData.name] = {minRange:filter.range[0], maxRange:filter.range[1]};
      }
      if (filterData.type == 'sendData'){
        // envoyer les datas au serveur (localisation, sliderData, tags).
      }
    }
  }
}

</script>
