import Vue from 'vue'
import navBar from './navBar.vue'
import sayHi from './sayHi.vue'
import searchMatch from './searchMatch.vue'
import axios from 'axios'

Vue.prototype.$noUiSlider = noUiSlider;
Vue.component('nav-bar', navBar);
Vue.component('say-hi', sayHi);
Vue.component('search-match', searchMatch);

new Vue({
  el: '#app'
  //render: h => h(App)
})
