import { h } from 'vue';
import { Student } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import DataTableDropdown from './DataTableDropdown.vue';

export const columns: ColumnDef<Student>[] = [
  {
    accessorKey: 'full_name',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Name' }),
    cell: ({ row }) => h('div', row.getValue('full_name')),
    enableHiding: false,
  },
  {
    accessorKey: 'email',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Email' }),
    cell: ({ row }) => h('div', row.getValue('email')),
    enableHiding: false,
  },
  {
    id: 'phone number',
    accessorKey: 'phone_number',
    header: 'Phone',
    cell: ({ row }) => h('div', row.getValue('phone number')),
    enableHiding: true,
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { student: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];