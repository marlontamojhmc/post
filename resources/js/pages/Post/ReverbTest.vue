<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const page = usePage();

// --- Reactive states ---
const connected = ref(false);
const messages = ref([]);
const newMessage = ref('');
const chatContainer = ref(null);
const notification = ref(0);

// --- Initialize notification count from Inertia shared props ---
onMounted(() => {
    notification.value = page.props.auth.user_notification ?? 0;
    console.log('Initial notification count:', notification.value);

    if (!window.Echo) {
        console.error('❌ Echo not initialized');
        return;
    }

    const channel = window.Echo.channel('hello-test');

    channel.subscribed(() => {
        connected.value = true;
        console.log('✅ Connected to hello-test');
    });

    // Listen for HelloTest events
    channel.listen('HelloTest', async (e) => {
        // Update notification count from the broadcast
        if (typeof e.notificationCount !== 'undefined') {
            notification.value = e.notificationCount;
        }

        // Push the message to chat
        if (e.message) {
            messages.value.push(e.message);
        }

        // Auto-scroll
        await nextTick();
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    });
});

// --- Trigger Laravel Event ---
async function triggerEvent() {
    if (!newMessage.value) return;

    try {
        const res = await fetch(`/notify`);
        const data = await res.text();
        console.log('Server response:', data);
        newMessage.value = '';
    } catch (err) {
        console.error('Error sending event:', err);
    }
}
</script>

<template>
    <div
        style="
            padding: 20px;
            max-width: 500px;
            margin: auto;
            font-family: sans-serif;
        "
    >
        <h1>Reverb Chat Test</h1>

        <!-- Notification -->
        <p class="flex items-center gap-2">
            Unread Notifications:
            <span
                class="inline-block rounded-full bg-red-600 px-2 py-1 text-xs font-semibold text-white"
            >
                {{ notification }}
            </span>
        </p>

        <!-- Connection Status -->
        <p>
            Connection:
            <strong>{{
                connected ? 'Connected ✅' : 'Not Connected ❌'
            }}</strong>
        </p>

        <!-- Input & Send Button -->
        <div style="display: flex; gap: 10px; margin-bottom: 10px">
            <input
                type="text"
                v-model="newMessage"
                placeholder="Type a message"
                style="flex: 1; padding: 8px"
                @keyup.enter="triggerEvent"
            />
            <button @click="triggerEvent" style="padding: 8px 12px">
                Send
            </button>
        </div>

        <!-- Chat container -->
        <div
            ref="chatContainer"
            style="
                border: 1px solid #ccc;
                border-radius: 8px;
                padding: 10px;
                height: 300px;
                overflow-y: auto;
                background: #f9f9f9;
                display: flex;
                flex-direction: column;
            "
        >
            <div
                v-for="(msg, index) in messages"
                :key="index"
                :class="[
                    'chat-bubble',
                    index % 2 === 0 ? 'incoming' : 'outgoing',
                ]"
            >
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
</style>
