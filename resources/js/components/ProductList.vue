<template>
  <div>
    <h2>Products</h2>
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id" :class="{ disabled: product.status === 'disabled' }">
          <td>{{ product.product_name }}</td>
          <td>{{ product.product_description }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.status }}</td>
          <td class="action-buttons">
            <button class="btn btn-warning" @click="editProduct(product)">Edit</button>
            <button class="btn btn-danger" @click="toggleStatus(product)">Toggle</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  name: 'ProductList',
  data() {
    return {
      products: [],
    };
  },
  methods: {
    fetchProducts() {
      axios.get('/products').then(res => {
        this.products = res.data;
      });
    },
    toggleStatus(product) {
      axios.patch(`/products/${product.id}/status`).then(() => {
        this.fetchProducts(); // Refresh after toggle
      });
    },
    editProduct(product) {
      alert(`Edit: ${product.product_name}`); // Placeholder for future modal form
    },
  },
  mounted() {
    this.fetchProducts();
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
.disabled {
  background-color: #f8d7da;
  color: #721c24;
}
.action-buttons {
  display: flex;
  gap: 8px;
}
.btn {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-warning {
  background-color: #ffc107;
  color: white;
}
.btn-warning:hover {
  background-color: #e0a800;
}
.btn-danger {
  background-color: #dc3545;
  color: white;
}
.btn-danger:hover {
  background-color: #c82333;
}
</style>
