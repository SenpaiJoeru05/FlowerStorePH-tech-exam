<template>
  <div class="product-form">
    <h3>{{ isEditing ? 'Edit Product' : 'Add New Product' }}</h3>
    <form @submit.prevent="submitProduct">
      <div class="form-group">
        <label for="product_name">Product Name:</label>
        <input 
          id="product_name"
          v-model="form.product_name"
          type="text"
          class="form-control"
          required
        >
      </div>

      <div class="form-group">
        <label for="product_description">Description:</label>
        <textarea
          id="product_description"
          v-model="form.product_description"
          class="form-control"
          required
        ></textarea>
      </div>

      <div class="form-group">
        <label for="quantity">Quantity:</label>
        <input
          id="quantity"
          v-model.number="form.quantity"
          type="number"
          class="form-control"
          min="0"
          required
        >
      </div>

      <div class="form-group">
        <label for="price">Price:</label>
        <input
          id="price"
          v-model.number="form.price"
          type="number"
          step="0.01"
          class="form-control"
          min="0"
          required
        >
      </div>

      <div class="form-group">
        <label for="status">Status:</label>
        <select 
          id="status"
          v-model="form.status"
          class="form-control"
          required
        >
          <option value="enabled">Enabled</option>
          <option value="disabled">Disabled</option>
        </select>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn btn-primary">
          {{ isEditing ? 'Update' : 'Create' }}
        </button>
        <button type="button" class="btn btn-secondary" @click="$emit('close')">
          Cancel
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from '../axios'

export default {
  name: 'ProductForm',
  props: {
    product: {
      type: Object,
      default: null
    }
  },
  data() {
    return {
      form: {
        product_name: '',
        product_description: '',
        quantity: 0,
        price: 0,
        status: 'enabled'
      }
    }
  },
  computed: {
    isEditing() {
      return !!this.product
    }
  },
  methods: {
    submitProduct() {
      const request = this.isEditing
        ? axios.put(`/products/${this.product.id}`, this.form)
        : axios.post('/products', this.form)

      request
        .then(() => {
          this.$emit('saved')
          this.$emit('close')
        })
        .catch(error => {
          console.error('Error saving product:', error)
          alert('Failed to save product')
        })
    }
  },
  created() {
    if (this.product) {
      this.form = { ...this.product }
    }
  }
}
</script>

<style scoped>
.product-form {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 100%;
  max-width: 500px;
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
}

.form-control {
  width: 100%;
  padding: 8px;
  border: 1px solid #ddd;
  border-radius: 4px;
}

textarea.form-control {
  min-height: 100px;
}

.form-actions {
  display: flex;
  gap: 10px;
  justify-content: flex-end;
  margin-top: 20px;
}

.btn {
  padding: 8px 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.btn-primary {
  background-color: #007bff;
  color: white;
}

.btn-secondary {
  background-color: #6c757d;
  color: white;
}
</style>
