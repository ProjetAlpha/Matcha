<template>
<div class="blue white-text">

Seeder activated

</div>

</template>


<script>
  // https://randomuser.me/api/?results=100&?gender=female&?gender=male?nat=fr
  // data.dob.age | data.gender | data.name.last | data.name.first | data.login.username | data.login.password
  // data.email | data.location.latitude | data.location.longitude | data.picture.large
  // generate city france = ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux']
  // bio = https://loripsum.net/api/1/short/plaintext
  // score de popularite = Math.floor(Math.random()*(100-0+1)+0);
  // tags = Math.random().toString(36).substring(7);
  // http://extreme-ip-lookup.com/json/?callback=getIP => city + lat + long.
  /*
   ----- Distance a vole d'oiseau entre 2 points.

  function getDistanceFromLatLonInKm(lat1,lon1,lat2,lon2) {
  var R = 6371; // Radius of the earth in km
  var dLat = deg2rad(lat2-lat1);  // deg2rad below
  var dLon = deg2rad(lon2-lon1);
  var a =
  Math.sin(dLat/2) * Math.sin(dLat/2) +
  Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
  Math.sin(dLon/2) * Math.sin(dLon/2)
  ;
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c; // Distance in km
  return d;
}

function deg2rad(deg) {
return deg * (Math.PI/180)
}

var lat1 = 45.747761;
var long1 = 4.843295;

var lat2 = 45.753204;
var long2 = 4.912422;


console.log(getDistanceFromLatLonInKm(lat1, long1, lat2, long2));

  */
  import axios from 'axios'

  export default{
    props:['number', 'nationalite'],

    created(){
      var vm = this
      axios.get('https://randomuser.me/api/?results='+this.number+'&?gender=female&?gender=male?nat='+this.nationalite)
      .then(function(response){
        vm.userSettings = response.data.results
      });
    },

    data(){
      return {
        userSettings:'',
        lat:false,
        long:false,
        score:false,
        bio:'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Prioris generis est docilitas, memoria Atqui reperies, inquit, in hoc quidem pertinacem; Idem iste, inquam, de voluptate quid sentit? Si longus, levis.'
      }
    },

    methods:{
      randomCity(){
        const city = ['Paris', 'Lyon', 'Marseille', 'Toulouse', 'Nice', 'Nantes', 'Strasbourg', 'Montpellier', 'Bordeaux'];
        let coord = [];
        coord.push(Math.floor(Math.random()*(51-43+1)+43))
        coord.push(Math.floor(Math.random()*(3-1+1)+1))
        // --- distance = n km
        // random latitude longitude france
        //<?php /*Lat*/ echo rand(43, 51) ?>
        //<?php /*Long*/ echo rand(1, 3) ?>
      },

      randomTags(){
        // random tags / user.
        const tags = ['php', 'java', 'music', 'video', 'film', 'sport', 'cuisine', 'jeux-video', 'pc'];
        var item = tags[Math.floor(Math.random()*tags.length)];
      },

      randomScore(){
        // random score / user
        return (Math.floor(Math.random()*(100-0+1)+0));
      },

      randomAge(){
        return (Math.floor(Math.random()*(90-18+1)+18))
      }
    }
  }


</script>
