<template>


  <div class="container" style="width:100%!important;height:100%!important;max-width:100%!important">
    <div v-if="type === 'result'" class="row" style="width:100%!important">
        <!-- <ul class="col push-l2 l7 m12 s12 collapsible expandable" style="padding:0!important;margin-right:0!important">
          <li style="row border:none!important padding:0!important;margin:0!important">
            <div class="collapsible-header"><i class="material-icons">sort</i>Filtrer</div>
            <div class="collapsibl e-body" style="padding:0!important;margin:0!important"> -->
            <div class="col push-s1 s10 m4 l3">
              <user-filter
              :custom-style="{margin:0,padding:0}"
              :custom-style-card="{margin:'0!important',width:'100%!important'}"
              :set-style="{value:'col card teal lighten-5 hoverable s12 m8 l6 s-responsive-row'}"
              :title="{name:'Filtrer'}"
              :range-filter="{age:'Age', popularite:'Popularite'}"
              :sort-filter="{name:'Age', localisatio:'Localisation', popularite:'Popularite', tags:'Tags'}"
              :sort-filter-name="{name:'Trier les résultats'}"
              :action-btn="{name:'Confirmer'}"
              :filter-id="{id:'1'}"
              v-on:sendFilterData="handleData($event)"></user-filter>
              <user-sort-result v-on:sendSortData="handleSortData($event)"></user-sort-result>
          </div>
          <!--  </div> -->
          <!--</li> -->
          <!--<li style="row border:none!important padding:0!important;margin:0!important">
            <div class="collapsible-header"><i class="material-icons">sort</i>Trier</div>
            <div class="collapsible-body" style="padding:0!important;margin:0!important"><user-sort-result v-on:sendSortData="handleSortData($event)"></user-sort-result></div>
          </li>
        </ul>-->
      <!-- Ici le sort des resultats... OMG -->
        <div class="col s12 m8 l8">
          <ul class="collection">
            <li class="row ml-v-align collection-item avatar" v-for="(value, name, index) in matchedResult">
                <div class="col s6 m6 l6" style="text-align:center">
                  <load-async-image :user-id="value.id"
                  :profil-id="value.id" img-style="center-img responsive-img rounded-img"
                  :need-watch="false" @imageLoaded="countLoadedImg"></load-async-image>
                </div>
                <div class="col s6 m6 l4">
                  <div class="row black-text">
                    {{value.firstname}}
                    <span class="black-text">
                      {{value.lastname}}
                    </span>
                    <span class="black-text">, {{value.age}} ans
                    </span> <br> <br>
                    <span class="black-text">
                      <strong>Distance :</strong> {{value.km}}.{{value.meters}} km
                    </span> <br>
                    <span class="black-text">
                      <strong>Score :</strong> {{value.score}}
                    </span>
                  </div>
                  <online-user-info :user-id="value.id"></online-user-info>
                </div>
                <div class="col s12 m7 l7">
                  <div class="chip blue white-text center-align" v-for="(value, name, index) in value.commonTags">
                    #{{value}}
                  </div>
              </div>
            </li>
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

  mounted(){
    window.addEventListener("scroll", this.onScroll)
  },

  beforeDestroy() {
    window.removeEventListener("scroll", this.onScroll)
  },

  created(){

    //window.addEventListener("scroll", this.onScroll)
    // si type == searchMatchUser, sinon basic search.
    this.fetchSugestions();
  },

  data() {
    return {
      selectedSortVal:[],
      selectedSortType:'',
      isSearch:'',
      isFilter:'',
      imageLoaded:0,
      pageCounter:1,
      activateTag:false,
      filterLocalisation:'',
      sliderData:[],
      filterTags:[],
      sortTags:[],
      sortLocalisation:[],
      matchedResult:[]
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
    },

    fetchSugestions(){
      this.$http.get('/searchSugestions').then((response) => {
        console.log(response.data)
        if (response.data && Array.isArray(response.data.sugestions)){
          window.scrollTo(0,0)
          this.matchedResult = response.data.sugestions
        }
      });
    },

    onScroll(e){
      if (this.imageLoaded !== this.pageCounter * 10)
        return ;
      // image chargees asychrone..., attendre fin du chargement pour triger
      if ((window.innerHeight + window.pageYOffset) >= document.body.offsetHeight)
      {
        this.pageCounter++;
        //console.log(this.pageCounter)
        this.addResults();
      }
    },

    addResults(){
      this.$http.post('/getMoreSugestions', {pageNumber:this.pageCounter}).then((response) => {
        console.log(this.pageCounter, response.data.result);
        if (response.data && Array.isArray(response.data.result)){
          this.matchedResult.push(...response.data.result)
          console.log(this.matchedResult)
        }
      });
    },

    countLoadedImg(){
      this.imageLoaded++;
    }
    // scrolling infinit : qd scroll = bottom => push 10 de plus a matchedUser.
  }
}

</script>
