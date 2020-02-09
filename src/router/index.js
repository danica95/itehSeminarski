import Vue from 'vue'
import VueRouter from 'vue-router'
import Login from '../views/Login.vue'
import Home from '../views/Home.vue'
import Ticket from '../views/Ticket.vue'
import Add from '../views/Add.vue'
import Reservation from '../views/Reservation.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/home',
    name: 'home',
    component: Home
  },
  {
    path: '/ticket',
    name: 'ticket',
    component: Ticket
  },
  {
    path: '/add',
    name: 'add',
    component: Add
  },
  {
    path: '/reservation',
    name: 'reservation',
    component: Reservation
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

const openRoute = ['login']

router.beforeEach((to, from, next) => {
  if (openRoute.includes(to.name)) {
    next()
  } else if (window.user != null) {
    next()
  } else {
    next('/login')
  }
})

export default router
