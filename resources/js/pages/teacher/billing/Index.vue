<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { Payment, type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
import axios from 'axios';

import { use } from 'echarts/core';
import { BarChart } from 'echarts/charts';
import { TooltipComponent, GridComponent } from 'echarts/components';
import { CanvasRenderer } from 'echarts/renderers';
import type { ComposeOption } from 'echarts/core';
import type { BarSeriesOption } from 'echarts/charts';
import type {
  TooltipComponentOption,
  GridComponentOption
} from 'echarts/components';
import { ref } from 'vue';
import VChart from "vue-echarts";
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { MoreHorizontal } from 'lucide-vue-next';
import PaymentsModal from '@/components/billing/PaymentsModal.vue';

use([TooltipComponent, GridComponent, BarChart, CanvasRenderer]);

type EChartsOption = ComposeOption<
  | TooltipComponentOption
  | GridComponentOption
  | BarSeriesOption
>;

interface Props {
  billingMonths: {
    date: string;
    amount: number;
  }[];
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Billing',
    href: '/teacher/billing',
  },
];

const data = ref<EChartsOption>({
  tooltip: {
    trigger: 'axis',
    axisPointer: {
      type: 'shadow'
    }
  },
  grid: {
    left: '10%',
    right: '3%',
    bottom: '3%',
    top: '3%',
  },
  xAxis: [
    {
      type: 'category',
      data: props.billingMonths.map(payment => payment.date),
      axisTick: {
        alignWithLabel: true
      }
    }
  ],
  yAxis: [
    {
      type: 'value',
      axisLabel: {
        formatter: '$ {value}',
      },
    }
  ],
  series: [
    {
      name: 'Payments',
      type: 'bar',
      barWidth: '60%',
      data: props.billingMonths.map(payment => payment.amount)
    }
  ]
});

const openPayments = ref(false);
const monthlyPayments = ref<Payment[]>([]);
const dateSelected = ref('');

const openPaymentsModal = async (date: string) => {
  if (dateSelected.value === date) {
    openPayments.value = true;
    return;
  }

  dateSelected.value = date;
  const response = await axios.get(`/teacher/billing/monthly-payments/${date}`);
  monthlyPayments.value = response.data;
  openPayments.value = true;
};

</script>

<template>

  <Head title="Billing" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
      <Heading title="Billing" description="A list of payments made to your courses"></Heading>

      <div class="grid auto-rows-min gap-4 grid-cols-1 xl:grid-cols-2">
        <Card>
          <CardHeader>
            <CardTitle>Income per Month</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="h-[400px] w-full">
              <VChart :option="data" :autoresize="true" />
            </div>
          </CardContent>
        </Card>
        <Card>
          <CardHeader>
            <CardTitle>Monthly Billing</CardTitle>
          </CardHeader>
          <CardContent>
            <div class="border rounded-lg">
              <Table>
                <TableHeader>
                  <TableRow>
                    <TableHead>Date</TableHead>
                    <TableHead>Amount</TableHead>
                    <TableHead></TableHead>
                  </TableRow>
                </TableHeader>
                <TableBody>
                  <template v-if="billingMonths.length === 0">
                    <TableRow>
                      <TableCell colspan="3" class="text-center py-4">
                        No payments found.
                      </TableCell>
                    </TableRow>
                  </template>
                  <TableRow v-for="billing in billingMonths" :key="billing.date">
                    <TableCell>{{ billing.date }}</TableCell>
                    <TableCell>$ {{ billing.amount }}</TableCell>
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
                          <DropdownMenuItem @click="openPaymentsModal(billing.date)">
                            Show payments
                          </DropdownMenuItem>
                          <Link :href="route('teacher.billing.arca-report', billing.date)">
                          <DropdownMenuItem>
                            ARCA report
                          </DropdownMenuItem>
                          </Link>
                        </DropdownMenuContent>
                      </DropdownMenu>
                    </TableCell>
                  </TableRow>
                </TableBody>
              </Table>
            </div>
          </CardContent>
        </Card>
      </div>

      <PaymentsModal class="w-full" v-model:open="openPayments" title="Monthly Payments"
        description="List of payments made in the selected month" :payments="monthlyPayments" />
    </div>
  </AppLayout>
</template>
