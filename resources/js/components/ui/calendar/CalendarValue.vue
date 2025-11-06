<script setup lang="ts">
import { useDateFormatter } from '@/composables/useDateFormatter';
import { CalendarDate, DateValue } from '@internationalized/date';
import { toDate } from 'reka-ui/date';

const props = withDefaults(defineProps<{
  placeholder?: string;
  value?: CalendarDate | undefined;
}>(), {
  placeholder: 'Pick a date',
});

const { df } = useDateFormatter();
</script>

<template>
  <span>
    {{ value
      ? df.format(toDate(value))
      : placeholder }}
  </span>
</template>