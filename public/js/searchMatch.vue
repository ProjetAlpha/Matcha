<template>


  <div class="container" style="width:100%!important;height:100%!important;max-width:80%!important">
    <div v-if="type === 'result'" class="row" style="width:100%!important">
      <div class="row">
        <ul class="col push-l2 l7 push-m1 m10 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
          <li style="row border:none!important padding:0!important;margin:0!important">
            <div class="collapsible-header"><i class="material-icons">sort</i>Filtrer</div>
            <div class="collapsible-body" style="padding:0!important;margin:0!important">
              <user-filter
              :custom-style="{width:'100%', height:'100%', margin:0, padding:0}"
              :custom-style-card="{width:'100%', height:'100%', margin:'0!important'}"
              :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s8 m6 l3 s-responsive-row'}"
              :title="{name:'Filtrer'}"
              :range-filter="{age:'Age', popularite:'Popularite'}"
              :sort-filter="{name:'Age', localisation:'Localisation', popularite:'Popularite', tags:'Tags'}"
              :sort-filter-name="{name:'Trier les résultats'}"
              :action-btn="{name:'Confirmer'}"
              :filter-id="{id:'1'}"
              v-on:sendFilterData="handleData($event)"></user-filter>
            </div>
          </li>
          <li style="row border:none!important padding:0!important;margin:0!important">
            <div class="collapsible-header"><i class="material-icons">sort</i>Trier</div>
            <div class="collapsible-body" style="padding:0!important;margin:0!important"><user-sort-result v-on:sendSortData="handleSortData($event)"></user-sort-result></div>
          </li>
        </ul>
      </div>
    <!-- Ici le sort des resultats... OMG -->
  <div class="row">
    <div class="col s12 m10 push-m1 l9 push-l1">
      <div class="card horizontal">
        <div class="card-image">
          <img class="responsive-img circle" src="https://lorempixel.com/100/190/nature/6">
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
    <div class="col s12 m10 push-m1 l9 push-l1">
      <div class="card horizontal">
        <div class="card-image">
          <img class="responsive-img circle" src="https://lorempixel.com/100/190/nature/6">
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
    <div class="col s12 m10 push-m1 l9 push-l1">
      <div class="card horizontal">
        <div class="card-image">
          <img class="responsive-img circle" src="https://lorempixel.com/100/190/nature/6">
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
</div>
<div v-if="type === 'search'" class="row">
  <div class="col s12 m8 push-m2 l6 push-l2">
    <user-filter
    :custom-style="{width:'100%', height:'100%'}"
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
</div>
</template>

<script>

import userFilter from './userFilter.vue'

export default {

  props:['type'],

  data() {
    return {
      selectedSortVal:[],
      selectedSortType:'',
      isSearch:'',
      isFilter:'',
      activateTag:false,
      filterLocalisation:'',
      sliderData:[],
      filterTags:[],
      sortTags:[],
      sortLocalisation:[]
    }
  },

  methods: {
    handleData(filterData){
      if (filterData.type == 'tags')
        this.filterTags = filterData.value;
      if (filterData.type == 'localisation')
        this.filterLocalisation = filterData.value;
      if (filterData.type == 'slider'){
        let filter = filterData;
        this.sliderData[filterData.name] = {minRange:filter.range[0], maxRange:filter.range[1]};
      }
      if (filterData.type == 'sendData'){
        // envoie les datas au serveur avec filtre data + sort data...
      }
    },

    handleSortData(sortData){
      if (sortData.type == 'tags')
        this.sortTags = sortData.value;
      if (sortData.type == 'localisation')
        this.sortLocalisation = sortData.value;
      if (sortData.type == 'selectedSortVal')
        this.selectedSortVal = sortData.value
      if (sortData.type == 'selectedSortType')
        this.selectedSortType = sortData.value
      if (sortData.type == 'sendData'){
        // envoie les datas au serveur avec filtre data + sort data...
      }
    }
  }
}

</script>
