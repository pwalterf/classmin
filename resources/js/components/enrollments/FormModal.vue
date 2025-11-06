<script setup lang="ts">
import { Course, Enrollment, Enum, Student } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { parseAbsoluteToLocal, parseDate, toCalendarDate } from "@internationalized/date";
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import CalendarCustom from '@/components/ui/calendar/CalendarCustom.vue';
import { cn } from '@/lib/utils';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { computed } from 'vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  enrollment?: Enrollment;
  course?: Course;
  student: Student;
};

interface EnrollmentForm {
  status: string;
  enrolled_at: string | undefined;
  credits: number;
  discount_pct: number;
  course_id?: number | null;
  student_id: number;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open', 'enrollment-saved']);

const enrollmentStatuses = computed(() => (usePage().props.enrollmentStatuses as Enum[]));

const addEnrollment = () => {
  const temporalEnrollment = {
    status: form.status,
    enrolled_at: form.enrolled_at?.toString(),
    credits: form.credits,
    discount_pct: form.discount_pct,
    student: props.student,
  };
  emit('enrollment-saved', temporalEnrollment);
};

const enrolled_at = computed({
  get: () => typeof form.enrolled_at !== 'undefined' ? parseDate(form.enrolled_at) : undefined,
  set: (val) => form.enrolled_at = val?.toString(),
});

const form = useForm<EnrollmentForm>({
  status: props.enrollment?.status.value || '',
  enrolled_at: typeof props.enrollment?.enrolled_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.enrollment.enrolled_at)).toString()
    : props.enrollment?.enrolled_at
    || undefined,
  credits: props.enrollment?.credits || 0,
  discount_pct: props.enrollment?.discount_pct || 0,
  course_id: props.course?.id || null,
  student_id: props.student.id,
}).transform((data) => ({
  ...data,
  enrolled_at: data.enrolled_at ?? null,
}));

const submitForm = () => {
  if (props.enrollment) {
    form.patch(route('enrollments.update', props.enrollment), {
      preserveState: true,
      onSuccess: () => {
        closeModal();
        toast.success('Enrollment updated successfully', {
          description: 'The enrollment data has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating enrollment', {
          description: 'There was an error updating the enrollment data.',
        });
      },
    });
  } else {
    form.post(route('enrollments.store'), {
      preserveState: true,
      onSuccess: () => {
        // Only emit the event to add the enrollment to the list if no course prop is provided
        if (!props.course) {
          addEnrollment();
        }

        closeModal();
        toast.success('Enrollment created successfully', {
          description: 'The enrollment data has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating enrollment', {
          description: 'There was an error creating the enrollment data.',
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

        <div class="grid grid-cols-2 gap-2">
          <div class="grid gap-2">
            <Label for="enrolled_at">Enrolled date</Label>
            <Popover>
              <PopoverTrigger as-child>
                <Button id="enrolled_at" variant="outline" :class="cn(
                  'w-full justify-start text-left font-normal',
                  !form.enrolled_at && 'text-muted-foreground',
                )">
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  <CalendarValue :value="enrolled_at" />
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <CalendarCustom v-model="enrolled_at" />
              </PopoverContent>
            </Popover>

            <InputError :message="form.errors.enrolled_at" />
          </div>

          <div class="grid gap-2">
            <Label for="status">Status</Label>
            <Select v-model="form.status">
              <SelectTrigger id="status" class="w-full">
                <SelectValue placeholder="Select a status" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectItem v-for="status in enrollmentStatuses" :key="status.value" :value="status.value">
                    {{ status.label }}
                  </SelectItem>
                </SelectGroup>
              </SelectContent>
            </Select>
            <InputError :message="form.errors.status" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-2">
          <div class="grid gap-2">
            <Label for="credits">Credits</Label>
            <Input id="credits" type="text" v-model="form.credits" />
            <InputError :message="form.errors.credits" />
          </div>

          <div class="grid gap-2">
            <Label for="discount_pct">Discount percentage</Label>
            <Input id="discount_pct" type="string" v-model="form.discount_pct" />
            <InputError :message="form.errors.discount_pct" />
          </div>
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