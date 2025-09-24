import { h } from 'vue';
import { Teacher } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import { Badge } from '@/components/ui/badge';
import DataTableDropdown from '@/components/teachers/DataTableDropdown.vue';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { formatDate } from '@vueuse/core';

export const columns: ColumnDef<Teacher>[] = [
  {
    accessorKey: 'id',
    header: 'ID',
    cell: ({ row }) => h('div', { class: 'w-20' }, row.getValue('id')),
    enableHiding: false,
    enableGlobalFilter: false,
  },
  {
    accessorKey: 'user.full_name',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Name' }),
    cell: ({ row }) => h('div', row.getValue('user_full_name')),
    enableHiding: false,
  },
  {
    accessorKey: 'user.email',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Email' }),
    cell: ({ row }) => h('div', row.getValue('user_email')),
    enableHiding: false,
  },
  {
    id: 'register date',
    accessorKey: 'created_at',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Register date' }),
    cell: ({ row }) => h('div', formatDate(new Date(row.getValue('register date')), 'DD/MM/YYYY')),
  },
  {
    id: 'status',
    accessorKey: 'user.status.label',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Status' }),
    cell: ({ row }) => {
      return h('div', h(Badge, { class: `bg-${row.original.user.status.color}-500` }, () => row.getValue('status')));
    },
    filterFn: (row, id, value) => {
      return value.includes(row.getValue(id))
    },
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { teacher: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];