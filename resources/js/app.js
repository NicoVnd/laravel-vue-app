import './bootstrap'
import { createApp } from 'vue'
import '../css/app.css'

// Import des composants
import ExampleComponent from './components/ExampleComponent.vue'
import Navbar from './components/Navbar.vue'
import LoginForm from './components/LoginForm.vue'
import RegisterForm from './components/RegisterForm.vue'
import ArticleList from './components/ArticleList.vue'
import ArticleForm from './components/Articleform.vue'
import ArticleView from './components/ArticleView.vue'
import WysiwygEditor from './components/WysiwygEditor.vue'

// Création de l'application Vue
const app = createApp({})

// Enregistrement des composants
app.component('example-component', ExampleComponent)
app.component('navbar', Navbar)
app.component('login-form', LoginForm)
app.component('register-form', RegisterForm)
app.component('article-list', ArticleList)
app.component('article-form', ArticleForm)
app.component('article-view', ArticleView)
app.component('wysiwyg-editor', WysiwygEditor)

// Montage de l'application
app.mount('#app')
