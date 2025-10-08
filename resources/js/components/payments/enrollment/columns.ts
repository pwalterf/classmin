import { h } from 'vue';
import { Payment } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableDropdown from '@/components/payments/DataTableDropdown.vue';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { useDateFormatter } from '@/composables/useDateFormatter';

const { df } = useDateFormatter();

export const columns: ColumnDef<Payment>[] = [
  {
    id: 'paid date',
    accessorKey: 'paid_at',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Paid Date' }),
    cell: ({ row }) => h('div', df.format(new Date(row.getValue('paid date')))),
    enableHiding: false,
  },
  {
    accessorKey: 'amount',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Amount' }),
    cell: ({ row }) => h('div', row.getValue('amount')),
    enableHiding: false,
  },
  {
    id: 'credits purchased',
    accessorKey: 'credits_purchased',
    header: 'Credits',
    cell: ({ row }) => h('div', row.getValue('credits purchased')),
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { payment: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];