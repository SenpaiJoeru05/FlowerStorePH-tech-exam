<template>
  <div>
    <div class="header">
      <h2>Products</h2>
      <button class="btn btn-primary" @click="showProductForm = true">Add New Product</button>
    </div>
    
    <div v-if="showProductForm" class="modal-overlay">
      <ProductForm 
        :product="selectedProduct"
        @saved="onProductSaved"
        @close="closeProductForm"
      />
    </div>

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
            <button class="btn btn-danger" @click="deleteProduct(product)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from '../axios';
import ProductForm from './ProductForm.vue';

export default {
  name: 'ProductList',
  components: {
    ProductForm
  },
  data() {
    return {
      products: [],
      showProductForm: false,
      selectedProduct: null,
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
      this.selectedProduct = product;
      this.showProductForm = true;
    },
    deleteProduct(product) {
      if (confirm(`Are you sure you want to delete ${product.product_name}?`)) {
        axios.delete(`/products/${product.id}`).then(() => {
          this.fetchProducts();
        }).catch(error => {
          console.error(error);
          alert('Error deleting product');
        });
      }
    },
    closeProductForm() {
      this.showProductForm = false;
      this.selectedProduct = null;
    },
    onProductSaved() {
      this.fetchProducts();
    }
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
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
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
