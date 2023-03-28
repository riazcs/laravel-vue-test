const routes = [
  {
    path: '',
    component: () => import('../Pages/Home.vue'),
    name: 'home'
  },
  {
    path: '/dashboard',
    component: () => import('../Pages/Dashboard.vue'),
    name: 'Dashboard'
  },
]

export default routes;
