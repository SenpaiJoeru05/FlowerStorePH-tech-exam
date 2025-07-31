<template>
    <div class="header-bar">
      <h1>FLOWERSTORE.PH-TECHNICAL EXAM</h1>
      <p>by JOEL RAYTON</p>
    </div>
  <div class="app-container">
    <ProductDashboard />
  </div>
</template>

<script>
import ProductDashboard from './components/ProductDashboard.vue';

export default {
  name: 'App',
  components: {
    ProductDashboard
  }
};
</script>

<style>
body {
  font-family: Arial, sans-serif;
  background-color: #f8f9fa;
  margin: 0;
  padding: 0;
}

.app-container {
  max-width: 1200px;
  margin: 40px auto;
  padding: 20px;
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
}

.header-bar {
  /* background: #0e3c85; */
  color: rgb(0, 0, 0);
  padding: 18px 0 10px 0;
  text-align: center;
  font-size: 1rem;
  font-weight: bold;
  border-radius: 8px 8px 0 0;
  margin-bottom: 10px;
}
</style>
