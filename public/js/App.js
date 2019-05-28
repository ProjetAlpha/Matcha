import Vue from 'vue'
import App from './App.vue'
import 'materialize-css'

Vue.component('say-hi', App);


new Vue({
  el: '#app',
  render: h => h(App)
})
