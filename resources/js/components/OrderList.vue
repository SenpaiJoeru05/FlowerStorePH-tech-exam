<template>
  <div>
    <div class="header">
      <h2>Orders</h2>
      <button class="btn btn-primary" @click="showOrderForm = true">Create New Order</button>
    </div>

    <div v-if="showOrderForm" class="modal-overlay">
      <OrderForm 
        @saved="onOrderSaved"
        @close="closeOrderForm"
      />
    </div>

    <table>
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Product Name</th>
          <th>Price</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
       <tr v-for="order in orders" :key="order.order_id">
        <td>{{ order.order_id }}</td>
        <td>{{ order.product_name }}</td>
        <td>{{ order.price }}</td>
        <td>
          <button @click="deleteOrder(order.order_id)" class="btn btn-danger">Remove</button>
        </td>
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
import OrderForm from './OrderForm.vue';

export default {
  name: 'OrderList',
  components: {
    OrderForm
  },
  data() {
    return {
      orders: [],
      showOrderForm: false,
    };
  },
  computed: {
    totalPrice() {
      return this.orders.reduce((sum, o) => sum + Number(o.price), 0);
    },
  },
  mounted() {
    this.fetchOrders();
    this.$root.$on('order-added', this.fetchOrders); // Listen for new orders
  },
  beforeDestroy() {
    this.$root.$off('order-added', this.fetchOrders);
  },
  methods: {
    fetchOrders() {
      axios.get('/orders').then(res => {
        this.orders = res.data;
      }).catch(error => console.error(error));
    },
    deleteOrder(id) {
      if (confirm('Are you sure you want to delete this order?')) {
        axios.delete(`/orders/${id}`)
          .then(() => this.fetchOrders())
          .catch(error => console.error(error));
      }
    },
    closeOrderForm() {
      this.showOrderForm = false;
    },
    onOrderSaved() {
      this.fetchOrders();
      this.$root.$emit('order-added');
    },
  },
};
</script>

<style scoped>
/* Existing styles */
.btn-danger {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-danger:hover {
  background-color: #c82333;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-primary:hover {
  background-color: #0056b3;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}
</style>