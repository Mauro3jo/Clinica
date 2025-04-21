<template>
  <div class="auth-container">
    <h1>Clínica Login</h1>
    <form @submit.prevent="handleLogin">
      <input
        type="text"
        v-model="form.login"
        placeholder="Correo o nombre de usuario"
        required
      />
      <input
        type="password"
        v-model="form.password"
        placeholder="Contraseña"
        required
      />
      <button type="submit">Ingresar</button>
      <p class="link" @click="goToRegister">¿No tenés cuenta? Registrate</p>
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
  login: '', // puede ser username o email
  password: ''
})
const error = ref(null)

const handleLogin = async () => {
  try {
    const { data } = await api.post('/login', form)
    localStorage.setItem('token', data.token)
    router.push('/home')
  } catch (err) {
    error.value = err.response?.data?.message || 'Credenciales incorrectas'
  }
}

const goToRegister = () => {
  router.push('/register')
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
input {
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
  background-color: #007bff;
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
