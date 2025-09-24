import { h } from 'vue';
import { Student } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { Button } from '@/components/ui/button';
import { UserRoundPlus } from 'lucide-vue-next';

declare module '@tanstack/vue-table' {
  interface TableMeta<TData> {
    sendSelectedRow: (row: TData) => void;
  }
}

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
    id: 'actions',
    cell: ({ row, table }) =>
      h(Button,
        {
          variant: 'ghost',
          size: 'sm',
          student: row.original,
          onClick: () => table.options.meta?.sendSelectedRow(row.original),
        },
        () => h(UserRoundPlus, { class: 'h-4 w-4' })
      ),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];