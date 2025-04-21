<template>
    <div class="container">
      <h2>Planes de Tratamiento</h2>
      <div v-if="planes.length === 0">No hay planes cargados.</div>
      <ul>
        <li v-for="plan in planes" :key="plan.id">
          {{ plan.fecha }} - Dientes: {{ plan.dientes_afectados?.join(', ') || 'Ninguno' }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import api from '../axios'
  
  const route = useRoute()
  const planes = ref([])
  
  onMounted(async () => {
    const { data } = await api.get(`/patients/${route.params.id}/planes`)
    planes.value = data
  })
  </script>
  
  <style scoped>
  .container {
    max-width: 700px;
    margin: 3rem auto;
    padding: 2rem;
    background: #eef8ff;
    border-radius: 10px;
  }
  h2 {
    margin-bottom: 1rem;
  }
  </style>
  