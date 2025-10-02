<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Lesson } from '@/types';
import { ref } from 'vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '../ui/alert-dialog';
import { toast } from 'vue-sonner';
import FormModal from './FormModal.vue';
import AttendancesForm from '@/components/attendances/FormModal.vue';

interface Props {
  lesson: Lesson;
};

const props = defineProps<Props>();

const openLessonForm = ref(false);
const openAttendancesForm = ref(false);
const showDeleteModal = ref(false);

const deleteSubmit = () => {
  router.delete(route('lessons.destroy', props.lesson), {
    onSuccess: () => {
      toast.success('Lesson deleted successfully', {
        description: 'The lesson has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting lesson', {
        description: 'There was an error deleting the lesson.',
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
      <DropdownMenuItem @select="openLessonForm = true">
        Edit lesson
      </DropdownMenuItem>
      <DropdownMenuItem @select="openAttendancesForm = true">
        Attendances
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-red-600" @select="showDeleteModal = true">
        Delete lesson
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <FormModal v-model:open="openLessonForm" title="Edit lesson data"
    description="Make changes to the lesson data here. Click save when you're done." :lesson="lesson"
    :course="lesson.course" />

  <AttendancesForm v-model:open="openAttendancesForm" title="Manage Attendances"
    description="Manage the attendances for this lesson." :attendances="lesson.attendances" />

  <AlertDialog v-model:open="showDeleteModal">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This lesson will no longer be
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