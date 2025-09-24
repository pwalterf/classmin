<script setup lang="ts">
import { useDateFormatter } from '@/composables/useDateFormatter';
import { DateValue } from '@internationalized/date';
import { toDate } from 'reka-ui/date';

const props = withDefaults(defineProps<{
  placeholder?: string;
  value?: DateValue | string | undefined;
}>(), {
  placeholder: 'Pick a date',
});

const { df } = useDateFormatter();
</script>

<template>
  <span>
    {{ value !== undefined
      ? typeof value === 'string'
        ? value
        : df.format(toDate(value))
      : placeholder }}
  </span>
</template>