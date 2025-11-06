<script setup lang="ts">
import { Enrollment } from '@/types';
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
import { parseDate } from "@internationalized/date";
import { cn } from '@/lib/utils';
import CalendarCustom from '@/components/ui/calendar/CalendarCustom.vue';
import CalendarValue from '@/components/ui/calendar/CalendarValue.vue';
import { computed } from 'vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  enrollment: Enrollment;
};

interface CreditTransactionForm {
  transacted_at: string | undefined;
  type: string;
  credits: number;
  description?: string;
  enrollment_id: number;
  errors?: {
    [key: string]: string | undefined;
  };
  [key: string]: any;
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const transacted_at = computed({
  get: () => typeof form.transacted_at !== 'undefined' ? parseDate(form.transacted_at) : undefined,
  set: (val) => form.transacted_at = val?.toString(),
});

const form = useForm<CreditTransactionForm>({
  transacted_at: undefined,
  type: 'adjustment',
  credits: 0,
  description: '',
  enrollment_id: props.enrollment.id ?? 0,
}).transform((data) => ({
  ...data,
  transacted_at: data.transacted_at ?? null,
}));

const submitForm = () => {
  form.post(route('creditTransactions.store'), {
    preserveState: 'errors',
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      toast.success('Transaction created successfully', {
        description: 'The transaction has been created.',
      });
    },
    onError: () => {
      toast.error('Error creating transaction', {
        description: 'There was an error creating the transaction.',
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

        <div class="grid grid-cols-3 gap-4">
          <div class="grid col-span-2 gap-2">
            <Label for="transacted_at">Paid date</Label>
            <Popover>
              <PopoverTrigger as-child>
                <Button id="transacted_at" variant="outline" :class="cn(
                  'w-full justify-start text-left font-normal',
                  !form.transacted_at && 'text-muted-foreground',
                )">
                  <CalendarIcon class="mr-2 h-4 w-4" />
                  <CalendarValue :value="transacted_at" />
                </Button>
              </PopoverTrigger>
              <PopoverContent class="w-auto p-0">
                <CalendarCustom v-model="transacted_at" />
              </PopoverContent>
            </Popover>

            <InputError :message="form.errors.transacted_at" />
          </div>

          <div class="grid gap-2">
            <Label for="credits">Credits</Label>
            <Input id="credits" type="number" v-model="form.credits" />
            <InputError :message="form.errors.credits" />
          </div>
        </div>

        <div class="grid gap-2">
          <Label for="description">Description</Label>
          <Textarea id="description" v-model="form.description"></Textarea>
          <InputError :message="form.errors.description" />
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