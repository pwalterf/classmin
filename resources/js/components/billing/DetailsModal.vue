<script setup lang="ts">
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Button } from '@/components/ui/button';
import { useClipboard } from '@vueuse/core';
import { Item, ItemActions, ItemContent, ItemDescription, ItemTitle } from '@/components/ui/item';
import { useTemplateRef } from 'vue';
import { Check, Copy } from 'lucide-vue-next';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  enrollment: {
    student: string;
    course: string;
    total_amount: number;
    total_credits_purchased: number;
  };
};

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const { copy, copied } = useClipboard();
const message = useTemplateRef('description');

const closeModal = () => {
  emit('update:open', false);
};
</script>

<template>
  <Dialog :open="props.open" @update:open="closeModal">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <DialogDescription v-if="description">{{ description }}</DialogDescription>
      </DialogHeader>

      <Item variant="outline">
        <ItemContent>
          <ItemTitle>Description</ItemTitle>
          <ItemDescription ref="description">
            {{ 'Clases correspondientes a ' + props.enrollment.student +
              ', con un monto total de $' + props.enrollment.total_amount + ' y un total de ' +
              props.enrollment.total_credits_purchased
              + ' clases' + '.' }}
          </ItemDescription>
        </ItemContent>
        <ItemActions>
          <Button variant="outline" size="sm" @click="copy(message?.$el.innerText)">
            <Copy v-if="!copied" />
            <Check v-else />
          </Button>
        </ItemActions>
      </Item>

      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal()"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>
  </Dialog>
</template>