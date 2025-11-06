<script lang="ts" setup>
import type { CalendarRootEmits, CalendarRootProps, DateValue } from "reka-ui"
import type { HTMLAttributes, Ref } from "vue"
import { reactiveOmit, useVModel } from "@vueuse/core"
import { CalendarRoot, useDateFormatter, useForwardPropsEmits } from "reka-ui"
import { cn } from "@/lib/utils"
import { CalendarCell, CalendarCellTrigger, CalendarGrid, CalendarGridBody, CalendarGridHead, CalendarGridRow, CalendarHeadCell, CalendarHeader, CalendarHeading, CalendarNextButton, CalendarPrevButton } from "."
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "../select"
import { createDecade, createYear, toDate } from "reka-ui/date"
import { getLocalTimeZone, today } from "@internationalized/date"

const props = defineProps<CalendarRootProps & { class?: HTMLAttributes["class"] }>()
const emits = defineEmits<CalendarRootEmits>()

const delegatedProps = reactiveOmit(props, "class")

const placeholder = useVModel(props, "modelValue", emits, {
  passive: true,
  defaultValue: today(getLocalTimeZone()),
}) as Ref<DateValue>

const forwarded = useForwardPropsEmits(delegatedProps, emits)

const formatter = useDateFormatter(navigator.language)
</script>

<template>
  <CalendarRoot v-slot="{ grid, weekDays, date }" data-slot="calendar" :class="cn('p-3', props.class)"
    v-bind="forwarded" @update:placeholder="">
    <CalendarHeader>
      <CalendarHeading class="flex w-full items-center justify-between gap-2">
        <Select :default-value="date.month.toString()" @update:model-value="(v) => {
          if (!v || !date) return;
          if (Number(v) === date?.month) return;
          placeholder = date.set({
            month: Number(v),
          })
        }">
          <SelectTrigger aria-label="Select month" class="w-[60%]">
            <SelectValue date="Select month" />
          </SelectTrigger>
          <SelectContent class="max-h-[200px]">
            <SelectItem v-for="month in createYear({ dateObj: date })" :key="month.toString()"
              :value="month.month.toString()">
              {{ formatter.custom(toDate(month), { month: 'long' }) }}
            </SelectItem>
          </SelectContent>
        </Select>

        <Select :default-value="date.year.toString()" @update:model-value="(v) => {
          if (!v || !date) return;
          if (Number(v) === date?.year) return;
          placeholder = date.set({
            year: Number(v),
          })
        }">
          <SelectTrigger aria-label="Select year" class="w-[40%]">
            <SelectValue date="Select year" />
          </SelectTrigger>
          <SelectContent class="max-h-[200px]">
            <SelectItem v-for="yearValue in createDecade({ dateObj: date, startIndex: -10, endIndex: 10 })"
              :key="yearValue.toString()" :value="yearValue.year.toString()">
              {{ yearValue.year }}
            </SelectItem>
          </SelectContent>
        </Select>
      </CalendarHeading>
    </CalendarHeader>

    <div class="flex flex-col gap-y-4 mt-4 sm:flex-row sm:gap-x-4 sm:gap-y-0">
      <CalendarGrid v-for="month in grid" :key="month.value.toString()">
        <CalendarGridHead>
          <CalendarGridRow>
            <CalendarHeadCell v-for="day in weekDays" :key="day">
              {{ day }}
            </CalendarHeadCell>
          </CalendarGridRow>
        </CalendarGridHead>
        <CalendarGridBody>
          <CalendarGridRow v-for="(weekDates, index) in month.rows" :key="`weekDate-${index}`" class="mt-2 w-full">
            <CalendarCell v-for="weekDate in weekDates" :key="weekDate.toString()" :date="weekDate">
              <CalendarCellTrigger :day="weekDate" :month="month.value" />
            </CalendarCell>
          </CalendarGridRow>
        </CalendarGridBody>
      </CalendarGrid>
    </div>
  </CalendarRoot>
</template>
