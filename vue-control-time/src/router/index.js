import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../components/Home'
import loader from './loader'
import WorkerList from "../components/Worker/WorkerList";
import WorkerEdit from "../components/Worker/WorkerEdit";
import TimeList from "../components/Time/TimeList";
import TimeCreate from "../components/Time/TimeCreate";
import WorkerVacationApplication from "../components/Worker/WorkerVacationApplication";

Vue.use(VueRouter);

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home
  },
  {
    path: '/workers/all',
    name: 'workerList',
    component: WorkerList
  },
  {
    path: '/worker/:id/edit',
    name: 'workerEdit',
    component: WorkerEdit,
  },
  {
    path: '/workers/create',
    name: 'workerCreate',
    component: WorkerEdit,
  },
  {
    path: '/workers/:workerId/vacation-application/create',
    name: 'workerVacationApplication',
    component: WorkerVacationApplication,
  },
  {
    path: '/times/all',
    name: 'timeList',
    component: TimeList
  },
  {
    path: '/times/worker-:workerId',
    name: 'timeListByWorker',
    component: TimeList
  },
  {
    path: '/times/create/worker/:workerId',
    name: 'timeCreate',
    component: TimeCreate
  },
];

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
});

router.beforeResolve((to, from, next) => {
  if(to.path) {
    loader.loaderStart()
  }
  next()
});

router.afterEach((to, from) => {
  setTimeout(function() {
    loader.loaderEnd();
  }, 555);
});

export default router
