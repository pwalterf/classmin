import { h } from 'vue';
import { Enrollment } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import Badge from '@/components/ui/badge/Badge.vue';
import DataTableDropdown from '@/components/enrollments/DataTableDropdown.vue';

declare module '@tanstack/vue-table' {
  interface TableMeta<TData> {
    sendSelectedRow: (row: TData) => void;
  }
}

export const columns: ColumnDef<Enrollment>[] = [
  {
    accessorKey: 'student.full_name',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Name' }),
    cell: ({ row }) => h('div', row.getValue('student_full_name')),
    enableHiding: false,
  },
  {
    accessorKey: 'student.email',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Email', class: 'hidden lg:table-cell' }),
    cell: ({ row }) => h('div', { class: 'hidden lg:table-cell' }, row.getValue('student_email')),
    enableHiding: false,
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
    accessorKey: 'credits',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Credits' }),
    cell: ({ row }) => h('div', row.getValue('credits')),
    enableHiding: true,
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { enrollment: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];