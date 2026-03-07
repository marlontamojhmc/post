<script setup>
import { ref, onMounted, nextTick } from 'vue'

const connected = ref(false)
const messages = ref([])
const newMessage = ref('')
const chatContainer = ref(null) // for auto-scroll

// Listen to Reverb events
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
            
            // Safe access for Reverb and Pusher
            const msg = e.message ?? e.data?.message ?? 'No message'
            messages.value.push(msg)

            newMessage.value = ''

            // Auto-scroll to bottom
            nextTick(() => {
                if (chatContainer.value) {
                    chatContainer.value.scrollTop = chatContainer.value.scrollHeight
                }
            })
        })
})

// Trigger event
function triggerEvent() {
    if (!newMessage.value) return

    fetch(`/event?message=${encodeURIComponent(newMessage.value)}`)
        .then(res => res.text())
        .then(data => console.log('Server response:', data))
        .catch(err => console.error(err))
}
</script>

<template>
  <div style="padding: 20px; max-width: 500px; margin: auto; font-family: sans-serif;">
    <h1>Reverb Chat Test</h1>
    <p>
      Connection: <strong>{{ connected ? 'Connected ✅' : 'Not Connected ❌' }}</strong>
    </p>

    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
      <input 
        type="text" 
        v-model="newMessage" 
        placeholder="Type a message" 
        style="flex: 1; padding: 8px;"
        @keyup.enter="triggerEvent"
      />
      <button @click="triggerEvent" style="padding: 8px 12px;">Send</button>
    </div>

    <div 
      ref="chatContainer" 
      style="border: 1px solid #ccc; border-radius: 8px; padding: 10px; height: 300px; overflow-y: auto; background: #f9f9f9;"
    >
      <div v-for="(msg, index) in messages" :key="index" 
           :class="['chat-bubble', index % 2 === 0 ? 'incoming' : 'outgoing']">
        {{ msg }}
      </div>
    </div>
  </div>
</template>

<style scoped>
.chat-bubble {
  padding: 8px 12px;
  border-radius: 16px;
  margin-bottom: 6px;
  max-width: 80%;
  word-wrap: break-word;
}

/* Incoming messages */
.incoming {
  background-color: #e0e0e0;
  align-self: flex-start;
}

/* Outgoing messages */
.outgoing {
  background-color: #4caf50;
  color: white;
  align-self: flex-end;
  margin-left: auto;
}
button{
    background-color:blue;
    color:#fff;
    font-weight: 800;
    border-radius: 8px;
}
</style>