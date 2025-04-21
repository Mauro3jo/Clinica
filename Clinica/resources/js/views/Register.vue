<template>
  <div class="auth-container">
    <h1>Registro de Usuario</h1>
    <form @submit.prevent="handleRegister">
      <input
        type="text"
        v-model="form.name"
        placeholder="Nombre completo"
        required
      />
      <input
        type="email"
        v-model="form.email"
        placeholder="Correo electrónico"
        required
      />
      <input
        type="text"
        v-model="form.username"
        placeholder="Nombre de usuario"
        required
      />
      <input
        type="text"
        v-model="form.dni"
        placeholder="DNI (8 dígitos)"
        required
        maxlength="8"
        pattern="[0-9]{8}"
        inputmode="numeric"
      />
      <input
        type="password"
        v-model="form.password"
        placeholder="Contraseña"
        required
      />

      <select v-model="form.role" required>
        <option value="">Seleccioná un rol</option>
        <option value="admin">Administrador</option>
        <option value="dentista">Dentista</option>
        <option value="clinico">Clínico</option>
      </select>

      <button type="submit">Registrarme</button>
      <p class="link" @click="goToLogin">¿Ya tenés cuenta? Iniciá sesión</p>
    </form>
    <p class="error" v-if="error">{{ error }}</p>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import api from '../axios'

const router = useRouter()
const form = reactive({
  name: '',
  email: '',
  username: '',
  dni: '',
  password: '',
  role: ''
})
const error = ref(null)

const handleRegister = async () => {
  // Validación manual de DNI (exactamente 8 números)
  if (!/^\d{8}$/.test(form.dni)) {
    error.value = 'El DNI debe contener exactamente 8 números.'
    return
  }

  try {
    await api.post('/register', form)
    router.push('/')
  } catch (err) {
    error.value = err.response?.data?.message || 'Error al registrarte'
  }
}

const goToLogin = () => {
  router.push('/')
}
</script>

<style scoped>
.auth-container {
  max-width: 400px;
  margin: 10vh auto;
  padding: 2rem;
  background: #ffffff;
  border-radius: 10px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
}
input, select {
  width: 100%;
  padding: 10px;
  margin-top: 1rem;
  border: 1px solid #ccc;
  border-radius: 5px;
}
button {
  margin-top: 1rem;
  width: 100%;
  padding: 10px;
  background-color: #28a745;
  color: white;
  border: none;
  border-radius: 5px;
  font-weight: bold;
}
.link {
  margin-top: 1rem;
  color: #007bff;
  cursor: pointer;
  text-decoration: underline;
}
.error {
  color: red;
  margin-top: 1rem;
}
</style>
