<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '@/components/payments/columns';
import { Payment } from '@/types';

interface Props {
  open?: boolean;
  title: string;
  description: string;
  payments: Payment[];
}

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const closeModal = () => {
  emit('update:open', false);
};

</script>

<template>
  <Dialog :open="props.open" @update:open="closeModal">
    <DialogContent class="sm:max-w-[800px] overflow-x-auto">
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <DialogDescription v-if="description">{{ description }}</DialogDescription>
      </DialogHeader>

      <DataTable :columns="columns" :data="payments ?? []" :options="{ settings: false, rowsPerPage: false }" />

      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal()"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>