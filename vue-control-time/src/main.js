import '@fortawesome/fontawesome-free/css/all.min.css'
import 'bootstrap-css-only/css/bootstrap.min.css'
import 'mdbvue/lib/mdbvue.css'
import Vue from 'vue'
import App from './App.vue'
import './registerServiceWorker'
import router from './router'
import 'bootstrap-css-only/css/bootstrap.min.css';

window.API_URL = 'http://localhost:8000/api';

const daysOfWeek = [
    'Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'
];

Vue.filter('cutText', function (text, symbolsCount) {
  return text.length > symbolsCount
      ? text.slice(0, symbolsCount - 3) + '...'
      : text;
});

Vue.filter('dateOnlyMd', function (originalDate) {
    let date = new Date(originalDate);

    return date.getDate() + '/' + (date.getMonth() + 1);
});

/**
 * Получить из строки даты только год/месяц/день
 */
Vue.filter('renderDate', function (string) {
    let date = new Date(string);

    return date.getFullYear() + '/' + date.getMonth() + '/' + date.getDate();
});

/**
 * Получить из строки даты только час/минуты
 */
Vue.filter('renderTime', function (string) {
    let date = new Date(string);

    return date.getHours() + ':' + date.getMinutes();
});

/**
 * Получить из строки даты день недели
 */
Vue.filter('dayOfWeek', function (string) {
    let date = new Date(string);

    return daysOfWeek[date.getDay()];
});

/**
 * Красивое отображение номера телефона)
 */
Vue.filter('renderPhone', function (phone) {
  phone = phone.toString();
  if (phone.length < 11) {
      return phone;
  }

  return phone[0] + ' (' + phone.slice(1, 4) + ') ' + phone.slice(4, 7) + '-' + phone.slice(7, 9) + '-' + phone.slice(9)
});

function declOfNum(number, titles)
{
    let cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

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

    return ((years > 0) ? years + ' ' + declOfNum(years, ['год', 'года', 'лет']) : '') + ' ' +
        ((months > 0) ? months + ' ' + declOfNum(months, ['месяц', 'месяца', 'месяцев']) : '') + ' ' +
        days + ' ' + declOfNum(days,['день', 'дня', 'дней']);
});

Vue.config.productionTip = false;

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')
