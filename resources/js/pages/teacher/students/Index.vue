<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Student, BreadcrumbItem, Enum, Facet } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { columns } from '@/components/students/columns';
import Heading from '@/components/Heading.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { Button } from '@/components/ui/button';
import FormModal from '@/components/students/FormModal.vue';
import { ref } from 'vue';

interface Props {
  students: Student[];
}

const props = defineProps<Props>();

const showModal = ref(false);

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Students',
    href: '/teacher/students',
  },
];
</script>

<template>

  <Head title="Students" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="flex justify-between">
        <Heading title="Student List" description="A list of students presents in app"></Heading>
        <Button @click="showModal = true">New student</Button>

        <FormModal v-model:open="showModal" title="New student"
          description="Fill in the details below to create a new student." />
      </div>
      <DataTable :columns="columns" :data="students" />
    </div>
  </AppLayout>
</template>