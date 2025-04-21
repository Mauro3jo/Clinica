import { createRouter, createWebHistory } from 'vue-router'

// Vistas de autenticación
import Login from './views/Login.vue'
import Register from './views/Register.vue'

// Vistas principales
import Home from './views/Home.vue'

// Vistas relacionadas con pacientes
import PatientDetail from './views/PatientDetail.vue'
import PatientTratamientos from './views/PatientTratamientos.vue'
import PatientHistorial from './views/PatientHistorial.vue'
import PatientPlanes from './views/PatientPlanes.vue'
import CrearPaciente from './views/CrearPaciente.vue'

const routes = [
  // Autenticación
  {
    path: '/',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  },

  // Home protegido
  {
    path: '/home',
    name: 'home',
    component: Home,
    meta: { requiresAuth: true }
  },

  {
    path: '/paciente/crear',
    name: 'crear-paciente',
    component: CrearPaciente,
    meta: { requiresAuth: true }
  },
  
  // Vistas del paciente (protegidas)
  {
    path: '/paciente/:id',
    name: 'paciente.detalle',
    component: PatientDetail,
    meta: { requiresAuth: true }
  },
  {
    path: '/paciente/:id/tratamientos',
    name: 'paciente.tratamientos',
    component: PatientTratamientos,
    meta: { requiresAuth: true }
  },
  {
    path: '/paciente/:id/historial',
    name: 'paciente.historial',
    component: PatientHistorial,
    meta: { requiresAuth: true }
  },
  {
    path: '/paciente/:id/planes',
    name: 'paciente.planes',
    component: PatientPlanes,
    meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

// Protección de rutas
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.requiresAuth && !token) {
    next('/') // redirigir al login si no hay token
  } else {
    next()
  }
})

export default router
