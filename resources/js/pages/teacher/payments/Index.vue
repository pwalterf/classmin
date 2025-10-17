<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Payment, BreadcrumbItem, Student } from '@/types';
import { Head } from '@inertiajs/vue3';
import { columns } from '@/components/payments/columns';
import Heading from '@/components/Heading.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { Button } from '@/components/ui/button';
import { ref } from 'vue';
import FormModal from '@/components/payments/FormModal.vue';

interface Props {
  payments: Payment[];
  students?: Student[];
}

const props = defineProps<Props>();

const showModal = ref(false);

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Payments',
    href: '/teacher/payments',
  },
];
</script>

<template>

  <Head title="Payments" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <div class="flex justify-between">
        <Heading title="Payment List" description="A list of payments presents in app"></Heading>
        <Button @click="showModal = true">New payment</Button>

        <FormModal v-model:open="showModal" title="New Payment" description="Fill in the details below" />
      </div>
      <DataTable :columns="columns" :data="payments" />
    </div>
  </AppLayout>
</template>