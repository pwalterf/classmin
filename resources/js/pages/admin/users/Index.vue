<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const users = ref([]);
const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: 'Admin Users',
    href: '/admin/users',
  },
];
</script>

<template>
  <AppLayout>

    <Head title="Admin Users" />
  </AppLayout>
</template>