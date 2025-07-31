<template>
  <div>

  
    <div class="title"><h1>Simple CRUD Application</h1></div>

    <div class="tabs-row">
      <button :class="{active: activeTab === 'products'}" @click="activeTab = 'products'">All Products</button>
      <button :class="{active: activeTab === 'orders'}" @click="activeTab = 'orders'">Orders</button>
      <div class="tab-underline" :style="{ left: activeTab === 'products' ? '0%' : '50%' }"></div>
    </div>

 
    <div v-if="activeTab === 'products'">
      <div class="products-header">
        <h3>All Products</h3>
        <button @click="showProductForm = true" class="btn-blue">Add New Product</button>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Product Name</th>
              <th>Description</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in products.filter(p => p.quantity > 0)" :key="product.id">
              <td>{{ product.product_name }}</td>
              <td>{{ product.product_description }}</td>
              <td>{{ product.quantity }}</td>
              <td>₱{{ Number(product.price).toFixed(2) }}</td>
              <td>{{ product.status === 'enabled' ? 'Active' : 'Inactive' }}</td>
              <td>
                <button @click="editProduct(product)" class="btn-red" style="margin-right:6px;">Edit</button>
                <button @click="deleteProduct(product.id)" class="btn-red">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Orders Tab -->
    <div v-else>
      <div class="orders-header">
        <h3>Orders</h3>
        <button @click="showOrderForm = true" class="btn-blue" style="margin-left:auto;">Create New Order</button>
      </div>
      <!-- Order Modal -->
      <div v-if="showOrderForm" class="modal-overlay">
        <div class="form-container">
          <h3>Create Order</h3>
          <form @submit.prevent="submitOrder">
            <label for="product">Product</label>
            <select v-model="orderForm.product_id" required>
              <option v-for="product in products.filter(p => p.status === 'enabled' && p.quantity > 0)" :key="product.id" :value="product.id">
                {{ product.product_name }} - ₱{{ Number(product.price).toFixed(2) }}
              </option>
            </select>
            <div v-if="orderForm.product_id !== null" style="margin: 8px 0; color: #4285f4; font-weight: 500;">
              Available Quantity: {{ selectedProductQuantity }}
            </div>
            <label for="user">User</label>
            <select v-model="orderForm.user_id" required>
              <option v-for="user in users" :key="user.id" :value="user.id">
                {{ user.first_name }} {{ user.last_name }}
              </option>
            </select>
            <div class="form-actions">
              <button type="submit" class="btn-blue">Submit</button>
              <button type="button" class="btn-secondary" @click="showOrderForm = false">Cancel</button>
            </div>
          </form>
        </div>
      </div>
      <div class="card">
        <table>
          <thead>
            <tr>
              <th>Order ID</th>
              <th>Product Name</th>
              <th>Price</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="order in expandedOrders" :key="order.order_id">
              <td>{{ order.order_id }}</td>
              <td>{{ order.product_name }}</td>
              <td>₱{{ order.pricePerItem.toFixed(2) }}</td>
              <td>
                <button @click="deleteOrder(order.order_id)" class="btn btn-danger">Remove</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="summary">
        <h3>Summary</h3>
        <p>Total Price: ₱{{ totalPrice.toFixed(2) }}</p>
      </div>
    </div>

    <!-- Add New Product Form -->
    <div v-if="showProductForm" class="modal-overlay">
      <div class="form-container">
        <h3>Add New Product</h3>
        <form @submit.prevent="submitProduct">
          <label>Product Name</label>
          <input v-model="form.product_name" placeholder="Product Name" required />
          <label>Description</label>
          <input v-model="form.product_description" placeholder="Description" required />
          <label>Price</label>
          <input v-model.number="form.price" type="number" placeholder="Price" required />
          <label>Quantity</label>
          <input v-model.number="form.quantity" type="number" min="0" placeholder="Quantity" required />
          <label>Status</label>
          <select v-model="form.status">
            <option value="enabled">Active</option>
            <option value="disabled">Inactive</option>
          </select>
          <div class="form-actions">
            <button type="submit" class="btn-blue">Add Product</button>
            <button type="button" class="btn-secondary" @click="showProductForm = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Edit Product Form -->
    <div v-if="showEditProductForm" class="modal-overlay">
      <div class="form-container">
        <h3>Edit Product</h3>
        <form @submit.prevent="updateProduct">
          <input type="hidden" v-model="editProductForm.id" />
          <label>Product Name</label>
          <input v-model="editProductForm.product_name" placeholder="Product Name" required />
          <label>Description</label>
          <input v-model="editProductForm.product_description" placeholder="Description" required />
          <label>Price</label>
          <input v-model.number="editProductForm.price" type="number" placeholder="Price" required />
          <label>Quantity</label>
          <input v-model.number="editProductForm.quantity" type="number" min="0" placeholder="Quantity" required />
          <label>Status</label>
          <select v-model="editProductForm.status">
            <option value="enabled">Active</option>
            <option value="disabled">Inactive</option>
          </select>
          <div class="form-actions">
            <button type="submit" class="btn-blue">Update Product</button>
            <button type="button" class="btn-secondary" @click="showEditProductForm = false">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import '../../css/ProductDashboard.css';
import axios from '../axios';

export default {
  name: 'ProductDashboard',
  data() {
    return {
      users: [],
      selectedUserId: null,
      activeTab: 'products',
      products: [],
      form: {
        product_name: '',
        product_description: '',
        quantity: 0,
        price: 0,
        status: 'enabled',
      },
      orders: [],
      showOrderForm: false,
      orderForm: {
        product_id: null,
        user_id: null
      },
      showProductForm: false,
      editProductForm: {
        id: null,
        product_name: '',
        product_description: '',
        quantity: 0,
        price: 0,
        status: 'enabled',
      },
      showEditProductForm: false,
    };
  },
  computed: {
    totalPrice() {
      return this.orders.reduce((sum, o) => sum + Number(o.price), 0);
    },
    expandedOrders() {
      const rows = [];
      this.orders.forEach(order => {
        const qty = Number(order.quantity) || 1;
        const product = this.products.find(p => p.id === order.product_id);
        const productName = product ? product.product_name : order.product_name || '';
        const pricePerItem = qty > 0 ? Number(order.price) / qty : 0;
        for (let i = 0; i < qty; i++) {
          rows.push({
            ...order,
            product_name: productName,
            pricePerItem,
            _rowIndex: i + 1
          });
        }
      });
      return rows;
    },
    selectedProductQuantity() {
      const product = this.products.find(p => p.id === this.orderForm.product_id);
      return product ? product.quantity : 1;
    },
  },
  mounted() {
    this.fetchUsers();
    this.fetchProducts();
    this.fetchOrders();
  },
  methods: {
    fetchUsers() {
      axios.get('/users').then(res => {
        this.users = res.data;
        if (this.users.length) {
          this.selectedUserId = this.users[0].id;
        }
      });
    },
    fetchProducts() {
      axios.get('/products').then(res => {
        this.products = res.data.reverse();
      });
    },
    submitProduct() {
      axios.post('/products', this.form)
        .then(() => {
          this.fetchProducts();
          this.form = {
            product_name: '',
            product_description: '',
            quantity: 0,
            price: 0,
            status: 'enabled',
          };
          this.showProductForm = false;
        })
        .catch(error => {
          alert('Failed to add product: ' + error.response?.data?.message || error.message);
          console.error(error);
        });
    },
    deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        axios.delete(`/products/${id}`).then(() => {
          this.fetchProducts();
        });
      }
    },
    fetchOrders() {
      axios.get('/orders').then(res => {
        this.orders = res.data.reverse();
      });
    },
    submitOrder() {
      const product = this.products.find(p => p.id === this.orderForm.product_id);
      if (!product || product.quantity < 1) {
        alert('Product is out of stock!');
        return;
      }
      const orderData = {
        product_id: this.orderForm.product_id,
        user_id: this.orderForm.user_id,
        price: product.price,
        quantity: 1
      };
      axios.post('/orders', orderData)
        .then(() => {
          product.quantity -= 1;
          axios.put(`/products/${product.id}`, { quantity: product.quantity });
          this.fetchOrders();
          this.fetchProducts();
          this.showOrderForm = false;
          this.orderForm = {
            product_id: null,
            user_id: null
          };
        })
        .catch(error => {
          alert('Failed to create order');
          console.error(error);
        });
    },
    deleteOrder(orderId) {
      const order = this.orders.find(o => o.order_id === orderId);
      if (order) {
        const product = this.products.find(p => p.id === order.product_id);
        if (product) {
          product.quantity += order.quantity;
          axios.put(`/products/${product.id}`, { quantity: product.quantity });
        }
      }
      axios.delete(`/orders/${orderId}`)
        .then(() => {
          this.fetchOrders();
          this.fetchProducts();
        })
        .catch(error => {
          alert('Failed to delete order: ' + error.response?.data?.message || error.message);
          console.error(error);
        });
    },
    editProduct(product) {
      this.editProductForm = { ...product };
      this.showEditProductForm = true;
    },
    updateProduct() {
      axios.put(`/products/${this.editProductForm.id}`, this.editProductForm)
        .then(() => {
          this.fetchProducts();
          this.showEditProductForm = false;
          this.editProductForm = {
            id: null,
            product_name: '',
            product_description: '',
            quantity: 0,
            price: 0,
            status: 'enabled',
          };
        })
        .catch(error => {
          alert('Failed to update product: ' + error.response?.data?.message || error.message);
          console.error(error);
        });
    },
  },
};
</script>
