<template>
    <div class="container" v-if="historial">
      <h2>Historial Clínico</h2>
      <p><strong>Primera consulta:</strong> {{ historial.primera_consulta }}</p>
      <p><strong>Enfermedades:</strong> {{ historial.enfermedades?.join(', ') || 'Ninguna' }}</p>
      <p><strong>Observaciones:</strong> {{ historial.observaciones || 'Ninguna' }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import api from '../axios'
  
  const route = useRoute()
  const historial = ref(null)
  
  onMounted(async () => {
    const { data } = await api.get(`/patients/${route.params.id}/historial`)
    historial.value = data
  })
  </script>
  
  <style scoped>
  .container {
    max-width: 700px;
    margin: 3rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  }
  h2 {
    margin-bottom: 1rem;
  }
  </style>
  