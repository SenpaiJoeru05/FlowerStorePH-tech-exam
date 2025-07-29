import { createApp } from 'vue';
import ProductList from './components/ProductList.vue';
import OrderList from './components/OrderList.vue';

const app = createApp({});

app.component('product-list', ProductList);
app.component('order-list', OrderList);

app.mount('#app');
