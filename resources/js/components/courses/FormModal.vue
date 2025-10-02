<script setup lang="ts">
import { Enum, Course } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { computed } from 'vue';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import { DateValue, parseAbsoluteToLocal, toCalendarDate } from "@internationalized/date";
import { cn } from '@/lib/utils';
import CalendarSelects from '@/components/ui/calendar/CalendarSelects.vue';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  course?: Course;
};

interface CourseForm {
  title: string;
  description: string;
  started_at: DateValue | string | undefined;
  status: string;
  schedule: string;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const courseStatuses = computed(() => (usePage().props.courseStatuses as Enum[]));

const form = useForm<CourseForm>({
  title: props.course?.title || '',
  description: props.course?.description || '',
  started_at: typeof props.course?.started_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.course.started_at))
    : props.course?.started_at
    || undefined,
  status: props.course?.status.value || '',
  schedule: props.course?.schedule || '',
}).transform((data) => ({
  ...data,
  started_at: data.started_at ? data.started_at.toString() : null,
}));

const submitForm = () => {
  if (props.course) {
    form.patch(route('courses.update', props.course), {
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
  } else {
    form.post(route('courses.store'), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Course created successfully', {
          description: 'The course has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating course', {
          description: 'There was an error creating the course.',
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
          <Label for="title">Title</Label>
          <Input id="title" type="text" v-model="form.title" />
          <InputError :message="form.errors.title" />
        </div>

        <div class="grid gap-2">
          <Label for="description">Description</Label>
          <Textarea id="description" v-model="form.description"></Textarea>
          <InputError :message="form.errors.description" />
        </div>

        <div class="grid gap-2">
          <Label for="started_at">Started date</Label>
          <Popover>
            <PopoverTrigger as-child>
              <Button id="started_at" variant="outline" :class="cn(
                'w-full justify-start text-left font-normal',
                !form.started_at && 'text-muted-foreground',
              )">
                <CalendarIcon class="mr-2 h-4 w-4" />
                <CalendarValue :value="form.started_at" />
              </Button>
            </PopoverTrigger>
            <PopoverContent class="w-auto p-0">
              <CalendarSelects v-model="form.started_at as DateValue" />
            </PopoverContent>
          </Popover>

          <InputError :message="form.errors.started_at" />
        </div>

        <div class="grid gap-2">
          <Label for="status">Status</Label>
          <Select v-model="form.status">
            <SelectTrigger id="status" class="w-full">
              <SelectValue placeholder="Select a status" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem v-for="status in courseStatuses" :key="status.value" :value="status.value">
                  {{ status.label }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
          <InputError :message="form.errors.status" />
        </div>

        <div class="grid gap-2">
          <Label for="schedule">Schedule</Label>
          <Textarea id="schedule" v-model="form.schedule"></Textarea>
          <InputError :message="form.errors.schedule" />
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