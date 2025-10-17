import LoginView from '@/views/Auth/LoginView.vue'
import InventoryView from '@/views/Inventory/InventoryView.vue'
import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  { path: '/', component: LoginView },
  { path: '/inventory', component: InventoryView },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (!token && to.path !== '/') {
    next('/')
  } else if (token && to.path === '/') {
    next('/inventory')
  } else {
    next()
  }
})

export default router
