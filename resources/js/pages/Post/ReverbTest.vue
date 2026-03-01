<script setup>
import { ref, onMounted } from 'vue'

const connected = ref(false)
const messages = ref([])

onMounted(() => {
    if (!window.Echo) {
        console.error('❌ Echo not initialized')
        return
    }

    window.Echo.channel('hello-test')
        .subscribed(() => {
            connected.value = true
            console.log('✅ Connected to hello-test')
        })
        .listen('HelloTest', (e) => {
        console.log('Received event:', e)
        messages.value.push(e.message)
    })
})

// Method to trigger the event
function triggerEvent() {
    fetch('/event')
        .then(res => res.text())
        .then(data => console.log('Server response:', data))
        .catch(err => console.error(err))
}
</script>

<template>
  <div style="padding: 20px">
    <h1>Reverb Test</h1>
    <p>
      Connection: <strong>{{ connected ? 'Connected ✅' : 'Not Connected ❌' }}</strong>
    </p>

    <button @click="triggerEvent" style="padding: 10px; margin: 10px 0;">
      Trigger Event
    </button>

    <div v-if="messages.length">
      <h3>Received Events:</h3>
      <pre>{{ messages }}</pre>
    </div>
  </div>
</template>