<template>
  <div>
    <nav>
      <ul>
        <li><router-link to="/products" active-class="active">Products</router-link></li>
        <li><router-link to="/orders" active-class="active">Orders</router-link></li>
      </ul>
    </nav>

    <div class="container">
      <router-view></router-view>
    </div>
  </div>
</template>

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
  margin: 0;
  padding: 0;
}

nav {
  background-color: #f8f9fa;
  padding: 10px 20px;
  border-bottom: 1px solid #dee2e6;
}

nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 20px;
}

nav a {
  text-decoration: none;
  color: #343a40;
  font-weight: 500;
}

nav a.active {
  color: #28a745;
}

.container {
  max-width: 1200px;
  margin: 20px auto;
  padding: 20px;
  background-color: #fff;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
</style>
