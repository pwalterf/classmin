<script setup lang="ts">
import { Enum, Teacher } from '@/types';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Label } from '@/components/ui/label';
import { Input } from '@/components/ui/input';
import InputError from '@/components/InputError.vue';
import { Select, SelectContent, SelectGroup, SelectItem, SelectTrigger, SelectValue } from '@/components/ui/select';
import { Button } from '@/components/ui/button';
import { useForm, usePage } from '@inertiajs/vue3';
import { toast } from 'vue-sonner';
import { computed } from 'vue';

interface Props {
  open: boolean;
  title: string;
  description?: string;
  teacher?: Teacher;
};

const props = defineProps<Props>();

const emit = defineEmits(['update:open']);

const userStatuses = computed(() => (usePage().props.statuses as Enum[]));

const form = useForm({
  first_name: props.teacher?.user.first_name || '',
  last_name: props.teacher?.user.last_name || '',
  email: props.teacher?.user.email || '',
  status: props.teacher?.user.status.value || '',
  user_id: props.teacher?.user.id || '',
});

const submitForm = () => {
  if (props.teacher) {
    form.patch(route('teachers.update', props.teacher), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Teacher updated successfully', {
          description: 'The teacher profile has been updated.',
        });
      },
      onError: () => {
        toast.error('Error updating teacher', {
          description: 'There was an error updating the teacher profile.',
        });
      },
    });
  } else {
    form.post(route('teachers.store'), {
      preserveState: 'errors',
      onSuccess: () => {
        closeModal();
        toast.success('Teacher created successfully', {
          description: 'The teacher profile has been created.',
        });
      },
      onError: () => {
        toast.error('Error creating teacher', {
          description: 'There was an error creating the teacher profile.',
        });
      },
    });
  }
};

const closeModal = () => {
  emit('update:open', false);
  form.clearErrors();
  form.reset();
};
</script>

<template>
  <Dialog :open="open" @update:open="closeModal">
    <DialogContent>
      <form @submit.prevent="submitForm" class="space-y-6">
        <DialogHeader>
          <DialogTitle>{{ title }}</DialogTitle>
          <DialogDescription v-if="description">{{ description }}</DialogDescription>
        </DialogHeader>

        <div class="grid gap-2">
          <Label for="first_name">First Name</Label>
          <Input id="first_name" type="text" v-model="form.first_name" />
          <InputError :message="form.errors.first_name" />
        </div>

        <div class="grid gap-2">
          <Label for="last_name">Last Name</Label>
          <Input id="last_name" type="text" v-model="form.last_name" />
          <InputError :message="form.errors.last_name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">Email</Label>
          <Input id="email" type="email" v-model="form.email" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="status">Status</Label>
          <Select v-model="form.status">
            <SelectTrigger id="status" class="w-full">
              <SelectValue placeholder="Select a status" />
            </SelectTrigger>
            <SelectContent>
              <SelectGroup>
                <SelectItem v-for="status in userStatuses" :key="status.value" :value="status.value">
                  {{ status.label }}
                </SelectItem>
              </SelectGroup>
            </SelectContent>
          </Select>
          <InputError :message="form.errors.status" />
        </div>

        <DialogFooter class="gap-2">
          <DialogClose as-child>
            <Button variant="secondary" @click="closeModal()"> Cancel </Button>
          </DialogClose>
          <Button type="submit"> Save changes </Button>
        </DialogFooter>
      </form>
    </DialogContent>
  </Dialog>
</template>