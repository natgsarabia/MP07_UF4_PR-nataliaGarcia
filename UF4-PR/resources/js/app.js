
import axios from 'axios';

axios.defaults.baseURL = '/api';
axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('token');

import { createApp } from 'vue';
import ProductTable from './components/ProductTable.vue';

//importamos los estilos
import '../css/style.css';


const app = createApp({});
app.component('product-table', ProductTable);
app.mount('#app');