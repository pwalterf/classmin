<script setup lang="ts">
import { Enrollment, Payment } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Textarea } from '@/components/ui/textarea';
import { useForm } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
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
  payment?: Payment;
  enrollment?: Enrollment;
};

interface PaymentForm {
  amount: number;
  currency: string;
  credits_purchased: number;
  paid_at: DateValue | string | undefined;
  comments?: string;
  enrollment_id?: number;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const form = useForm<PaymentForm>({
  amount: props.payment?.amount || 0.00,
  currency: props.payment?.currency || 'ARS',
  credits_purchased: props.payment?.credits_purchased || 0,
  paid_at: typeof props.payment?.paid_at === 'string'
    ? toCalendarDate(parseAbsoluteToLocal(props.payment.paid_at))
    : props.payment?.paid_at
    || undefined,
  comments: props.payment?.comments || '',
  enrollment_id: props.enrollment?.id || undefined,
}).transform((data) => ({
  ...data,
  paid_at: data.paid_at ? data.paid_at.toString() : null,
}));

const submitForm = () => {
  if (props.payment) {
    form.patch(route('payments.update', props.payment), {
      preserveState: 'errors',
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
      preserveState: 'errors',
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
                  <CalendarValue :value="form.paid_at" />
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <CalendarSelects v-model="form.paid_at as DateValue" />
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
      </form>
    </DialogContent>
  </Dialog>
</template>