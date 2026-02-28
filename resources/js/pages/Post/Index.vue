<script setup lang="ts">
import { defineProps } from 'vue';
import { Link } from '@inertiajs/vue3';
import { route } from 'ziggy-js';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';

// Props from Laravel Inertia
const props = defineProps<{
  posts: {
    data: { id: number; title: string; description: string }[];
    current_page: number;
    per_page: number;
    total: number;
    links: { url: string | null; label: string; active: boolean }[];
  } | null;
}>();

// Null-safe fallback
const posts = props.posts ?? { data: [], current_page: 1, per_page: 10, links: [] };

// Breadcrumbs
const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Posts', href: '/posts' },
];
</script>

<template>
  <!-- Only one AppLayout wrapper -->
  <AppLayout :breadcrumbs="breadcrumbs">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-xl font-bold">Post List</h1>
      <Link
        :href="route('posts.create')"
        class="px-4 py-2 bg-green-800 text-white rounded hover:bg-green-700 transition"
      >
        Create Post
      </Link>
    </div>

    <!-- Posts Table -->
    <table class="w-full border-collapse border">
      <thead>
        <tr class="bg-gray-100">
          <th class="border px-3 py-2 text-left">#</th>
          <th class="border px-3 py-2 text-left">Title</th>
          <th class="border px-3 py-2 text-left">Description</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(post, index) in posts.data" :key="post.id" class="border-b">
          <td class="border px-3 py-2">
            {{ (posts.current_page - 1) * posts.per_page + index + 1 }}
          </td>
          <td class="border px-3 py-2">{{ post.title ?? '-' }}</td>
          <td class="border px-3 py-2">{{ post.description ?? '-' }}</td>
        </tr>

        <!-- Empty state -->
        <tr v-if="posts.data.length === 0">
          <td colspan="3" class="text-center py-4 text-gray-500">
            No posts found.
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4 flex space-x-2">
      <Link
        v-for="link in posts.links"
        :key="link.label"
        v-html="link.label"
        :href="link.url ?? '#'"
        class="px-3 py-1 border rounded disabled:opacity-50 hover:bg-gray-100 transition"
        :class="{ 'opacity-50 cursor-not-allowed': !link.url }"
      />
    </div>
  </AppLayout>
</template>