<script setup lang="ts" generic="TData">
import { ref } from 'vue';
import { valueUpdater } from '@/lib/utils';
import { Facet } from '@/types';
import { type ColumnDef, SortingState, VisibilityState } from '@tanstack/vue-table';
import {
  FlexRender,
  getCoreRowModel,
  getPaginationRowModel,
  getFilteredRowModel,
  getSortedRowModel,
  getFacetedRowModel,
  getFacetedUniqueValues,
  useVueTable,
} from '@tanstack/vue-table';

import {
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from '@/components/ui/table';

import DataTableToolbar from './DataTableToolbar.vue';
import DataTablePagination from './DataTablePagination.vue';

interface Props {
  columns: ColumnDef<TData, any>[];
  data: TData[];
  facets?: Facet[];
  options?: {
    filter?: boolean;
    settings?: boolean;
    actionButton?: string;
    rowsPerPage?: boolean;
  }
};

const props = defineProps<Props>();
const emit = defineEmits<{
  (e: 'send-selected-row', row: TData): void;
  (e: 'action-button-click'): void;
}>();

const sorting = ref<SortingState>([]);
const globalFilter = ref<string>('');
const columnVisibility = ref<VisibilityState>({});

const table = useVueTable({
  get data() { return props.data },
  get columns() { return props.columns },
  getCoreRowModel: getCoreRowModel(),
  getPaginationRowModel: getPaginationRowModel(),
  getSortedRowModel: getSortedRowModel(),
  getFilteredRowModel: getFilteredRowModel(),
  getFacetedRowModel: getFacetedRowModel(),
  getFacetedUniqueValues: getFacetedUniqueValues(),
  onSortingChange: updaterOrValue => valueUpdater(updaterOrValue, sorting),
  onGlobalFilterChange: updaterOrValue => valueUpdater(updaterOrValue, globalFilter),
  onColumnVisibilityChange: updaterOrValue => valueUpdater(updaterOrValue, columnVisibility),
  state: {
    get sorting() { return sorting.value },
    get globalFilter() { return globalFilter.value },
    get columnVisibility() { return columnVisibility.value },
  },
  meta: {
    sendSelectedRow: (row: TData) => {
      emit('send-selected-row', row);
    },
  },
});
</script>

<template>
  <div>
    <div class="space-y-4">
      <DataTableToolbar :table="table" :facets="facets" :filter="options?.filter" :settings="options?.settings"
        :action-button="options?.actionButton" @action-button-click="emit('action-button-click')" />
      <div class="border rounded-md">
        <Table>
          <TableHeader>
            <TableRow v-for="headerGroup in table.getHeaderGroups()" :key="headerGroup.id">
              <TableHead v-for="header in headerGroup.headers" :key="header.id">
                <FlexRender v-if="!header.isPlaceholder" :render="header.column.columnDef.header"
                  :props="header.getContext()" />
              </TableHead>
            </TableRow>
          </TableHeader>
          <TableBody>
            <template v-if="table.getRowModel().rows?.length">
              <TableRow v-for="row in table.getRowModel().rows" :key="row.id"
                :data-state="row.getIsSelected() ? 'selected' : undefined">
                <TableCell v-for="cell in row.getVisibleCells()" :key="cell.id">
                  <FlexRender :render="cell.column.columnDef.cell" :props="cell.getContext()" />
                </TableCell>
              </TableRow>
            </template>
            <template v-else>
              <TableRow>
                <TableCell :colspan="columns.length" class="h-24 text-center">
                  No results.
                </TableCell>
              </TableRow>
            </template>
          </TableBody>
        </Table>
      </div>

      <DataTablePagination :table="table" :rows-per-page="options?.rowsPerPage" />
    </div>
  </div>
</template>