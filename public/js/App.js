import Vue from 'vue'
import navBar from './navBar.vue'
import sayHi from './sayHi.vue'
import searchMatch from './searchMatch.vue'
import userRegister from './userRegister.vue'
import userSettings from './userSettings.vue'
import userFilter from './userFilter.vue'
import axios from 'axios'

Vue.prototype.$noUiSlider = noUiSlider;
Vue.prototype.$WidthScren = function() {
  var w = window,
    d = document,
    e = d.documentElement,
    g = d.getElementsByTagName('body')[0],
    x = w.innerWidth || e.clientWidth || g.clientWidth
  return (x);
};
Vue.component('nav-bar', navBar);
Vue.component('say-hi', sayHi);
Vue.component('search-match', searchMatch);
Vue.component('user-register', userRegister);
Vue.component('user-settings', userSettings);
Vue.component('user-filter', userFilter);

new Vue({
  el: '#app'
  //render: h => h(App)
})