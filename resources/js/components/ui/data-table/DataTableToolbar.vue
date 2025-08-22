<script setup lang="ts" generic="TData">
import { type Table } from '@tanstack/vue-table';
import { computed } from 'vue';

import DataTableFacetedFilter from '@/components/ui/data-table/DataTableFacetedFilter.vue'

import {
  DropdownMenu,
  DropdownMenuCheckboxItem,
  DropdownMenuContent,
  DropdownMenuLabel,
  DropdownMenuSeparator,
  DropdownMenuTrigger,
} from '@/components/ui/dropdown-menu';

import { Input } from '@/components/ui/input';
import { Settings2, X } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Facet } from '@/types';

interface Props {
  table: Table<TData>
  facets?: Facet[]
};

const props = defineProps<Props>();

const isFiltered = computed(() => props.table.getState().columnFilters.length > 0);
</script>

<template>
  <div class="flex items-center justify-between">
    <div class="flex flex-1 items-center space-x-2">
      <Input id="filter" placeholder="Filter..." :model-value="(table.getState().globalFilter as string) ?? ''"
        class="h-8 w-[150px] lg:w-[250px]" @input="table.setGlobalFilter($event.target.value)" />
      <template v-for="facet in facets">
        <DataTableFacetedFilter v-if="table.getColumn(facet.value)" :column="table.getColumn(facet.value)"
          :title="facet.label" :options="facet.options" />
      </template>

      <Button v-if="isFiltered" variant="ghost" class="h-8 px-2 lg:px-3" @click="table.resetColumnFilters()">
        Reset
        <X class="ml-2 h-4 w-4" />
      </Button>
    </div>

    <DropdownMenu>
      <DropdownMenuTrigger as-child>
        <Button variant="outline" class="ml-auto">
          View
          <Settings2 class="w-4 h-4 ml-2" />
        </Button>
      </DropdownMenuTrigger>
      <DropdownMenuContent align="end">
        <DropdownMenuLabel>Toggle columns</DropdownMenuLabel>
        <DropdownMenuSeparator />
        <DropdownMenuCheckboxItem v-for="column in table.getAllColumns().filter((column) => column.getCanHide())"
          :key="column.id" class="capitalize" :modelValue="column.getIsVisible()" @update:modelValue="(value) => {
            column.toggleVisibility(!!value)
          }">
          {{ column.id }}
        </DropdownMenuCheckboxItem>
      </DropdownMenuContent>
    </DropdownMenu>
  </div>
</template>