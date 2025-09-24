<script setup lang="ts">
import { Student } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { router, useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { DateValue, parseAbsoluteToLocal, toCalendarDate } from "@internationalized/date";
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import CalendarSelects from '@/components/ui/calendar/CalendarSelects.vue';
import { cn } from '@/lib/utils';
import CalendarValue from '../ui/calendar/CalendarValue.vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  student?: Student;
};

interface StudentForm {
  first_name: string;
  last_name: string;
  email: string;
  date_of_birth: DateValue | string | undefined;
  phone_number: string;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const form = useForm<StudentForm>({
  first_name: props.student?.first_name || '',
  last_name: props.student?.last_name || '',
  email: props.student?.email || '',
  date_of_birth: typeof props.student?.date_of_birth === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.student.date_of_birth))
    : props.student?.date_of_birth
    || undefined,
  phone_number: props.student?.phone_number || '',
}).transform((data) => ({
  ...data,
  date_of_birth: data.date_of_birth ? data.date_of_birth.toString() : null,
}));

const submitForm = () => {
  if (props.student) {
    form.patch(route('students.update', props.student), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Student updated successfully', {
          description: 'The student profile has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating student', {
          description: 'There was an error updating the student profile.',
        });
      },
    });
  } else {
    form.post(route('students.store'), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Student created successfully', {
          description: 'The student profile has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating student', {
          description: 'There was an error creating the student profile.',
        });
      },
      onFinish: () => {
        router.reload({ only: ['students'] });
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
          <Label for="first_name">First Name</Label>
          <Input id="first_name" type="text" v-model="form.first_name" />
          <InputError :message="form.errors.first_name" />
        </div>

        <div class="grid gap-2">
          <Label for="last_name">Last Name</Label>
          <Input id="last_name" type="text" v-model="form.last_name" />
          <InputError :message="form.errors.last_name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">Email</Label>
          <Input id="email" type="email" v-model="form.email" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="date_of_birth">Date of birth</Label>
          <Popover>
            <PopoverTrigger as-child>
              <Button id="date_of_birth" variant="outline" :class="cn(
                'w-full justify-start text-left font-normal',
                !form.date_of_birth && 'text-muted-foreground',
              )">
                <CalendarIcon class="mr-2 h-4 w-4" />
                <CalendarValue :value="form.date_of_birth" />
              </Button>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
              <CalendarSelects v-model="form.date_of_birth as DateValue" />
            </PopoverContent>
          </Popover>

          <InputError :message="form.errors.date_of_birth" />
        </div>

        <div class="grid gap-2">
          <Label for="phone_number">Phone Number</Label>
          <Input id="phone_number" type="text" v-model="form.phone_number" />
          <InputError :message="form.errors.phone_number" />
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