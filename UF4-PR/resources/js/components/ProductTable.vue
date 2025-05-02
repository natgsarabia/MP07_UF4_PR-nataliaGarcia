<template>
  <div class="products-wrapper">
    <!-- Columna izquierda: tabla -->
    <div class="product-table">
      <input v-if="isAdmin" class="idSearch" v-model="searchId" placeholder="Buscar por ID" @input="filterById" />

      <table>
        <thead>
          <tr>
            <th @click="sortBy('id')">Id</th>
            <th @click="sortBy('name')">Nom</th>
            <th @click="sortBy('price')">Preu</th>
            <th>Categoria</th>
            <th v-if="isAdmin">Accions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="product in filteredProducts" :key="product.id">
            <td>{{ product.id }}</td>
            <td>{{ product.name }}</td>
            <td>{{ product.price }}</td>
            <td>{{ product.category }}</td>
            <td class="adminButtons" v-if="isAdmin">
              <button @click="editProduct(product)">Editar</button>
              <button @click="deleteProduct(product.id)">Eliminar</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Columna derecha: formulario -->
    <div class="addItem" v-if="isAdmin">
      <h3>Afegir nou producte</h3>
      <form class="formAdd" @submit.prevent="addProduct">
        <input v-model="newProduct.name" placeholder="Nom" required />
        <input v-model="newProduct.price" placeholder="Preu" required type="number" />
        <input v-model="newProduct.category" placeholder="Categoria" required />
        <button type="submit">Afegir</button>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      products: [],
      filteredProducts: [],
      sortKey: 'name',
      sortAsc: true,
      isAdmin: false,
      searchId: '',
      newProduct: {
        name: '',
        price: '',
        category: ''
      }
    };
  },
  methods: {
    async fetchProducts() {
      console.log('[fetchProducts] inicio...');
      try {
        const res = await axios.get('/products');
        console.log('[fetchProducts] éxito:', res.data);
        this.products = res.data;
        this.filteredProducts = res.data;
      } catch (error) {
        console.error('[fetchProducts] error:', error);
      }
    },
    filterById() {
      if (this.searchId) {
        axios.get(`/products/${this.searchId}`)
          .then(res => {
            this.filteredProducts = [res.data];
          })
          .catch(err => {
            console.error('No trobat', err);
            this.filteredProducts = [];
          });
      } else {
        this.filteredProducts = [...this.products];
      }
    },
    async deleteProduct(id) {
      await axios.delete(`/products/${id}`);
      this.fetchProducts();
    },
    async addProduct() {
      console.log('Enviando producto:', this.newProduct);
      await axios.post('/products', {
          name: this.newProduct.name,
          category: this.newProduct.category,
          price: parseFloat(this.newProduct.price)
      });
      this.newProduct = { name: '', price: '', category: '' };
      this.fetchProducts();
    },
    async editProduct(product) {
      const nouNom = prompt("Nou nom del producte:", product.name);
      const nouPreu = prompt("Nou preu:", product.price);
      const novaCategoria = prompt("Nova categoria:", product.category);

      if (nouNom || nouPreu || novaCategoria) {
        try {
          await axios.put(`/products/${product.id}`, {
            name: nouNom,
            price: parseFloat(nouPreu),
            category: novaCategoria
          });
          this.fetchProducts(); // recargar
        } catch (err) {
          console.error('Error editant', err);
          alert('No s\'ha pogut editar');
        }
      }
    }
  },
  mounted() {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');
    this.isAdmin = localStorage.getItem('role') === 'administrador';
    this.fetchProducts();
  }
};
</script>
