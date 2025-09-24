<script setup lang="ts">
import { ref } from 'vue';
import ListModal from '../students/ListModal.vue';
import FormModal from './FormModal.vue';
import { Course, Enrollment, Student } from '@/types';

interface Props {
  open?: boolean;
  allStudents: Student[];
  selectedStudents: Student[];
  course?: Course;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open', 'enrollment-saved']);

const studentSelected = ref<Student>();
const openEnrollmentForm = ref(false);

const selectedRow = (student: Student) => {
  openEnrollmentForm.value = true;
  studentSelected.value = student;
};

const addEnrollment = (enrollment: Enrollment) => {
  emit('enrollment-saved', enrollment);
};
</script>

<template>
  <ListModal :open="props.open" @update:open="emit('update:open', false)" :all-students="allStudents"
    :selected-students="selectedStudents" @send-selected-row="selectedRow" />

  <FormModal v-if="studentSelected" v-model:open="openEnrollmentForm" title="New enrollment"
    description="Fill in the details below to create a new enrollment." :student="studentSelected" :course="course"
    @enrollment-saved="addEnrollment" />
</template>