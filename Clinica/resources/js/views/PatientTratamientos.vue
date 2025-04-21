<template>
    <div class="container">
      <h2>Tratamientos</h2>
      <div v-if="tratamientos.length === 0">Este paciente no tiene tratamientos aún.</div>
      <ul>
        <li v-for="t in tratamientos" :key="t.id">
          {{ t.fecha }} - {{ t.trabajo_realizado }} ({{ t.pieza_dental }}) - ${{ t.arancel }}
        </li>
      </ul>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import api from '../axios'
  
  const route = useRoute()
  const tratamientos = ref([])
  
  onMounted(async () => {
    const { data } = await api.get(`/patients/${route.params.id}/tratamientos`)
    tratamientos.value = data
  })
  </script>
  
  <style scoped>
  .container {
    max-width: 700px;
    margin: 3rem auto;
    padding: 2rem;
    background: #f1f1f1;
    border-radius: 10px;
  }
  h2 {
    margin-bottom: 1rem;
  }
  li {
    margin-bottom: 0.8rem;
  }
  </style>
  