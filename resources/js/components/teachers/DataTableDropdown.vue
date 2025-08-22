<script setup lang="ts">
import { MoreHorizontal } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Teacher } from '@/types';
import { ref } from 'vue';
import FormModal from './FormModal.vue';

interface Props {
  teacher: Teacher;
};

defineProps<Props>();

const showModal = ref(false);
</script>

<template>

  <DropdownMenu>
    <DropdownMenuTrigger as-child>
      <Button variant="ghost" class="w-8 h-8 p-0">
        <span class="sr-only">Open menu</span>
        <MoreHorizontal class="w-4 h-4" />
      </Button>
    </DropdownMenuTrigger>
    <DropdownMenuContent align="end">
      <DropdownMenuLabel>Actions</DropdownMenuLabel>
      <DropdownMenuItem>View teacher</DropdownMenuItem>
      <DropdownMenuItem @select="showModal = true">
        Edit teacher data
      </DropdownMenuItem>
    </DropdownMenuContent>
  </DropdownMenu>

  <FormModal v-model:open="showModal" title="Edit teacher data"
    description="Make changes to the teacher profile here. Click save when you're done." :teacher="teacher" />

</template>