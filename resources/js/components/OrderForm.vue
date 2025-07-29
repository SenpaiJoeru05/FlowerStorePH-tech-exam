<template>
  <div class="form-container">
    <div class="form-card">
      <h3>Create Order</h3>
      <form @submit.prevent="submitForm">
        <label for="product">Product</label>
        <select v-model="order.product_id" required>
          <option v-for="product in products" :key="product.id" :value="product.id">
            {{ product.product_name }} - ₱{{ product.price }}
          </option>
        </select>

        <label for="user">User ID</label>
        <input type="number" v-model="order.user_id" required />

        <div class="form-actions">
          <button type="submit" class="btn-primary">Submit</button>
          <button type="button" class="btn-secondary" @click="$emit('close')">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from '../axios';

export default {
  name: 'OrderForm',
  data() {
    return {
      order: {
        product_id: null,
        user_id: null,
      },
      products: [],
    };
  },
  mounted() {
    this.fetchProducts();
  },
  methods: {
    fetchProducts() {
      axios.get('/products').then(res => {
        this.products = res.data.filter(p => p.status === 'enabled');
      });
    },
    submitForm() {
      axios.post('/orders', this.order)
        .then(() => {
          this.$emit('saved');
          this.$emit('close');
        })
        .catch(err => {
          console.error(err);
          alert('Error creating order.');
        });
    }
  }
};
</script>

<style scoped>
.form-container {
  background: white;
  padding: 20px;
  border-radius: 6px;
  width: 400px;
  box-shadow: 0 4px 10px rgba(0,0,0,0.1);
}
.form-card h3 {
  margin-bottom: 16px;
}
label {
  display: block;
  margin-top: 10px;
}
select, input {
  width: 100%;
  padding: 6px;
  margin-top: 4px;
}
.form-actions {
  display: flex;
  justify-content: space-between;
  margin-top: 16px;
}
.btn-primary {
  background-color: #007bff;
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
.btn-secondary {
  background-color: #6c757d;
  color: white;
  padding: 8px 14px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}
</style>
