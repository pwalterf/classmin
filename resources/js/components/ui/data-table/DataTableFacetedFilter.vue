<script setup lang="ts" generic="TData">
import { type Column } from '@tanstack/vue-table';
import { computed } from 'vue';

import { Badge } from '@/components/ui/badge'
import { Button } from '@/components/ui/button'

import { Command, CommandEmpty, CommandGroup, CommandInput, CommandItem, CommandList, CommandSeparator } from '@/components/ui/command';
import {
  Popover,
  PopoverContent,
  PopoverTrigger,
} from '@/components/ui/popover'
import { Separator } from '@/components/ui/separator'
import { Check, CirclePlus } from 'lucide-vue-next';
import { cn } from '@/lib/utils';
import { Enum } from '@/types';

interface Props {
  column?: Column<TData, any>
  title?: string
  options: Array<Enum>
}

const props = defineProps<Props>()

const facets = computed(() => props.column?.getFacetedUniqueValues())
const selectedValues = computed(() => new Set(props.column?.getFilterValue() as string[]))
</script>

<template>
  <Popover>
    <PopoverTrigger as-child>
      <Button variant="outline" size="sm" class="h-8 border-dashed">
        <CirclePlus class="mr-2 h-4 w-4" />
        {{ title }}
        <template v-if="selectedValues.size > 0">
          <Separator orientation="vertical" class="mx-2 h-4" />
          <Badge variant="secondary" class="rounded-sm px-1 font-normal lg:hidden">
            {{ selectedValues.size }}
          </Badge>
          <div class="hidden space-x-1 lg:flex">
            <Badge v-if="selectedValues.size > 2" variant="secondary" class="rounded-sm px-1 font-normal">
              {{ selectedValues.size }} selected
            </Badge>

            <template v-else>
              <Badge v-for="facet in selectedValues.values()" :key="facet" variant="secondary"
                class="rounded-sm px-1 font-normal">
                {{ facet }}
              </Badge>
            </template>
          </div>
        </template>
      </Button>
    </PopoverTrigger>
    <PopoverContent class="w-[200px] p-0" align="start">
      <Command>
        <CommandInput :placeholder="title" />
        <CommandList>
          <CommandEmpty>No results found.</CommandEmpty>
          <CommandGroup>
            <CommandItem v-for="option in options" :key="option.value" :value="option.label" @select="() => {
              const isSelected = selectedValues.has(option.label)
              if (isSelected) {
                selectedValues.delete(option.label)
              }
              else {
                selectedValues.add(option.label)
              }
              const filterValues = Array.from(selectedValues)
              column?.setFilterValue(
                filterValues.length ? filterValues : undefined,
              )
            }">
              <div :class="cn(
                'mr-2 flex h-4 w-4 items-center justify-center rounded-sm border border-primary',
                selectedValues.has(option.label)
                  ? 'bg-primary text-primary-foreground'
                  : 'opacity-50 [&_svg]:invisible',
              )">
                <Check :class="cn('h-4 w-4')" />
              </div>
              <span>{{ option.label }}</span>
              <span v-if="facets?.get(option.label)"
                class="ml-auto flex h-4 w-4 items-center justify-center font-mono text-xs">
                {{ facets.get(option.label) }}
              </span>
            </CommandItem>
          </CommandGroup>

          <template v-if="selectedValues.size > 0">
            <CommandSeparator />
            <CommandGroup>
              <CommandItem :value="{ label: 'Clear filters' }" class="justify-center text-center"
                @select="column?.setFilterValue(undefined)">
                Clear filters
              </CommandItem>
            </CommandGroup>
          </template>
        </CommandList>
      </Command>
    </PopoverContent>
  </Popover>
</template>