<template>
  <div>
    <h2>Orders</h2>
    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Product Name</th>
          <th>Price</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id">
          <td>{{ order.id }}</td>
          <td>{{ order.product.product_name }}</td>
          <td>{{ order.price }}</td>
        </tr>
      </tbody>
    </table>

    <div class="summary">
      <h3>Summary</h3>
      <p>Total Price: {{ totalPrice.toFixed(2) }}</p>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  name: 'OrderList',
  data() {
    return {
      orders: [],
    };
  },
  computed: {
    totalPrice() {
      return this.orders.reduce((sum, o) => sum + Number(o.price), 0);
    },
  },
  mounted() {
    axios.get('/orders').then(res => {
      this.orders = res.data;
    });
  },
};
</script>

<style scoped>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  padding: 10px;
  text-align: left;
  border: 1px solid #dee2e6;
}
th {
  background-color: #f8f9fa;
}
.summary {
  margin-top: 20px;
  padding: 10px;
  background-color: #e9ecef;
  border-radius: 4px;
  text-align: center;
}
</style>
