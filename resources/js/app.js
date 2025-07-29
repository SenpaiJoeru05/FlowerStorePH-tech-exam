import { createApp } from 'vue';
import axios from './axios';
import App from './App.vue';
import ProductList from './components/ProductList.vue';
import OrderList from './components/OrderList.vue';

import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  { path: '/products', component: ProductList },
  { path: '/orders', component: OrderList },
  { path: '/:pathMatch(.*)*', redirect: '/products' }, // fallback
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

const app = createApp(App); // ✅ mount App.vue not Tabs.vue
app.use(router);
app.mount('#app');
