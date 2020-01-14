import '@fortawesome/fontawesome-free/css/all.min.css'
import 'bootstrap-css-only/css/bootstrap.min.css'
import 'mdbvue/lib/mdbvue.css'
import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import store from './store'
import 'bootstrap-css-only/css/bootstrap.min.css';

window.API_URL = 'http://localhost:8000';

Vue.filter('cutText', function (text, symbolsCount) {
  return text.length > symbolsCount
      ? text.slice(0, symbolsCount - 3) + '...'
      : text;
});

/**
 * Красивое отображение номера телефона)
 */
Vue.filter('renderPhone', function (phone) {
  phone = phone.toString();
  if (phone.length < 11) {
      return phone;
  }

  return phone[0] + ' (' + phone[1] + phone[2] + phone[3] + ') ' +
      phone[4] + phone[5] + phone[6] + '-' + phone[7] + phone[8] + '-' + phone[9] + phone[10];
});

/**
 * todo не уверен, что всегда правильно посчитает
 */
Vue.filter('renderExperience', function (string) {
    let hired = new Date(string);
    let current = new Date();
    let diff = new Date(current - hired);

    let years = diff.getFullYear() - 1970;
    let months = diff.getMonth();
    let days = diff.getDate();

    if (years === 0 && months === 0 && days === 0) {
        return 'только устроен';
    }

    return ((years > 0) ? years + ' лет ' : '') +
        ((months > 0) ? months + ' месяцев ' : '') + days + ' дней';
});

Vue.config.productionTip = false;

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
