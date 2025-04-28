<template>
  <div class="ficha-odontologica">
    <form @submit.prevent="submitForm">

      <!-- CABECERA -->
      <div class="header">
        <div class="apellido-container">
          <label>APELLIDO:</label>
          <input v-model="form.apellido" type="text" class="input-apellido" required />
        </div>
        <div class="titulo">FICHA ODONTOLÓGICA</div>
      </div>

      <div class="line">
        NOMBRE: <input v-model="form.nombre" type="text" class="input-linea" required />
      </div>

      <div class="line">
        OBRA SOCIAL: <input v-model="form.obra_social" type="text" class="input-linea" />
        Cod.: <input v-model="form.codigo_obra_social" type="text" class="input-mini" />
        Af. N°: <input v-model="form.afiliado_nro" @input="formatCuit" type="text" class="input-cuit" />
        DNI: <input v-model="form.dni" type="text" class="input-mini" maxlength="8" />
      </div>

      <div class="line">
        PARENTESCO: <input v-model="form.parentesco" type="text" class="input-linea" />
        SEXO:
        <select v-model="form.sexo" class="input-select">
          <option value="">Seleccionar</option>
          <option value="masculino">Masculino</option>
          <option value="femenino">Femenino</option>
          <option value="otro">Otro</option>
        </select>
        EDAD: <input v-model="form.edad" type="number" class="input-mini" readonly />
        F.N.: <input v-model="form.fecha_nacimiento" type="date" class="input-fecha" @input="calcularEdad" />
      </div>

      <!-- CUERPO CENTRAL -->
      <div class="parte-central">
        <!-- Columna Izquierda -->
        <div class="columna-izquierda">
          <div class="line">
            TITULAR: <input v-model="form.titular" type="text" class="input-linea" />
          </div>

          <div class="line">
            DOMICILIO: <input v-model="form.domicilio" type="text" class="input-linea" />
            LOC.: <input v-model="form.localidad" type="text" class="input-mini" />
          </div>

          <div class="line">
            TEL.: <input v-model="form.telefono" type="text" class="input-mini" />
            PRESTA SERVICIO EN: <input v-model="form.servicio" type="text" class="input-linea" />
          </div>

          <div class="line">
            FECHA 1° CONSULTA: <input v-model="form.fecha_primera_consulta" type="date" class="input-fecha" />
          </div>

          <!-- Gráfico Dental -->
          <div class="dientes">
            <div class="fila">
              <span v-for="d in [18,17,16,15,14,13,12,11]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
              <span class="espacio"></span>
              <span v-for="d in [21,22,23,24,25,26,27,28]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
            </div>
            <div class="fila">
              <span v-for="d in [48,47,46,45,44,43,42,41]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
              <span class="espacio"></span>
              <span v-for="d in [31,32,33,34,35,36,37,38]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
            </div>
            <div class="fila">
              <span v-for="d in [55,54,53,52,51]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
              <span class="espacio"></span>
              <span v-for="d in [61,62,63,64,65]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
            </div>
            <div class="fila">
              <span v-for="d in [85,84,83,82,81]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
              <span class="espacio"></span>
              <span v-for="d in [71,72,73,74,75]" :key="d" @click="toggleDiente(d)" :class="['diente', {activo: dientesSeleccionados.includes(d)}]">{{ d }}</span>
            </div>
          </div>

          <!-- Observaciones -->
          <div class="form-group-full">
            <label>Observaciones</label>
            <textarea v-model="form.observaciones"></textarea>
          </div>
        </div>

        <!-- Columna Derecha -->
        <div class="columna-derecha">
          <div class="historia-clinica">
            <h4>Historia Clínica</h4>

            <table class="tabla-historia">
              <tr>
                <td>1) ¿Se encuentra habitualmente bajo atención médica?</td>
                <td class="opciones">
                  <button type="button" @click="responder(0, true)">Sí</button>
                  <button type="button" @click="responder(0, false)">No</button>
                </td>
              </tr>

              <tr>
                <td>2) ¿Ha padecido enfermedad grave u operación?</td>
                <td class="opciones">
                  <button type="button" @click="responder(1, true)">Sí</button>
                  <button type="button" @click="responder(1, false)">No</button>
                </td>
              </tr>

              <!-- Afecciones -->
              <template v-for="(fila, index) in filasAfecciones" :key="index">
                <tr>
                  <td>
                    {{ fila[0].texto }}
                    <button type="button" @click="responder(fila[0].index, true)">Sí</button>
                    <button type="button" @click="responder(fila[0].index, false)">No</button>
                  </td>
                  <td v-if="fila[1]">
                    {{ fila[1].texto }}
                    <button type="button" @click="responder(fila[1].index, true)">Sí</button>
                    <button type="button" @click="responder(fila[1].index, false)">No</button>
                  </td>
                </tr>
              </template>

              <!-- Preguntas finales -->
              <tr>
                <td>4) ¿Está tomando medicamentos?</td>
                <td class="opciones">
                  <button type="button" @click="responder(22, true)">Sí</button>
                  <button type="button" @click="responder(22, false)">No</button>
                </td>
              </tr>
              <tr>
                <td>5) ¿Toma aspirinas frecuentemente?</td>
                <td class="opciones">
                  <button type="button" @click="responder(23, true)">Sí</button>
                  <button type="button" @click="responder(23, false)">No</button>
                </td>
              </tr>
              <tr>
                <td>6) ¿Está embarazada?</td>
                <td class="opciones">
                  <button type="button" @click="responder(24, true)">Sí</button>
                  <button type="button" @click="responder(24, false)">No</button>
                </td>
              </tr>
              <tr>
                <td>7) ¿Ha presentado problemas dentales previos?</td>
                <td class="opciones">
                  <button type="button" @click="responder(25, true)">Sí</button>
                  <button type="button" @click="responder(25, false)">No</button>
                </td>
              </tr>
              <tr>
                <td>8) ¿Fuma?</td>
                <td class="opciones">
                  <button type="button" @click="responder(26, true)">Sí</button>
                  <button type="button" @click="responder(26, false)">No</button>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <!-- Firma abajo de todo -->
      <div class="firma-section">
        Firma: ______________________________________  
        Aclaración: ______________________ DNI: ________________
      </div>

      <!-- BOTONES -->
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
  apellido: '', nombre: '', dni: '', sexo: '', edad: '', fecha_nacimiento: '',
  obra_social: '', codigo_obra_social: '', afiliado_nro: '', parentesco: '', titular: '',
  domicilio: '', localidad: '', telefono: '', servicio: '', fecha_primera_consulta: '',
  observaciones: ''
})


const error = ref(null)
const dientesSeleccionados = ref([])

const preguntas = [
  { texto: "¿Se encuentra habitualmente bajo atención médica?", respuesta: null },
  { texto: "¿Ha padecido enfermedad grave u operación?", respuesta: null },
  { texto: "¿Fiebre Reumática?", respuesta: null },
  { texto: "¿Afecciones Cardiacas?", respuesta: null },
  { texto: "¿Presión Arterial Alta?", respuesta: null },
  { texto: "¿Infecciones Reiteradas?", respuesta: null },
  { texto: "¿Alergias?", respuesta: null },
  { texto: "¿Asma?", respuesta: null },
  { texto: "¿Diabetes?", respuesta: null },
  { texto: "¿SIDA?", respuesta: null },
  { texto: "¿Hepatitis?", respuesta: null },
  { texto: "¿Artritis?", respuesta: null },
  { texto: "¿Úlcera?", respuesta: null },
  { texto: "¿Problemas Renales?", respuesta: null },
  { texto: "¿Tuberculosis?", respuesta: null },
  { texto: "¿Enfermedades Venéreas?", respuesta: null },
  { texto: "¿Hemofilia?", respuesta: null },
  { texto: "¿Tumores?", respuesta: null },
  { texto: "¿Epilepsia?", respuesta: null },
  { texto: "¿Sinusitis?", respuesta: null },
  { texto: "¿Hemorragias?", respuesta: null },
  { texto: "¿Otras enfermedades?", respuesta: null },
  { texto: "¿Está tomando medicamentos?", respuesta: null },
  { texto: "¿Toma aspirinas frecuentemente?", respuesta: null },
  { texto: "¿Está embarazada?", respuesta: null },
  { texto: "¿Ha presentado problemas dentales previos?", respuesta: null },
  { texto: "¿Fuma?", respuesta: null }
]
// Para armar filas de 2 preguntas
const filasAfecciones = []
for (let i = 2; i < 22; i += 2) {
  filasAfecciones.push([
    { texto: preguntas[i].texto, index: i },
    preguntas[i + 1] ? { texto: preguntas[i + 1].texto, index: i + 1 } : null
  ])
}
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

const calcularEdad = () => {
  if (form.fecha_nacimiento) {
    const hoy = new Date()
    const nacimiento = new Date(form.fecha_nacimiento)
    let edad = hoy.getFullYear() - nacimiento.getFullYear()
    const m = hoy.getMonth() - nacimiento.getMonth()
    if (m < 0 || (m === 0 && hoy.getDate() < nacimiento.getDate())) edad--
    form.edad = edad
  }
}

const formatCuit = () => {
  let cuit = form.afiliado_nro.replace(/\D/g, '')
  if (cuit.length > 2) cuit = cuit.slice(0, 2) + '-' + cuit.slice(2)
  if (cuit.length > 11) cuit = cuit.slice(0, 11) + '-' + cuit.slice(11, 12)
  form.afiliado_nro = cuit
}

const toggleDiente = (d) => {
  if (dientesSeleccionados.value.includes(d)) {
    dientesSeleccionados.value = dientesSeleccionados.value.filter(x => x !== d)
  } else {
    dientesSeleccionados.value.push(d)
  }
}

const responder = (index, respuesta) => {
  preguntas[index].respuesta = respuesta
}
</script>

<style src="../../css/crearPaciente.css"></style>
