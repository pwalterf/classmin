<script setup lang="ts">
import { Attendance, Course, Enrollment, Enum, Lesson } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import { DateValue, parseAbsoluteToLocal, toCalendarDate } from "@internationalized/date";
import { cn } from '@/lib/utils';
import CalendarSelects from '@/components/ui/calendar/CalendarSelects.vue';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '../ui/select';
import { computed } from 'vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  lesson?: Lesson;
  course: Course;
};

interface LessonForm {
  notes: string;
  student_page: string;
  workbook_page: string;
  taught_at: DateValue | string | undefined;
  course_id: number;
  attendances: Array<{
    status: string;
    notes?: string;
    enrollment?: Enrollment;
  }>;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const attendanceStatuses = computed(() => (usePage().props.attendanceStatuses as Enum[]));
const attendancesFormatted = props.lesson?.attendances.map(attendance => ({
  id: attendance.id,
  status: attendance.status.value,
  notes: attendance.notes,
  enrollment: attendance.enrollment,
}));

const form = useForm<LessonForm>({
  notes: props.lesson?.notes || '',
  student_page: props.lesson?.student_page || '',
  workbook_page: props.lesson?.workbook_page || '',
  taught_at: typeof props.lesson?.taught_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.lesson.taught_at))
    : props.lesson?.taught_at
    || undefined,
  course_id: props.lesson?.course.id || props.course.id,
  attendances: attendancesFormatted || props.course.enrollments?.map(enrollment => ({
    status: 'present',
    notes: '',
    enrollment: enrollment,
  })),
}).transform((data) => ({
  ...data,
  taught_at: data.taught_at ? data.taught_at.toString() : null,
}));

const submitForm = () => {
  if (props.lesson) {
    form.patch(route('lessons.update', props.lesson), {
      preserveState: 'errors',
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        toast.success('Lesson updated successfully', {
          description: 'The lesson data has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating lesson', {
          description: 'There was an error updating the lesson data.',
        });
      },
    });
  } else {
    form.post(route('lessons.store'), {
      preserveState: 'errors',
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        toast.success('Lesson created successfully', {
          description: 'The lesson has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating lesson', {
          description: 'There was an error creating the lesson.',
        });
      },
    });
  }
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

        <div class="grid gap-2">
          <Label for="taught_at">Taught date</Label>
          <Popover>
            <PopoverTrigger as-child>
              <Button id="taught_at" variant="outline" :class="cn(
                'w-full justify-start text-left font-normal',
                !form.taught_at && 'text-muted-foreground',
              )">
                <CalendarIcon class="mr-2 h-4 w-4" />
                <CalendarValue :value="form.taught_at" />
              </Button>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
              <CalendarSelects v-model="form.taught_at as DateValue" />
            </PopoverContent>
          </Popover>

          <InputError :message="form.errors.taught_at" />
        </div>

        <div class="grid gap-2">
          <Label for="notes">Notes</Label>
          <Textarea id="notes" v-model="form.notes"></Textarea>
          <InputError :message="form.errors.notes" />
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="grid gap-2">
            <Label for="student_page">Student Book Page</Label>
            <Input id="student_page" v-model="form.student_page" />
            <InputError :message="form.errors.student_page" />
          </div>

          <div class="grid gap-2">
            <Label for="workbook_page">Workbook Page</Label>
            <Input id="workbook_page" v-model="form.workbook_page" />
            <InputError :message="form.errors.workbook_page" />
          </div>
        </div>

        <div class="grid gap-2">
          <Table>
            <TableHeader>
              <TableRow>
                <TableHead>Student</TableHead>
                <TableHead>Status</TableHead>
                <TableHead>Notes</TableHead>
              </TableRow>
            </TableHeader>
            <TableBody>
              <TableRow v-for="attendance in form.attendances" :key="attendance.enrollment?.id">
                <TableCell class="font-medium">
                  {{ attendance.enrollment?.student.full_name }}
                </TableCell>
                <TableCell>
                  <Select v-model="attendance.status">
                    <SelectTrigger id="attendance_status_{{ attendance.enrollment?.id }}" class="w-full">
                      <SelectValue placeholder="Select a status" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem v-for="status in attendanceStatuses" :key="status.value" :value="status.value">
                          {{ status.label }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                </TableCell>
                <TableCell>
                  <Input id="attendance_notes_{{ attendance.enrollment?.id }}" v-model="attendance.notes" />
                </TableCell>
              </TableRow>
            </TableBody>
          </Table>
        </div>

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