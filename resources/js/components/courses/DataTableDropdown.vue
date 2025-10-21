<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Course } from '@/types';
import { ref } from 'vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '../ui/alert-dialog';
import { toast } from 'vue-sonner';
import EditFormModal from '@/components/courses/EditFormModal.vue';
import LessonForm from '@/components/lessons/FormModal.vue';
import HistoryModal from '@/components/course-prices/HistoryModal.vue';

interface Props {
  course: Course;
};

const props = defineProps<Props>();

const showModal = ref(false);
const showLessonForm = ref(false);
const showPriceHistory = ref(false);
const showDeleteModal = ref(false);

const deleteSubmit = () => {
  router.delete(route('courses.destroy', props.course), {
    onSuccess: () => {
      toast.success('Course deleted successfully', {
        description: 'The course has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting course', {
        description: 'There was an error deleting the course.',
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
      <DropdownMenuItem>
        <Link :href="route('courses.show', course.id)">Course details</Link>
      </DropdownMenuItem>
      <DropdownMenuItem @select="showModal = true">
        Edit course
      </DropdownMenuItem>
      <DropdownMenuItem @select="showLessonForm = true">
        New lesson
      </DropdownMenuItem>
      <DropdownMenuItem @select="showPriceHistory = true">
        Prices
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-red-600" @select="showDeleteModal = true">
        Delete course
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <EditFormModal v-model:open="showModal" title="Edit course data"
    description="Make changes to the course data here. Click save when you're done." :course="course" />

  <LessonForm v-model:open="showLessonForm" title="New lesson" description="Create a new lesson for this course."
    :course="course" />

  <HistoryModal v-model:open="showPriceHistory" title="Price History"
    description="View the price history for this course" :course="course" />

  <AlertDialog v-model:open="showDeleteModal">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This course will no longer be
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