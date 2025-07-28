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
        </tr>
      </thead>
      <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.product_name }}</td>
          <td>{{ product.product_description }}</td>
          <td>{{ product.price }}</td>
          <td>{{ product.status }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'ProductList',
  data() {
    return {
      products: [],
    };
  },
  mounted() {
    fetch('/api/products')
      .then(res => res.json())
      .then(data => {
        this.products = data;
      });
  },
};
</script>