<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Enrollment } from '@/types';
import { ref } from 'vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from './columns';
import FormModal from '@/components/payments/FormModal.vue';

interface Props {
  open?: boolean;
  title: string;
  description: string;
  enrollment: Enrollment;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const openPaymentForm = ref(false);

const closeModal = () => {
  emit('update:open', false);
};

</script>

<template>
  <Dialog :open="props.open" @update:open="closeModal">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <DialogDescription v-if="description">{{ description }}</DialogDescription>
      </DialogHeader>

      <DataTable :columns="columns" :data="enrollment.payments ?? []"
        :options="{ settings: false, rowsPerPage: false, actionButton: 'New payment' }"
        @action-button-click="openPaymentForm = true" />

      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal()"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>

    <FormModal v-model:open="openPaymentForm" title="New payment" description="Create new payment for the student"
      :enrollment="enrollment" />
  </Dialog>
</template>