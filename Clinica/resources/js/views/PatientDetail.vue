<template>
    <div class="container" v-if="patient">
      <h2>Ficha de: {{ patient.apellido }}, {{ patient.nombre }}</h2>
      <p><strong>DNI:</strong> {{ patient.dni }}</p>
      <p><strong>Sexo:</strong> {{ patient.sexo }}</p>
      <p><strong>Obra Social:</strong> {{ patient.obra_social }}</p>
      <p><strong>Domicilio:</strong> {{ patient.domicilio }}</p>
      <p><strong>Teléfono:</strong> {{ patient.telefono }}</p>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import { useRoute } from 'vue-router'
  import api from '../axios'
  
  const route = useRoute()
  const patient = ref(null)
  
  onMounted(async () => {
    const { data } = await api.get(`/patients/${route.params.id}`)
    patient.value = data
  })
  </script>
  
  <style scoped>
  .container {
    max-width: 600px;
    margin: 3rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  }
  h2 {
    margin-bottom: 1rem;
  }
  p {
    margin: 0.5rem 0;
  }
  </style>
  