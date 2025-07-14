<template>
  <div class="pago-wrapper">
    <!-- Debug visual -->
    <div style="margin-bottom:5px;font-size:0.98em;color:#888;">
      Tipo detectado: <b>{{ cardType }}</b>
    </div>

    <div :class="['card-preview', cardType, { flipped: showBack }]">
      <div class="card-front">
        <div class="chip"></div>
        <div class="card-number">{{ showCardNumber }}</div>
        <div class="card-details">
          <span class="card-holder">{{ form.holder || 'Nombre y Apellido' }}</span>
          <span class="card-expiry">{{ form.expiry || 'MM/AA' }}</span>
        </div>
        <div class="card-logo">
          <span v-if="cardType === 'visa'">💳 Visa</span>
          <span v-else-if="cardType === 'mastercard'">💳 Master</span>
          <span v-else>💳</span>
        </div>
      </div>
      <div class="card-back">
        <div class="card-stripe"></div>
        <div class="cvv-label">CVV</div>
        <div class="cvv-value">{{ form.cvv || '•••' }}</div>
      </div>
    </div>

    <div class="pago-formbox">
      <h2>Demo Link de Pago</h2>
      <label>Tarjeta de prueba</label>
      <select v-model="selectedCard" @change="fillCard">
        <option value="">-- Elegí una tarjeta o completá manual --</option>
        <option v-for="c in testCards" :value="c.number" :key="c.number">{{ c.label }}</option>
      </select>

      <form @submit.prevent="submit">
        <div class="inputs-group">
          <label>Nro. de tarjeta</label>
          <input v-model="form.cardNumber"
                 maxlength="19"
                 placeholder="•••• •••• •••• ••••"
                 @input="formatCardNumber" />
        </div>
        <div class="row-flex">
          <div class="inputs-group">
            <label>Vencimiento</label>
            <input v-model="form.expiry" maxlength="5" placeholder="MM/AA" />
          </div>
          <div class="inputs-group">
            <label>CVV</label>
            <input v-model="form.cvv"
                   maxlength="4"
                   placeholder="•••"
                   type="password"
                   @focus="showBack = true"
                   @blur="showBack = false"
            />
          </div>
        </div>
        <div class="inputs-group">
          <label>Nombre y Apellido</label>
          <input v-model="form.holder" maxlength="40" placeholder="Nombre como figura en la tarjeta" />
        </div>
        <div class="inputs-group">
          <label>DNI</label>
          <input v-model="form.document" maxlength="10" placeholder="Ej: 30000000" />
        </div>
        <div class="inputs-group">
          <label>Monto a pagar</label>
          <div class="money-field">
            <span>$</span>
            <input v-model="form.amount" type="number" min="1" max="999999" placeholder="Monto" />
          </div>
        </div>
        <button type="submit" class="submit-btn">
          <span v-if="loading">Procesando...</span>
          <span v-else>Simular Pago</span>
        </button>
      </form>
      <transition name="fade">
        <div v-if="resultado" class="response-box">
          <h3>Respuesta:</h3>
          <pre>{{ resultado }}</pre>
        </div>
      </transition>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed } from 'vue'
import api from '../axios'
import '../../css/DemoLinkPago.css'

const testCards = [
  { label: "Visa Crédito - 4500000000000007", number: "4500000000000007", expiry: "08/30", cvv: "123", holder: "Juan Demo", document: "20000000" },
  { label: "Mastercard Crédito - 5100000000000009", number: "5100000000000009", expiry: "08/30", cvv: "123", holder: "Maria Demo", document: "30000000" }
]

const selectedCard = ref("")
const form = reactive({
  cardNumber: "",
  expiry: "",
  cvv: "",
  holder: "",
  document: "",
  amount: 1000
})
const resultado = ref("")
const loading = ref(false)
const showBack = ref(false)

// --- Detección de tarjeta ---
const cardType = computed(() => {
  const num = form.cardNumber.replace(/\s/g, '');
  if (num.startsWith('4')) return 'visa';
  if (/^(5[1-5])/.test(num)) return 'mastercard';
  // Si querés cubrir más rangos nuevos de Mastercard, podés sumar:
  // if (/^(222[1-9]|22[3-9][0-9]|2[3-6][0-9]{2}|27[01][0-9]|2720)/.test(num)) return 'mastercard';
  return '';
});

function fillCard() {
  const c = testCards.find(card => card.number === selectedCard.value)
  if (c) {
    form.cardNumber = c.number
    form.expiry = c.expiry
    form.cvv = c.cvv
    form.holder = c.holder
    form.document = c.document
  }
}

function formatCardNumber() {
  form.cardNumber = form.cardNumber
    .replace(/\D/g, '')
    .replace(/(.{4})/g, '$1 ')
    .trim()
    .slice(0, 19)
}

const showCardNumber = computed(() => {
  if (!form.cardNumber) return '•••• •••• •••• ••••'
  let val = form.cardNumber.replace(/\D/g, '').padEnd(16, '•')
  return val.replace(/(.{4})/g, '$1 ').trim()
})

async function submit() {
  resultado.value = ""
  loading.value = true
  try {
    const { data } = await api.post('/demo-link-pago', {
      ...form,
      cardNumber: form.cardNumber.replace(/\s/g, '')
    })
    resultado.value = typeof data === 'object' ? JSON.stringify(data, null, 2) : data
  } catch (err) {
    resultado.value =
      err.response?.data?.error ||
      err.response?.data?.message ||
      err.message ||
      "Error al contactar backend"
  }
  loading.value = false
}
</script>
