<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Enrollment } from '@/types';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from './columns';
import { ref } from 'vue';
import FormModal from './FormModal.vue';

interface Props {
  open?: boolean;
  title: string;
  description: string;
  enrollment: Enrollment;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const openCreditForm = ref(false);

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

      <DataTable :columns="columns" :data="enrollment.creditTransactions ?? []"
        :options="{ settings: false, rowsPerPage: false, actionButton: 'New credits' }"
        @action-button-click="openCreditForm = true" />

      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal()"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>

    <FormModal v-model:open="openCreditForm" title="Adjustment"
      description="Create new adjustment for the student's credits" :enrollment="enrollment" />
  </Dialog>
</template>