<template>
    <div class="container">
      <div class="header">
        <h1>Pacientes</h1>
        <button @click="goToCreate" class="add-btn">+ Agregar Paciente</button>
      </div>
  
      <!-- Buscador -->
      <div class="search-bar">
        <input v-model="search" placeholder="Buscar por DNI, Nombre o Apellido" />
      </div>
  
      <!-- Tabla de pacientes -->
      <table class="patient-table" v-if="filteredPatients.length">
        <thead>
          <tr>
            <th>DNI</th>
            <th>Apellido</th>
            <th>Nombre</th>
            <th>Obra Social</th>
            <th>Fecha Nac.</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="p in filteredPatients" :key="p.id">
            <td>{{ p.dni }}</td>
            <td>{{ p.apellido }}</td>
            <td>{{ p.nombre }}</td>
            <td>{{ p.obra_social }}</td>
            <td>{{ p.fecha_nacimiento }}</td>
            <td class="acciones">
              <router-link :to="`/paciente/${p.id}`">Ficha</router-link>
              <router-link :to="`/paciente/${p.id}/tratamientos`">Tratamientos</router-link>
              <router-link :to="`/paciente/${p.id}/historial`">Historial</router-link>
              <router-link :to="`/paciente/${p.id}/planes`">Planes</router-link>
            </td>
          </tr>
        </tbody>
      </table>
  
      <div v-else class="empty">
        <p>No hay pacientes o no coincide la búsqueda.</p>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, computed } from 'vue'
  import { useRouter } from 'vue-router'
  import axios from 'axios'
  
  const patients = ref([])
  const search = ref('')
  const router = useRouter()
  
  onMounted(async () => {
    try {
      const { data } = await axios.get('/patients') // si usás rutas en web.php
      patients.value = data
      console.log('Pacientes cargados:', data) // ✅ para debug
    } catch (err) {
      console.error('Error cargando pacientes:', err)
    }
  })
  
  const filteredPatients = computed(() => {
    const term = search.value.toLowerCase()
    return patients.value.filter(p =>
      p.dni.toString().includes(term) ||
      p.nombre.toLowerCase().includes(term) ||
      p.apellido.toLowerCase().includes(term)
    )
  })
  
  const goToCreate = () => {
    router.push('/paciente/crear')
  }
  </script>
  
  <style scoped>
  .container {
    max-width: 1000px;
    margin: 4rem auto;
    padding: 2rem;
    background: #fdfdfd;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
  }
  
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  h1 {
    margin: 0;
  }
  
  .add-btn {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-weight: bold;
  }
  
  .add-btn:hover {
    background-color: #218838;
  }
  
  .search-bar {
    margin: 1.5rem 0;
    text-align: center;
  }
  
  .search-bar input {
    width: 60%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .patient-table {
    width: 100%;
    border-collapse: collapse;
  }
  
  .patient-table th,
  .patient-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
  }
  
  .patient-table th {
    background-color: #f1f1f1;
  }
  
  .acciones {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }
  
  .acciones a {
    color: #007bff;
    text-decoration: none;
  }
  
  .acciones a:hover {
    text-decoration: underline;
  }
  
  .empty {
    text-align: center;
    margin-top: 2rem;
    font-style: italic;
  }
  </style>
  