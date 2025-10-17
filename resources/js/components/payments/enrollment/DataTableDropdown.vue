<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Payment } from '@/types';
import { ref } from 'vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';
import { toast } from 'vue-sonner';
import FormModal from './FormModal.vue';

interface Props {
  payment: Payment;
};

const props = defineProps<Props>();

const openPaymentForm = ref(false);
const showDeleteModal = ref(false);

const deleteSubmit = () => {
  router.delete(route('payments.destroy', props.payment), {
    onSuccess: () => {
      toast.success('Payment deleted successfully', {
        description: 'The payment has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting payment', {
        description: 'There was an error deleting the payment.',
      });
    },
    onFinish: () => {
      showDeleteModal.value = false;
    },
  });
};
</script>

<template>

  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <DropdownMenuItem @select="openPaymentForm = true">
        Edit payment
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-red-600" @select="showDeleteModal = true">
        Delete payment
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <FormModal v-model:open="openPaymentForm" title="Edit Payment" description="Edit payment for the enrollment"
    :payment="payment" />

  <AlertDialog v-model:open="showDeleteModal">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This payment will no longer be
          accessible by you or others you've shared it with.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel>Cancel</AlertDialogCancel>
        <Button variant="destructive" @click="deleteSubmit">
          Delete
        </Button>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>

</template>