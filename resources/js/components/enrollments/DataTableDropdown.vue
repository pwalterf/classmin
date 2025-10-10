<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Enrollment } from '@/types';
import { ref } from 'vue';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '../ui/alert-dialog';
import { toast } from 'vue-sonner';
import FormModal from './FormModal.vue';
import PaymentHistory from '../payments/enrollment/HistoryModal.vue';
import CreditHistory from '../credit-transactions/enrollment/HistoryModal.vue';

interface Props {
  enrollment: Enrollment;
};

const props = defineProps<Props>();

const openEnrollmentForm = ref(false);
const openPayments = ref(false);
const openCredits = ref(false);
const openDeleteEnrollment = ref(false);

const deleteSubmit = () => {
  router.delete(route('enrollments.destroy', props.enrollment), {
    onSuccess: () => {
      toast.success('Enrollment deleted successfully', {
        description: 'The enrollment has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting enrollment', {
        description: 'There was an error deleting the enrollment.',
      });
    },
    onFinish: () => {
      openDeleteEnrollment.value = false;
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
      <DropdownMenuItem @select="openEnrollmentForm = true">
        Edit enrollment
      </DropdownMenuItem>
      <DropdownMenuItem @select="openPayments = true">
        Payments
      </DropdownMenuItem>
      <DropdownMenuItem @select="openCredits = true">
        Credits history
      </DropdownMenuItem>
      <DropdownMenuSeparator />
      <DropdownMenuItem class="text-red-600" @select="openDeleteEnrollment = true">
        Delete enrollment
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <FormModal v-model:open="openEnrollmentForm" title="Edit enrollment data"
    description="Make changes to the enrollment data here. Click save when you're done." :enrollment="enrollment"
    :student="enrollment.student" />

  <PaymentHistory v-model:open="openPayments" title="Payment History"
    description="View the payment history for this enrollment" :enrollment="enrollment" />

  <CreditHistory v-model:open="openCredits" title="Credit History"
    description="View the credit history for this enrollment" :enrollment="enrollment" />

  <AlertDialog v-model:open="openDeleteEnrollment">
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
        <AlertDialogDescription>
          This action cannot be undone. This enrollment will no longer be
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