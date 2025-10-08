import { h } from 'vue';
import { Lesson } from '@/types';
import { ColumnDef } from '@tanstack/vue-table';
import DataTableDropdown from '@/components/lessons/DataTableDropdown.vue';
import DataTableColumnHeader from '@/components/ui/data-table/DataTableColumnHeader.vue';
import { useDateFormatter } from '@/composables/useDateFormatter';

const { df } = useDateFormatter();

export const columns: ColumnDef<Lesson>[] = [
  {
    id: 'taught date',
    accessorKey: 'taught_at',
    header: ({ column }) => h(DataTableColumnHeader, { column: column as any, title: 'Taught Date' }),
    cell: ({ row }) => h('div', df.format(new Date(row.getValue('taught date')))),
    enableHiding: false,
  },
  {
    accessorKey: 'notes',
    header: 'Notes',
    cell: ({ row }) => h('div', row.getValue('notes')),
    enableHiding: false,
  },
  {
    id: 'student page',
    accessorKey: 'student_page',
    header: 'Student Page',
    cell: ({ row }) => h('div', row.getValue('student page')),
  },
  {
    id: 'workbook page',
    accessorKey: 'workbook_page',
    header: 'Workbook Page',
    cell: ({ row }) => h('div', row.getValue('workbook page')),
  },
  {
    id: 'actions',
    cell: ({ row }) => h('div', { class: 'relative' }, h(DataTableDropdown, { lesson: row.original })),
    enableHiding: false,
    enableGlobalFilter: false,
  },
];