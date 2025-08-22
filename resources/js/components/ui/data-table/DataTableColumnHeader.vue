<script setup lang="ts" generic="TData">
import { Column } from '@tanstack/vue-table';
import { Button } from '@/components/ui/button';
import { ArrowDownWideNarrow, ArrowUpDown, ArrowUpNarrowWide } from 'lucide-vue-next';

interface Props {
  column: Column<TData, any>;
  title: string;
};

defineProps<Props>();
</script>

<template>
  <div>
    <Button variant="ghost" @click="column.toggleSorting()">
      <span>{{ title }}</span>
      <ArrowUpNarrowWide v-if="column.getIsSorted() === 'asc'" class="ml-2 h-4 w-4" />
      <ArrowDownWideNarrow v-else-if="column.getIsSorted() === 'desc'" class="ml-2 h-4 w-4" />
      <ArrowUpDown v-else class="ml-2 h-4 w-4" />
    </Button>
  </div>
</template>