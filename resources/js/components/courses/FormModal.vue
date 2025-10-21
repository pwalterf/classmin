<script setup lang="ts">
import EnrollmentSelection from '@/components/enrollments/EnrollmentSelection.vue';
import Heading from '@/components/Heading.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import CalendarSelects from '@/components/ui/calendar/CalendarSelects.vue';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Stepper, StepperDescription, StepperItem, StepperSeparator, StepperTrigger } from '@/components/ui/stepper';
import { Table, TableBody, TableCell, TableEmpty, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import { cn } from '@/lib/utils';
import { Course, Enrollment, Enum, Student } from '@/types';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { DateValue, parseAbsoluteToLocal, toCalendarDate } from '@internationalized/date';
import { CalendarIcon, Check, Circle, Dot, UserRoundX } from 'lucide-vue-next';
import { computed, ref } from 'vue';
import { toast } from 'vue-sonner';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';

interface Props {
  open: boolean;
  title: string;
  description?: string;
};

interface CourseForm {
  title: string;
  description: string;
  started_at: DateValue | undefined;
  status: string;
  schedule: string;
  currency: string;
  price: number;
  enrollments: Enrollment[];
  errors?: {
    [key: string]: string | undefined;
  };
  reset?: (fields?: string | string[]) => void;
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const students = computed(() => (usePage().props.students ?? []) as Student[]);
const courseStatuses = computed(() => (usePage().props.courseStatuses as Enum[]));
const loading = ref(false);
const openSelectStudents = ref(false);
const studentsEnrolled = computed(() => form.enrollments.map((enrollment) => enrollment.student));

const fetchStudents = () => {
  router.reload({
    only: ['students'],
    onBefore: () => loading.value = true,
    onError: () => toast.error('Error fetching students', {
      description: 'There was an error fetching the students.',
    }),
    onFinish: () => {
      openSelectStudents.value = true;
      loading.value = false;
    },
  });
};

const addEnrollment = (enrollment: Enrollment) => {
  fetchStudents();
  form.enrollments.push(enrollment);
};

const removeEnrollment = (studentID: number) => {
  form.students = form.enrollments.filter((e) => e.student.id !== studentID);
};

const stepIndex = ref(1);
const steps = [
  {
    step: 1,
    description: "Detales del curso",
  },
  {
    step: 2,
    description: "Precio por hora",
  },
  {
    step: 3,
    description: "Asociar alumnos",
  },
];

const form = useForm<CourseForm>({
  title: '',
  description: '',
  started_at: undefined,
  status: '',
  schedule: '',
  currency: 'ARS',
  price: 0,
  enrollments: [],
}).transform((data) => ({
  ...data,
  started_at: data.started_at ? data.started_at.toString() : null,
  step: stepIndex.value,
}));

const submitForm = () => {
  form.post(route('courses.store'), {
    preserveState: true,
    onSuccess: () => {
      if (stepIndex.value === 3) {
        toast.success('Course created successfully', {
          description: 'The course has been created.',
        });
      } else {
        stepIndex.value = stepIndex.value + 1;
      }
    },
    onError: () => {
      toast.error('Error creating course', {
        description: 'There was an error creating the course.',
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

        <Stepper v-slot="{ nextStep, prevStep, hasNext, hasPrev }" v-model="stepIndex" class="block w-full">
          <div class="flex w-full item-start gap-2 border shadow p-4 rounded-lg">
            <StepperItem v-for="step in steps" :key="step.step" v-slot="{ state }"
              class="relative flex w-full flex-col items-center justify-center" :step="step.step">
              <StepperSeparator v-if="step.step !== steps[steps.length - 1].step"
                class="absolute left-[calc(50%+20px)] right-[calc(-50%+10px)] top-5 block h-0.5 shrink-0 rounded-full bg-muted group-data-[state=completed]:bg-primary" />

              <StepperTrigger as-child>
                <Button :variant="state === 'completed' || state === 'active' ? 'default' : 'outline'" size="icon"
                  class="z-10 rounded-full shrink-0"
                  :class="[state === 'active' && 'ring-2 ring-ring ring-offset-2 ring-offset-background']"
                  :disabled="state !== 'completed' && state !== 'active'">
                  <Check v-if="state === 'completed'" class="size-5" />
                  <Circle v-if="state === 'active'" />
                  <Dot v-if="state === 'inactive'" />
                </Button>
              </StepperTrigger>

              <div class="flex flex-col items-center text-center">
                <StepperDescription :class="[state === 'active' && 'text-primary']"
                  class="sr-only text-xs text-muted-foreground transition md:not-sr-only lg:text-sm">
                  {{ step.description }}
                </StepperDescription>
              </div>
            </StepperItem>
          </div>

          <div class="flex flex-col gap-4 mt-4">
            <template v-if="stepIndex === 1">
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

              <div class="grid grid-cols-2 gap-2">
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
                      <CalendarSelects v-model="form.started_at" initial-focus />
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
              </div>

              <div class="grid gap-2">
                <Label for="schedule">Schedule</Label>
                <Textarea id="schedule" v-model="form.schedule"></Textarea>
                <InputError :message="form.errors.schedule" />
              </div>
            </template>

            <template v-if="stepIndex === 2">
              <div class="grid grid-cols-4 gap-4">
                <div class="grid gap-2">
                  <Label for="currency">Currency</Label>
                  <Select v-model="form.currency">
                    <SelectTrigger id="status" class="w-full">
                      <SelectValue placeholder="Select a currency" />
                    </SelectTrigger>
                    <SelectContent>
                      <SelectGroup>
                        <SelectItem v-for="currency in ['ARS', 'USD', 'EUR']" :value="currency">
                          {{ currency }}
                        </SelectItem>
                      </SelectGroup>
                    </SelectContent>
                  </Select>
                  <InputError :message="form.errors.currency" />
                </div>

                <div class="grid col-span-3 gap-2">
                  <Label for="price">Price per hour</Label>
                  <Input id="price" type="text" v-model="form.price" />
                  <InputError :message="form.errors.price" />
                </div>
              </div>
            </template>

            <template v-if="stepIndex === 3">
              <div class="flex justify-between">
                <Heading title="Students" description="A list of enrolled students to the course."></Heading>
                <Button @click="fetchStudents" :disabled="loading">
                  Add student
                </Button>
              </div>
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Name</TableHead>
                    <TableHead>Email</TableHead>
                    <TableHead></TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <TableEmpty v-if="form.enrollments.length === 0" :colspan="3">
                    No students added.
                  </TableEmpty>

                  <TableRow v-for="enrollment in form.enrollments">
                    <TableCell class="font-medium">
                      {{ enrollment.student.full_name }}
                    </TableCell>
                    <TableCell>{{ enrollment.student.email }}</TableCell>
                    <TableCell class="text-right">
                      <Button type="button" variant="ghost" size="sm" @click="removeEnrollment(enrollment.student.id)">
                        <UserRoundX class="h-4 w-4" />
                      </Button>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>

              <EnrollmentSelection v-model:open="openSelectStudents" :all-students="students ?? []"
                :selected-students="studentsEnrolled" @enrollment-saved="addEnrollment" />
            </template>

            <div class="flex items-center justify-between mt-4">
              <Button type="button" :disabled="!hasPrev()" variant="outline" @click="prevStep()">
                Back
              </Button>
              <div class="flex items-center gap-3">
                <DialogClose as-child>
                  <Button variant="secondary" @click="closeModal()"> Cancel </Button>
                </DialogClose>
                <Button v-if="stepIndex !== 3" type="submit" :disabled="!hasNext()">
                  Next
                </Button>
                <Button v-if="stepIndex === 3" type="submit">
                  Submit
                </Button>
              </div>
            </div>
          </div>
        </Stepper>
      </form>
    </DialogContent>
  </Dialog>
</template>