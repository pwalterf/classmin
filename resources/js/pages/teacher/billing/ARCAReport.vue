<script setup lang="ts">
import DetailsModal from '@/components/billing/DetailsModal.vue';
import Heading from '@/components/Heading.vue';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { MoreHorizontal } from 'lucide-vue-next';
import { ref } from 'vue';

interface Props {
  enrollment_payments: {
    student: string;
    course: string;
    total_amount: number;
    total_credits_purchased: number;
  }[];
  date: string;
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Billing',
    href: '/teacher/billing',
  },
  {
    title: 'ARCA Report',
    href: '/teacher/billing/arca-report',
  },
];

const openDetails = ref(false);
const enrollmentSelected = ref();

const details = (index: number) => {
  enrollmentSelected.value = props.enrollment_payments[index];
  openDetails.value = true;
};
</script>

<template>

  <Head title="ARCA Report" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <Heading title="ARCA Report" description="A detailed report for ARCA billing"></Heading>

      <div class="border rounded-lg">
        <Table>
          <TableHeader>
            <TableRow>
              <TableHead>#</TableHead>
              <TableHead>Student</TableHead>
              <TableHead>Amount</TableHead>
              <TableHead>Credits Purchased</TableHead>
              <TableHead></TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <TableRow v-for="(payment, index) in enrollment_payments" :key="payment.student">
              <TableCell>{{ index + 1 }}</TableCell>
              <TableCell>
                <div class="flex flex-col space-y-1">
                  <span class="font-medium">{{ payment.student }}</span>
                  <span class="text-sm text-muted-foreground">{{ payment.course }}</span>
                </div>
              </TableCell>
              <TableCell>$ {{ payment.total_amount }}</TableCell>
              <TableCell>{{ payment.total_credits_purchased }}</TableCell>
              <TableCell class="text-center">
                <DropdownMenu>
                  <DropdownMenuTrigger as-child>
                    <Button variant="ghost" class="w-8 h-8 p-0">
                      <span class="sr-only">Open menu</span>
                      <MoreHorizontal class="w-4 h-4" />
                    </Button>
                  </DropdownMenuTrigger>
                  <DropdownMenuContent align="end">
                    <DropdownMenuLabel>Actions</DropdownMenuLabel>
                    <DropdownMenuItem @click="details(index)">
                      View details
                    </DropdownMenuItem>
                  </DropdownMenuContent>
                </DropdownMenu>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>

      <DetailsModal v-if="enrollmentSelected" v-model:open="openDetails" title="Report Details"
        description="Show detailed payment information for the selected report." :enrollment="enrollmentSelected" />
    </div>
  </AppLayout>

</template>