<script setup lang="ts">
import { Attendance, Enrollment, Enum } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { computed } from 'vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '../ui/table';
import { Input } from '../ui/input';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  attendances: Attendance[];
};

interface AttendanceForm {
  attendances: Array<{
    id?: number;
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
const attendancesFormatted = props.attendances.map(attendance => ({
  id: attendance.id,
  status: attendance.status.value,
  notes: attendance.notes,
  enrollment: attendance.enrollment,
}));

const form = useForm<AttendanceForm>({
  attendances: attendancesFormatted,
});

const submitForm = () => {
  form.patch(route('attendances.update'), {
    preserveState: 'errors',
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      toast.success('Attendance updated successfully', {
        description: 'The attendance data has been updated.',
      });
    },
    onError: () => {
      toast.error('Error updating attendance', {
        description: 'There was an error updating the attendance data.',
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