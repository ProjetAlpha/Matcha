import Vue from 'vue'
import navBar from './navBar.vue'
import searchMatch from './searchMatch.vue'
import userRegister from './userRegister.vue'
import userSettings from './userSettings.vue'
import userFilter from './userFilter.vue'
import userSortResult from './userSortResult.vue'
import userProfil from './userProfil.vue'
import userProfilInfo from './userProfilInfo.vue'
import userProfilEdit from './userProfilEdit.vue'
import notifications from './notifications.vue'
import loadAsyncImage from './loadAsyncImage.vue'
import onlineUserInfo from './onlineUserInfo.vue'
import seeder from './seeder.vue'
import axios from 'axios'

Vue.prototype.$noUiSlider = noUiSlider;
Vue.prototype.$http = axios;

Vue.prototype.$checkIfLogged = function() {
  var vm = this;
  return new Promise((resolve, reject) => {
    axios.get('/isAuth')
      .then(response => {
        resolve(response.data.user);
      })
      .catch(error => {
        reject(error.response.data);
      });
  })
};

Vue.prototype.$isAuth = function() {
  var vm = this
  this.$checkIfLogged().then(response => {
      vm.isAuth = response ? response : false;
    })
    .catch(error => console.log(error));
};

Vue.component('nav-bar', navBar);
Vue.component('search-match', searchMatch);
Vue.component('user-register', userRegister);
Vue.component('user-settings', userSettings);
Vue.component('user-filter', userFilter);
Vue.component('user-sort-result', userSortResult);
Vue.component('user-profil', userProfil);
Vue.component('user-profil-info', userProfilInfo);
Vue.component('user-profil-edit', userProfilEdit);
Vue.component('notifications', notifications);
Vue.component('seeder', seeder);
Vue.component('load-async-image', loadAsyncImage);
Vue.component('online-user-info', onlineUserInfo);

new Vue({
  el: '#app'
  //render: h => h(App)
})