<script setup lang="ts">
import { Enrollment, Payment, Student } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { router, useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { Popover, PopoverContent, PopoverTrigger } from '@/components/ui/popover';
import { CalendarIcon, User } from 'lucide-vue-next';
import { parseAbsoluteToLocal, parseDate, toCalendarDate } from "@internationalized/date";
import { cn } from '@/lib/utils';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import CalendarCustom from '@/components/ui/calendar/CalendarCustom.vue';
import { Card, CardContent } from '../ui/card';
import ListModal from '../students/ListModal.vue';
import { computed, ref } from 'vue';
import { Empty, EmptyContent, EmptyDescription, EmptyHeader, EmptyMedia, EmptyTitle } from '@/components/ui/empty';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  payment?: Payment;
  enrollment?: Enrollment;
};

interface PaymentForm {
  amount: number;
  currency: string;
  credits_purchased: number;
  paid_at: string | undefined;
  comments?: string;
  enrollment_id?: number;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const openStudentList = ref(false);
const openStudentEnrollments = ref(false);
const allStudents = computed(() => (usePage().props.students ?? []) as Student[]);
const studentSelected = ref<Student | null>(null);
const studentEnrollments = ref<Enrollment[] | undefined>();

const fetchStudents = () => {
  router.reload({
    only: ['students'],
    onError: () => toast.error('Error fetching students', {
      description: 'There was an error fetching the students.',
    }),
    onFinish: () => {
      openStudentList.value = true;
    },
  });
};

const addStudents = (selectedStudent: Student) => {
  studentSelected.value = selectedStudent;

  if (selectedStudent.enrollments?.length === 1) {
    form.enrollment_id = selectedStudent.enrollments[0].id;
    openStudentList.value = false;
  } else {
    studentEnrollments.value = selectedStudent.enrollments;
    openStudentEnrollments.value = true;
  }
};

const selectEnrollment = (enrollment: Enrollment) => {
  form.enrollment_id = enrollment.id;
  openStudentEnrollments.value = false;
  openStudentList.value = false;
};

const paid_at = computed({
  get: () => typeof form.paid_at !== 'undefined' ? parseDate(form.paid_at) : undefined,
  set: (val) => form.paid_at = val?.toString(),
});

const form = useForm<PaymentForm>({
  amount: props.payment?.amount || 0.00,
  currency: props.payment?.currency || 'ARS',
  credits_purchased: props.payment?.credits_purchased || 0,
  paid_at: typeof props.payment?.paid_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.payment?.paid_at)).toString()
    : undefined,
  comments: props.payment?.comments || '',
  enrollment_id: props.payment?.enrollment.id || props.enrollment?.id,
}).transform((data) => ({
  ...data,
  paid_at: data.paid_at ?? null,
}));

const submitForm = () => {
  if (props.payment) {
    form.patch(route('payments.update', props.payment), {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        toast.success('Payment updated successfully', {
          description: 'The payment data has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating payment', {
          description: 'There was an error updating the payment data.',
        });
      },
    });
  } else {
    form.post(route('payments.store'), {
      preserveState: true,
      preserveScroll: true,
      onSuccess: () => {
        closeModal();
        toast.success('Payment created successfully', {
          description: 'The payment has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating payment', {
          description: 'There was an error creating the payment.',
        });
      },
    });
  }
};

const closeModal = () => {
  emit('update:open', false);
  form.clearErrors();
  form.reset();
  studentSelected.value = null;
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

        <template v-if="form.enrollment_id && studentSelected?.enrollments">
          <Card>
            <CardContent class="flex justify-between">
              <div>
                <h2 class="text-sm font-semibold">{{ studentSelected?.full_name }}</h2>
                <p class="text-xs text-gray-500">{{ studentSelected.enrollments[0].course?.title }}</p>
              </div>
              <div>
                <h2 class="text-sm font-semibold">Credits</h2>
                <p class="text-xs text-gray-500">{{ studentSelected.enrollments[0].credits }}</p>
              </div>
            </CardContent>
          </Card>
          <div class="grid grid-cols-3 gap-4">
            <div class="grid gap-2">
              <Label for="currency">Currency</Label>
              <Input id="currency" type="text" v-model="form.currency" />
              <InputError :message="form.errors.currency" />
            </div>

            <div class="grid col-span-2 gap-2">
              <Label for="amount">Amount</Label>
              <Input id="amount" type="text" v-model="form.amount" />
              <InputError :message="form.errors.amount" />
            </div>
          </div>

          <div class="grid grid-cols-3 gap-4">
            <div class="grid gap-2">
              <Label for="credits_purchased">Credits purchased</Label>
              <Input id="credits_purchased" type="number" v-model="form.credits_purchased" />
              <InputError :message="form.errors.credits_purchased" />
            </div>

            <div class="grid col-span-2 gap-2">
              <Label for="paid_at">Paid date</Label>
              <Popover>
                <PopoverTrigger as-child>
                  <Button id="paid_at" variant="outline" :class="cn(
                    'w-full justify-start text-left font-normal',
                    !form.paid_at && 'text-muted-foreground',
                  )">
                    <CalendarIcon class="mr-2 h-4 w-4" />
                    <CalendarValue :value="paid_at" />
                  </Button>
                </PopoverTrigger>
                <PopoverContent class="w-auto p-0">
                  <CalendarCustom v-model="paid_at" />
                </PopoverContent>
              </Popover>

              <InputError :message="form.errors.paid_at" />
            </div>
          </div>

          <div class="grid gap-2">
            <Label for="comments">Comments</Label>
            <Textarea id="comments" v-model="form.comments"></Textarea>
            <InputError :message="form.errors.comments" />
          </div>

          <DialogFooter class="gap-2">
            <DialogClose as-child>
              <Button variant="secondary" @click="closeModal()"> Cancel </Button>
            </DialogClose>
            <Button type="submit"> Save changes </Button>
          </DialogFooter>
        </template>
        <template v-else>
          <Empty>
            <EmptyHeader>
              <EmptyMedia variant="icon">
                <User />
              </EmptyMedia>
              <EmptyTitle>No enrollment</EmptyTitle>
              <EmptyDescription>
                No enrollment selected. You must select a student to create a payment.
              </EmptyDescription>
            </EmptyHeader>
            <EmptyContent>
              <Button type="button" variant="outline" @click="fetchStudents">Select student</Button>
            </EmptyContent>
          </Empty>

          <DialogFooter class="gap-2">
            <DialogClose as-child>
              <Button variant="secondary" type="button" @click="closeModal()"> Close </Button>
            </DialogClose>
          </DialogFooter>
        </template>

        <ListModal v-model:open="openStudentList" :all-students="allStudents ?? []" :selected-students="[]"
          @send-selected-row="addStudents" />

        <Dialog :open="openStudentEnrollments">
          <DialogContent>
            <DialogHeader>
              <DialogTitle>Enrollments</DialogTitle>
              <DialogDescription>Select the enrollment for the student's payment</DialogDescription>
            </DialogHeader>

            <Card v-for="enrollment in studentEnrollments" :key="enrollment.id"
              class="cursor-pointer hover:border-accent-foreground" @click="selectEnrollment(enrollment)">
              <CardContent class="flex justify-between">
                <div>
                  <h2 class="text-sm font-semibold">{{ studentSelected?.full_name }}</h2>
                  <p class="text-xs text-gray-500">{{ enrollment.course?.title }}</p>
                </div>
                <div>
                  <h2 class="text-sm font-semibold">Credits</h2>
                  <p class="text-xs text-gray-500">{{ enrollment.credits }}</p>
                </div>
              </CardContent>
            </Card>

            <DialogFooter class="gap-2">
              <DialogClose as-child>
                <Button type="button" variant="secondary" @click="openStudentEnrollments = false"> Close </Button>
              </DialogClose>
            </DialogFooter>
          </DialogContent>
        </Dialog>
      </form>
    </DialogContent>
  </Dialog>
</template>