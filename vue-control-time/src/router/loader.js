import Vue from 'vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';

Vue.use(Loading);

let loader = Vue.$loading.show({
    loader: 'dots',
    color: '#5D00FF',
    zIndex: 999
});

function loaderStart() {
    loader.isActive = true;
}

function loaderEnd() {
    loader.isActive = false;
}

function loaderByPagination() {
    loaderStart();
    setTimeout(function() {
        loaderEnd();
    }, 555);
}

export default {loaderStart, loaderEnd, loaderByPagination}