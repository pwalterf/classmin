<script setup lang="ts">
import { Student } from '@/types';
import { computed, ref } from 'vue';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import FormModal from './FormModal.vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from './selectionColumns';

interface Props {
  open?: boolean;
  allStudents: Student[];
  selectedStudents: Student[];
};

const props = defineProps<Props>()
const emit = defineEmits(['update:open', 'send-selected-row']);

const openFormModal = ref(false);

const availableStudents = computed(() => {
  const selectedIds = props.selectedStudents.map(student => student.id);
  return props.allStudents.filter(student => !selectedIds.includes(student.id));
});

const sendSelected = (student: Student) => {
  emit('send-selected-row', student);
};

const closeModal = () => {
  emit('update:open', false);
};
</script>

<template>
  <Dialog :open="props.open" @update:open="closeModal">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>Students list</DialogTitle>
        <DialogDescription>
          Enroll students to the course.
        </DialogDescription>
      </DialogHeader>
      <div>
        <DataTable :columns="columns" :data="availableStudents"
          :options="{ settings: false, actionButton: 'New student', rowsPerPage: false }"
          @send-selected-row="sendSelected" @action-button-click="openFormModal = true" />
      </div>
      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal"> Close </Button>
        </DialogClose>
      </DialogFooter>

      <FormModal v-model:open="openFormModal" title="New student"
        description="Fill in the details below to create a new student profile." />
    </DialogContent>
  </Dialog>
</template>