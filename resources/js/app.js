import './bootstrap';
import { createApp } from 'vue';
import '../css/app.css';


import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp({});
app.component('example-component', ExampleComponent);
app.mount('#app');
