import { createRouter, createWebHistory } from 'vue-router'
import ProductList from './components/ProductList.vue'
import OrderList from './components/OrderList.vue'

const routes = [
  { path: '/', redirect: '/products' },
  { path: '/products', component: ProductList },
  { path: '/orders', component: OrderList }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
