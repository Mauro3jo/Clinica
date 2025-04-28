<template>
  <div class="container">
    <h2>Tratamientos</h2>

    <div v-if="tratamientos.length === 0">Este paciente no tiene tratamientos aún.</div>

    <ul>
      <li v-for="t in tratamientos" :key="t.id">
        {{ t.fecha }} - {{ t.trabajo_realizado }} ({{ t.pieza_dental }}) - ${{ t.arancel }}
      </li>
    </ul>

    <!-- Nuevo formulario de tratamiento -->
    <div class="new-treatment">
      <h3>Agregar Tratamiento</h3>
      <form @submit.prevent="agregarTratamiento">
        <div class="form-grid">
          <input v-model="form.fecha" type="date" required />
          <input v-model="form.codigo" type="text" placeholder="Código" />
          <input v-model="form.pieza_dental" type="text" placeholder="Pieza Dental" />
          <input v-model="form.ubicacion_lesion" type="text" placeholder="Ubicación Lesión" />
          <input v-model="form.arancel" type="number" placeholder="Arancel" />
          <input v-model="form.pago" type="number" placeholder="Pago" />
          <input v-model="form.debe" type="number" placeholder="Debe" />
          <input v-model="form.saldo" type="number" placeholder="Saldo" />
          <input v-model="form.conducta_rx" type="text" placeholder="Conducta Rx" />
          <input v-model="form.trabajo_realizado" type="text" placeholder="Trabajo Realizado" />
          <textarea v-model="form.observaciones" placeholder="Observaciones"></textarea>
        </div>
        <button type="submit" class="btn-save">Guardar Tratamiento</button>
      </form>
    </div>

  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../axios'

const route = useRoute()
const tratamientos = ref([])
const form = ref({
  patient_id: route.params.id,
  doctor_id: 1, // después lo podemos hacer dinámico tomando el doctor logueado
  fecha: '',
  codigo: '',
  pieza_dental: '',
  ubicacion_lesion: '',
  arancel: '',
  pago: '',
  debe: '',
  saldo: '',
  conducta_rx: '',
  trabajo_realizado: '',
  observaciones: ''
})

onMounted(async () => {
  const { data } = await api.get(`/patients/${route.params.id}/tratamientos`)
  tratamientos.value = data
})

const agregarTratamiento = async () => {
  try {
    await api.post('/tratamientos', form.value)
    // Actualizar lista
    const { data } = await api.get(`/patients/${route.params.id}/tratamientos`)
    tratamientos.value = data
    // Limpiar form
    form.value = {
      patient_id: route.params.id,
      doctor_id: 1,
      fecha: '',
      codigo: '',
      pieza_dental: '',
      ubicacion_lesion: '',
      arancel: '',
      pago: '',
      debe: '',
      saldo: '',
      conducta_rx: '',
      trabajo_realizado: '',
      observaciones: ''
    }
  } catch (err) {
    console.error('Error agregando tratamiento:', err)
  }
}
</script>

<style scoped>
.container {
  max-width: 900px;
  margin: 3rem auto;
  padding: 2rem;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.05);
}

ul {
  margin-bottom: 2rem;
}

.new-treatment {
  margin-top: 3rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
  gap: 1rem;
  margin-bottom: 1rem;
}

input, textarea {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

.btn-save {
  padding: 10px 20px;
  background-color: #28a745;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
</style>
