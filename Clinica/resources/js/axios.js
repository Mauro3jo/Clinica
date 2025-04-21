import axios from 'axios'

const api = axios.create({
  baseURL: '', // ¡vacío porque usás web.php!
  headers: {
    'Content-Type': 'application/json'
  }
})

export default api
