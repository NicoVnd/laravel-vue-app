import './bootstrap';
import { createApp } from 'vue';
import '../css/app.css';

// Import des composants
import ExampleComponent from './components/ExampleComponent.vue';
import Navbar from './components/Navbar.vue';
import LoginForm from './components/LoginForm.vue';
import RegisterForm from './components/RegisterForm.vue';

const app = createApp({});

// Enregistrement des composants
app.component('example-component', ExampleComponent);
app.component('navbar', Navbar);
app.component('login-form', LoginForm);
app.component('register-form', RegisterForm);

app.mount('#app');
