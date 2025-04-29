import { createRouter, createWebHistory } from 'vue-router';
import PublicSurvey from '../views/PublicSurvey.vue';
import SurveyResult from '../views/SurveyResult.vue';
import NotFound from '../views/NotFound.vue';
import Register from '../components/Register.vue';
import Login from '../components/Login.vue';
import store from '../store'; // Assurez-vous d'importer votre store Vuex
import Dashboard from '../views/Dashboard.vue';
import Questions from '../views/Questions.vue';
import Responses from '../views/Responses.vue';
import Home from '../views/Home.vue';

const routes = [
  { path: '/', name: 'PublicSurvey', component: PublicSurvey, meta: { requiresAuth: true }},
  {
    path: '/survey/result/:token',
    name: 'SurveyResult',
    component: SurveyResult,
    meta: { requiresAuth: true }
  },
  { path: '/:pathMatch(.*)*', name: 'NotFound', component: NotFound },
  { path: '/login', name: 'Login', component: Login },
  { path: '/register', name: 'Register', component: Register },
  {
    path: "/dashboard",
    name: "dashboard",
    component: Dashboard,
    meta: { requiresAuth: true,adminOnly: true  }, // Route protégée
    children: [
      
      { path: '', name: 'Home', component: Home },
      { path: 'questions', name: 'Questions', component: Questions },
      { path: 'responses', name: 'Responses', component: Responses },      
   
    
    ],
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Garde de navigation pour vérifier si la route nécessite une authentification
router.beforeEach((to, from, next) => {
  // Si la route nécessite une authentification et l'utilisateur n'est pas authentifié
  if (to.meta.requiresAuth && !store.getters.isAuthenticated) {
    // Rediriger vers la page de connexion
    next({ name: 'Login' });
  } else {
    // Sinon, laisser la navigation se poursuivre
    next();
  }
});

export default router;
