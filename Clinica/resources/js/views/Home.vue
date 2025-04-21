<template>
    <div class="home">
      <h1>Bienvenido a la Clínica 👨‍⚕️</h1>
      <button @click="logout">Cerrar sesión</button>
    </div>
  </template>
  
  <script setup>
  import { useRouter } from 'vue-router'
  import api from '../axios'
  
  const router = useRouter()
  
  const logout = async () => {
    try {
      await api.post('/logout')
    } catch (err) {
      // ignoramos si ya está inválido
    } finally {
      localStorage.removeItem('token')
      router.push('/login')
    }
  }
  </script>
  