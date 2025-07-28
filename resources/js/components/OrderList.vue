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
    <div>
      <strong>Total:</strong> {{ totalPrice }}
    </div>
  </div>
</template>

<script>
export default {
  name: 'OrderList',
  data() {
    return {
      orders: [],
    };
  },
  computed: {
    totalPrice() {
      return this.orders.reduce((sum, order) => sum + Number(order.price), 0);
    },
  },
  mounted() {
    fetch('/api/orders')
      .then(res => res.json())
      .then(data => {
        this.orders = data;
      });
  },
};
</script>