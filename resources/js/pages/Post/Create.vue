<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue'
import { route } from 'ziggy-js'
import type { BreadcrumbItem } from '@/types'
import { computed } from 'vue'

interface User {
  id: number
  name: string
}

interface Post {
  id: number
  title: string
  description: string
  verified_at: string | null
  verified_by: number | null
  verifier?: User | null
  verified_human?: string | null
}

interface Props {
  post?: Post
}

const props = defineProps<Props>()

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Post',
    href: '/posts',
  },
]

// Compute previous/next IDs safely
const previousId = computed(() => {
  if (!props.post) return null
  return props.post.id > 1 ? props.post.id - 1 : null
})

const nextId = computed(() => {
  if (!props.post) return null
  return props.post.id + 1
})

// Optional: toggle verify via JS instead of Link
const toggleVerify = () => {
  if (!props.post) return

  if (!props.post.verified_at) {
    router.patch(route('posts.verify', props.post.id))
  } else {
    router.patch(route('posts.unverify', props.post.id))
  }
}
</script>

<template>
  <Head title="Post Details" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="space-y-4">
      <h1 class="text-xl font-semibold">Post Details</h1>
    
      <!-- Navigation -->
      <div class="flex space-x-2">
        <Link
          v-if="previousId"
          class="px-4 py-2 bg-blue-800 text-white rounded hover:bg-blue-700 transition"
          :href="route('posts.send', previousId)"
        >
          Previous
        </Link>

        <Link
          v-if="nextId"
          class="px-4 py-2 bg-red-800 text-white rounded hover:bg-red-700 transition"
          :href="route('posts.send', nextId)"
        >
          Next
        </Link>
      </div>

      <!-- Post Info -->
      <div class="mt-4 p-4 bg-gray-100 rounded space-y-2">
        <p><strong>ID:</strong> {{ props.post?.id }}</p>
        <p><strong>Title:</strong> {{ props.post?.title }}</p>
        <p><strong>Description:</strong> {{ props.post?.description }}</p>
        <p>
          <strong>Verified At:</strong>
          {{ new Date(props.post?.verified_at).toLocaleString() ?? 'Not verified' }}
        </p>
        <p>
          <strong>Verified By:</strong>
          {{ props.post?.verifier?.name ?? 'Not verified' }}
        </p>
      </div>

      <!-- Verify / Unverify Button -->
      <button
        v-if="props.post"
        @click="toggleVerify"
        class="px-4 py-2 text-white rounded transition"
        :class="props.post.verified_at ? 'bg-red-600 hover:bg-red-500' : 'bg-green-700 hover:bg-green-600'"
      >
        {{ props.post.verified_at ? 'Unverify' : 'Verify' }}
      </button>
    </div>
  </AppLayout>
</template>