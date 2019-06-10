<template>
  <div class="row valign-wrapper" style="width:100%;height:100%">
    <div class="col card teal lighten-5 hoverable s10 pull-s1 m7 pull-m2 l6 pull-l3">
      <div class="card-content" style="width:100%;height:100%">
        <span class="card-title">Genre</span>
        <p>
          <label class="mr-r-1">
            <input type="checkbox" :disabled="isGenreSelected === true && genreName != 'homme'" @click="handleBox" value="homme"/>
            <span>Homme</span>
          </label>
          <label class="mr-r-1">
            <input type="checkbox" :disabled="isGenreSelected === true && genreName != 'femme'" @click="handleBox" value="femme"/>
            <span>Femme</span>
          </label>
        </p>
        <span class="card-title mr-t-2">Orientation sexuelle</span>
        <p>
          <label class="mr-r-1">
            <input type="checkbox" :disabled="isOrientationSelected === true && orientationName != 'homo'" @click="handleBox" value="homo"/>
            <span>Homosexuel</span>
          </label>
          <label class="mr-r-1">
            <input type="checkbox" :disabled="isOrientationSelected === true && orientationName != 'hetero'" @click="handleBox" value="hetero"/>
            <span>Hétérosexuel</span>
          </label>
          <label class="mr-r-1">
            <input type="checkbox" :disabled="isOrientationSelected === true && orientationName != 'bi'" @click="handleBox" value="bi"/>
            <span>Bisexuel</span>
          </label>
        </p>
        <span class="card-title mr-t-2" style="margin-bottom:0!important">Biographie</span>
        <div class="row" style="margin-bottom:0!important">
          <div class="col s12 m12 l12" v-if="isModifBio">
            <textarea @change="resizeTextarea" class="cyan lighten-4 materialize-textarea" :style="{height:textAreaHeight, background:'white'}" v-model="bio"></textarea>
            <button type="submit" class="btn green waves-effect waves-light" @click="modifBio">Confirmer</button>
            <button type="submit" class="btn green waves-effect waves-light" @click="resetBio">Annuler</button>
          </div>
          <div class="input-field col s12" v-if="isModifBio === false">
            <p class="mr-b-2 p-wbreak black-text"> {{bio}} </p>
            <button type="submit" class="btn green waves-effect waves-light" @click="showModifBio">Modifier</button>
          </div>
        </div>
        <div class="chips chips-autocomplete mr-b-1" id="chips-filter" style="margin-top:0!important"></div>
        <div class="file-field input-field">
          <div class="btn">
            <span>Image</span>
            <input type="file" accept=".png, .jpg, .jpeg" />
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
        <div class="card-action right-align">
            <button type="submit" class="btn green waves-effect waves-light" @click="sendData">
              Confirmer</button>
        </div>
      </div>
    </div>
  </div>
</template>



<script>
  export default{

    created(){
      // ajouter la valeur du textarea + la taille yoooo.
      // initalise les bools des checkboxs + la valeur du paragraphe / textarea (+ sa size).
    },

    mounted(){
      this.initChips()
    },

    data(){
      return {
        tags:[],
        bio:'Ma bio de fou woooowwowoowowowowowoowowowowoow',
        tmpBio:'',
        textAreaHeight:'',
        isModifBio:false,
        genreName:'',
        orientationName:'',
        isGenreSelected:false,
        isOrientationSelected:false,
        haveBio:false
      }
    },

    methods:{
      initChips(){
        var elems = document.getElementById('chips-filter')
        // si on a des chips dans la db pour cette user => on charge les chips.
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
        // envoi la requete au serveur(ajoute un tags pour cette user).
      },

      chipDelete(e, data){
        const index = this.tags.indexOf(data.childNodes[0].textContent)
        if (index !== -1)
          this.tags.splice(index, 1);
        // envoi la requete au serveur(enleve un tags pour cette user).
      },

      sendData(){
        //console.log(this.bio)
        // si bio = afficher la bio + bouton modifier (=> textarea)
        // envoie des datas si elles ont changes... sinon ballek... => afficher confirmer si les datas on changees
        // tags + bio + checkbox + file...
        // image : afficher les images et le bouton supprimer l'image pour chaque image, si
        // moins de 5 images afficher le bouton ajouter une image.
      },

      handleBox(event){
        // charge les infos du serveur...si on a un genre + orientation => check les boxes et set les booleans appopriés(name + isSelected).
        if (event.target.checked === true){
          if (event.target.value == "homme" || event.target.value == "femme")
          {
            this.isGenreSelected = true;
            this.genreName = event.target.value;
          }
          if (event.target.value == "homo" || event.target.value == "bi" || event.target.value == "hetero")
          {
            this.isOrientationSelected = true;
            this.orientationName = event.target.value;
          }
        }
        if (event.target.checked === false){
          if (event.target.value == "homme" || event.target.value == "femme")
          this.isGenreSelected = false;
          if (event.target.value == "homo" || event.target.value == "bi" || event.target.value == "hetero")
          this.isOrientationSelected = false;
        }
        // envoi de la modife au serveur(valeur + type).
      },

      showModifBio(){
        this.isModifBio = true;
        this.tmpBio = this.bio;
      },

      resetBio(){
        this.isModifBio = false;
        this.bio = this.tmpBio;
      },

      modifBio(e){
        this.isModifBio = false;
      },

      resizeTextarea(e){
        this.textAreaHeight = e.target.style.height;
      }
    }
  }

</script>
