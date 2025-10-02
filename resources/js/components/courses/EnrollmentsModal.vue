<script setup lang="ts">
import { Course, Student, Enrollment, Enum } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { computed, ref } from 'vue';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '../enrollments/columns';
import ListModal from '../students/ListModal.vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  course: Course;
};

interface EnrollmentForm {
  enrollments: Enrollment[];
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const enrollmentStatuses = computed(() => (usePage().props.status as Enum[]));
const students = computed(() => (usePage().props.students as Student[]));
const loading = ref(false);
const showSelectStudentsDialog = ref(false);

const fetchStudents = () => {
  router.reload({
    only: ['students'],
    onBefore: () => loading.value = true,
    onError: () => toast.error('Error fetching students', {
      description: 'There was an error fetching the students.',
    }),
    onFinish: () => {
      showSelectStudentsDialog.value = true;
      loading.value = false;
    },
  });
};

const addStudents = (selectedStudents: Student[]) => {
  const selected = selectedStudents.map((student) => ({
    student: student,
    course: props.course,
    status: { value: 'active', label: 'Active', color: 'green' },
    enrolled_at: new Date().toISOString(),
    credits: 0,
    discount_pct: 0,
  }));
  form.enrollments = [...selected];
};

const removeStudentFromCourse = (student: Student) => {
  form.enrollments = form.enrollments.filter((enrollment) => enrollment.student.id !== student.id);
};

const form = useForm<EnrollmentForm>({
  enrollments: props.course?.enrollments || [],
});

const submitForm = () => {
  form.patch(route('enrollments.update', props.course), {
    preserveState: 'errors',
    onSuccess: () => {
      closeModal();
      toast.success('Course updated successfully', {
        description: 'The course data has been updated.',
      });
    },
    onError: () => {
      toast.error('Error updating course', {
        description: 'There was an error updating the course data.',
      });
    },
  });
};

const closeModal = () => {
  emit('update:open', false);
  form.clearErrors();
  form.reset();
};
</script>

<template>
  <Dialog :open="open" @update:open="closeModal">
    <DialogContent>
      <form @submit.prevent="submitForm" class="space-y-6">
        <DialogHeader>
          <DialogTitle>{{ title }}</DialogTitle>
          <DialogDescription v-if="description">{{ description }}</DialogDescription>
        </DialogHeader>

        <DataTable :columns="columns" :data="form.enrollments ?? []"
          :options="{ settings: false, rowsPerPage: false, actionButton: 'Enroll student' }"
          @action-button-click="fetchStudents" />

        <ListModal v-model:open="showSelectStudentsDialog" :all-students="students ?? []"
          :selected-students="form.enrollments?.map((e) => e.student) ?? []" @students-selected="addStudents" />

        <DialogFooter class="gap-2">
          <DialogClose as-child>
            <Button variant="secondary" @click="closeModal()"> Cancel </Button>
          </DialogClose>
          <Button type="submit"> Save changes </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>