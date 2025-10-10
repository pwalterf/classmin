import { h } from 'vue';
import { CreditTransaction } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { useDateFormatter } from '@/composables/useDateFormatter';
import { Badge } from '@/components/ui/badge';

const { df } = useDateFormatter();

export const columns: ColumnDef<CreditTransaction>[] = [
  {
    id: 'transacted date',
    accessorKey: 'transacted_at',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Transacted Date' }),
    cell: ({ row }) => h('div', df.format(new Date(row.getValue('transacted date')))),
    enableHiding: false,
  },
  {
    id: 'type',
    accessorKey: 'type.label',
    header: 'Type',
    cell: ({ row }) => {
      return h('div', h(Badge, { class: `bg-${row.original.type.color}-500` }, () => row.getValue('type')));
    },
    filterFn: (row, id, value) => {
      return value.includes(row.getValue(id))
    },
  },
  {
    accessorKey: 'credits',
    header: 'Credits',
    cell: ({ row }) => h('div', row.getValue('credits')),
  },
  {
    accessorKey: 'balance',
    header: 'Balance',
    cell: ({ row }) => h('div', row.getValue('balance')),
  },
];