<template>


  <div class="container" style="width:100%!important;height:100%!important;max-width:80%!important">
    <div v-if="type === 'result'" class="row" style="width:100%!important">
      <div class="row">
        <ul class="col push-l2 l7 m12 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
          <li style="row border:none!important padding:0!important;margin:0!important">
            <div class="collapsible-header"><i class="material-icons">sort</i>Filtrer</div>
            <div class="collapsible-body" style="padding:0!important;margin:0!important">
              <user-filter
              :custom-style="{width:'100%', height:'100%', margin:0, padding:0}"
              :custom-style-card="{width:'100%', height:'100%', margin:'0!important'}"
              :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s12 m6 l3 s-responsive-row'}"
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
        <ul class="col s12 m10 push-m1 l9 push-l1">
          <ul class="collection">
            <li class="row collection-item avatar">
              <div class="col s12 m6 l6">
                <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
              </div>
              <div class="col s8 m9 l6">
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span> <br>
                  <span class="black-text">
                    Toulouse
                  </span>
                </p>
                <div class="row mr-t-4">
                  <div class="chip blue white-text">
                    #php
                  </div>
                  <div class="chip blue white-text">
                    #java
                  </div>
                  <div class="chip blue white-text">
                    #css
                  </div>
                </div>
                <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
              </div>
              <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
            </li>
            <li class="row collection-item avatar">
              <div class="col s12 m6 l6">
                <img src="/Photo_profil.jpg" alt="" class="s-responsive-img rounded-img materialboxed">
              </div> <!-- notice the "circle" class -->
              <div class="col s8 m9 l6">
                <p class="black-text">
                  Thomas Broussoux <br>
                  <span class="black-text">
                    23 ans
                  </span> <br>
                  <span class="black-text">
                    Toulouse
                  </span>
                </p>
                <div class="row mr-t-4" style="width:100%!important">
                  <div class="chip blue white-text">
                    #php
                  </div>
                  <div class="chip blue white-text">
                    #java
                  </div>
                  <div class="chip blue white-text">
                    #css
                  </div>
                </div>
              </div> <br>
              <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#4caf50">lens</i>En ligne</a>
              <!-- <a href="#!" class="secondary-content"><i class="material-icons right" style="color:#ef5350">lens</i>Deconnecter</a> -->
            </li>
          </ul>
        </ul>
      </div>
    </div>
    <div v-if="type === 'search'" class="row" style="width:100%!important">
      <div class="col s12 push-m1 m10 l8 push-l1 offset-l1">
        <user-filter
        :custom-style="{width:'100%', height:'100%'}"
        :custom-style-card="{width:'100%', height:'100%'}"
        :set-style="{value:'mr-b-3 col card teal lighten-5 hoverable s12 m8 l3'}"
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
