<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Course, BreadcrumbItem, Enum, Facet, Student } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import { columns } from '@/components/courses/columns';
import Heading from '@/components/Heading.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { Button } from '@/components/ui/button';
import FormModal from '@/components/courses/FormModal.vue';
import { ref } from 'vue';

interface Props {
  courses: Course[];
  statuses: Enum[];
  students?: Student[];
}

const props = defineProps<Props>();

const showModal = ref(false);
const facets: Facet[] = [
  {
    value: 'status',
    label: 'Status',
    options: props.statuses,
  }
];

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Courses',
    href: '/teacher/courses',
  },
];
</script>

<template>

  <Head title="Courses" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="flex justify-between">
        <Heading title="Course List" description="A list of courses presents in app"></Heading>
        <Link :href="route('courses.create')">
        <Button>New course</Button>
        </Link>

        <FormModal v-model:open="showModal" title="New course"
          description="Fill in the details below to create a new course." />
      </div>
      <DataTable :columns="columns" :data="courses" :facets="facets" />
    </div>
  </AppLayout>
</template>