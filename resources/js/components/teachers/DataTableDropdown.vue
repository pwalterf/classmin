<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Teacher } from '@/types';
import { ref } from 'vue';
import FormModal from './FormModal.vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '../ui/alert-dialog';
import { toast } from 'vue-sonner';

interface Props {
  teacher: Teacher;
};

const props = defineProps<Props>();

const showModal = ref(false);
const showDeleteModal = ref(false);

const deleteSubmit = () => {
  router.delete(route('teachers.destroy', props.teacher), {
    onSuccess: () => {
      toast.success('Teacher deleted successfully', {
        description: 'The teacher has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting teacher', {
        description: 'There was an error deleting the teacher.',
      });
    },
    onFinish: () => {
      showDeleteModal.value = false;
    },
  });
};
</script>

<template>

  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <DropdownMenuItem>View teacher</DropdownMenuItem>
      <DropdownMenuItem @select="showModal = true">
        Edit teacher data
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-red-600" @select="showDeleteModal = true">
        Delete teacher
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <FormModal v-model:open="showModal" title="Edit teacher data"
    description="Make changes to the teacher profile here. Click save when you're done." :teacher="teacher" />

  <AlertDialog v-model:open="showDeleteModal">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This teacher will no longer be
          accessible by you or others you've shared it with.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancel</AlertDialogCancel>
        <Button variant="destructive" @click="deleteSubmit">
          Delete
        </Button>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>

</template>