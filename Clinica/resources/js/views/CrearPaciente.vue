<template>
    <div class="form-container">
      <h2>Registrar Paciente</h2>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label>DNI</label>
          <input v-model="form.dni" type="text" maxlength="8" required />
        </div>
        <div class="form-group">
          <label>Apellido</label>
          <input v-model="form.apellido" type="text" required />
        </div>
        <div class="form-group">
          <label>Nombre</label>
          <input v-model="form.nombre" type="text" required />
        </div>
        <div class="form-group">
          <label>Sexo</label>
          <select v-model="form.sexo" required>
            <option value="">Seleccionar</option>
            <option value="masculino">Masculino</option>
            <option value="femenino">Femenino</option>
            <option value="otro">Otro</option>
          </select>
        </div>
        <div class="form-group">
          <label>Fecha de Nacimiento</label>
          <input v-model="form.fecha_nacimiento" type="date" />
        </div>
        <div class="form-group">
          <label>Obra Social</label>
          <input v-model="form.obra_social" type="text" />
        </div>
        <div class="form-group">
          <label>Domicilio</label>
          <input v-model="form.domicilio" type="text" />
        </div>
        <div class="form-group">
          <label>Teléfono</label>
          <input v-model="form.telefono" type="text" />
        </div>
        <div class="buttons">
          <button type="submit">Guardar</button>
          <button type="button" class="cancel" @click="cancelar">Cancelar</button>
        </div>
        <p class="error" v-if="error">{{ error }}</p>
      </form>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref } from 'vue'
  import { useRouter } from 'vue-router'
  import api from '../axios'
  
  const router = useRouter()
  const form = reactive({
    dni: '',
    apellido: '',
    nombre: '',
    sexo: '',
    fecha_nacimiento: '',
    obra_social: '',
    domicilio: '',
    telefono: ''
  })
  
  const error = ref(null)
  
  const submitForm = async () => {
    try {
      await api.post('/patients', form)
      router.push('/home')
    } catch (err) {
      error.value = err.response?.data?.message || 'Error al guardar'
    }
  }
  
  const cancelar = () => {
    router.push('/home')
  }
  </script>
  
  <style scoped>
  .form-container {
    max-width: 600px;
    margin: 3rem auto;
    background: #ffffff;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 0 12px rgba(0,0,0,0.08);
  }
  
  h2 {
    text-align: center;
    margin-bottom: 1.5rem;
  }
  
  .form-group {
    margin-bottom: 1rem;
    display: flex;
    flex-direction: column;
  }
  
  label {
    font-weight: bold;
    margin-bottom: 5px;
  }
  
  input, select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
  }
  
  .buttons {
    display: flex;
    justify-content: space-between;
    margin-top: 2rem;
  }
  
  button {
    padding: 10px 20px;
    border: none;
    font-weight: bold;
    border-radius: 6px;
    cursor: pointer;
  }
  
  button[type="submit"] {
    background-color: #28a745;
    color: white;
  }
  
  .cancel {
    background-color: #ccc;
  }
  
  .error {
    color: red;
    margin-top: 1rem;
    text-align: center;
  }
  </style>
  