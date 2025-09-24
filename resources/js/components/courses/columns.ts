import { h } from 'vue';
import { Course } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { Badge } from '@/components/ui/badge';
import DataTableDropdown from '@/components/courses/DataTableDropdown.vue';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { useDateFormatter } from '@/composables/useDateFormatter';

const { df } = useDateFormatter();

export const columns: ColumnDef<Course>[] = [
  {
    accessorKey: 'id',
    header: 'ID',
    cell: ({ row }) => h('div', { class: 'w-20' }, row.getValue('id')),
    enableHiding: false,
    enableGlobalFilter: false,
  },
  {
    accessorKey: 'title',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Title' }),
    cell: ({ row }) => h('div', row.getValue('title')),
    enableHiding: false,
  },
  {
    id: 'started date',
    accessorKey: 'started_at',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Started date' }),
    cell: ({ row }) => h('div', df.format(new Date(row.getValue('started date')))),
  },
  {
    id: 'status',
    accessorKey: 'status.label',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Status' }),
    cell: ({ row }) => {
      return h('div', h(Badge, { class: `bg-${row.original.status.color}-500` }, () => row.getValue('status')));
    },
    filterFn: (row, id, value) => {
      return value.includes(row.getValue(id))
    },
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { course: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];