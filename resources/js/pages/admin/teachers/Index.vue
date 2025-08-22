<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Teacher, BreadcrumbItem, Enum, Facet } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from '@/components/teachers/columns';
import Heading from '@/components/Heading.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { Button } from '@/components/ui/button';
import FormModal from '@/components/teachers/FormModal.vue';
import { ref } from 'vue';

interface Props {
  teachers: Teacher[];
  statuses: Enum[];
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
    title: 'Teachers',
    href: '/admin/teachers',
  },
];
</script>

<template>

  <Head title="Teachers" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="flex justify-between">
        <Heading title="Teacher List" description="A list of teacher presents in app"></Heading>
        <Button @click="showModal = true">New teacher</Button>

        <FormModal v-model:open="showModal" title="New teacher"
          description="Fill in the details below to create a new teacher profile." />
      </div>
      <DataTable :columns="columns" :data="teachers" :facets="facets" />
    </div>
  </AppLayout>
</template>