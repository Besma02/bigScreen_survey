import { createRouter, createWebHistory } from 'vue-router';
import PublicSurvey from '../views/PublicSurvey.vue';
import SurveyResult from '../views/SurveyResult.vue';
import NotFound from '../views/NotFound.vue';



const routes = [
  { path: '/', name: 'PublicSurvey', component: PublicSurvey },
  {
    path: '/survey/result/:token',
    name: 'SurveyResult',
    component:SurveyResult ,
      },
  {
    path: '/:pathMatch(.*)*', // Capture all unmatched routes
    name: 'NotFound',
    component: NotFound
  }


];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router;
