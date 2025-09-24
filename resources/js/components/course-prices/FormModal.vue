<script setup lang="ts">
import { Course, CoursePrice } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { DateValue, parseAbsoluteToLocal, toCalendarDate } from '@internationalized/date';
import { cn } from '@/lib/utils';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon } from 'lucide-vue-next';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import CalendarSelects from '@/components/ui/calendar/CalendarSelects.vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  coursePrice?: CoursePrice;
  course: Course;
};

interface CoursePriceForm {
  price: number;
  currency: string;
  started_at: DateValue | string | undefined;
  ended_at?: DateValue | string | undefined;
  course_id: number;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const form = useForm<CoursePriceForm>({
  price: props.coursePrice?.price || 0,
  currency: props.coursePrice?.currency || 'ARS',
  started_at: typeof props.coursePrice?.started_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.coursePrice.started_at))
    : props.coursePrice?.started_at
    || undefined,
  ended_at: typeof props.coursePrice?.ended_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.coursePrice.ended_at))
    : props.coursePrice?.ended_at
    || undefined,
  course_id: props.course.id,
}).transform((data) => ({
  ...data,
  started_at: data.started_at ? data.started_at.toString() : null,
  ended_at: data.ended_at ? data.ended_at.toString() : null,
}));

const submitForm = () => {
  if (props.coursePrice) {
    form.patch(route('coursePrices.update', props.coursePrice), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Price updated successfully', {
          description: 'The price of the course has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating price', {
          description: 'There was an error updating the price of the course.',
        });
      },
    });
  } else {
    form.post(route('coursePrices.store'), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Price created successfully', {
          description: 'The price of the course has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating price', {
          description: 'There was an error creating the price of the course.',
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

        <div class="grid grid-cols-2 gap-4">
          <div class="grid gap-2">
            <Label for="currency">Currency</Label>
            <Input id="currency" type="text" v-model="form.currency" />
            <InputError :message="form.errors.currency" />
          </div>

          <div class="grid gap-2">
            <Label for="price">Price per hour</Label>
            <Input id="price" type="text" v-model="form.price" />
            <InputError :message="form.errors.price" />
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div class="grid gap-2" :class="coursePrice ? '' : 'col-span-2'">
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

          <div class="grid gap-2" v-if="coursePrice">
            <Label for="ended_at">Ended date</Label>
            <Popover>
              <PopoverTrigger as-child>
                <Button id="ended_at" variant="outline" :class="cn(
                  'w-full justify-start text-left font-normal',
                  !form.ended_at && 'text-muted-foreground',
                )">
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  <CalendarValue :value="form.ended_at" />
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <CalendarSelects v-model="form.ended_at as DateValue" />
              </PopoverContent>
            </Popover>

            <InputError :message="form.errors.ended_at" />
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