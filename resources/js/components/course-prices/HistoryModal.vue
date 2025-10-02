<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
import { Dialog, DialogClose, DialogContent, DialogDescription, DialogFooter, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import { Course, CoursePrice } from '@/types';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { MoreHorizontal } from 'lucide-vue-next';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';
import CoursePriceForm from '@/components/course-prices/FormModal.vue';
import { ref } from 'vue';
import { toast } from 'vue-sonner';
import { useDateFormatter } from '@/composables/useDateFormatter';

interface Props {
  open?: boolean;
  title: string;
  description: string;
  course: Course;
}

const props = defineProps<Props>();
const emit = defineEmits(['update:open']);

const { df } = useDateFormatter();

const selectedPrice = ref<CoursePrice>();
const openPrice = ref(false);
const openDeletePrice = ref(false);

const openPriceForm = (coursePrice: CoursePrice) => {
  selectedPrice.value = coursePrice;
  openPrice.value = true;
};
const openDeleteForm = (coursePrice: CoursePrice) => {
  selectedPrice.value = coursePrice;
  openDeletePrice.value = true;
};

const closeModal = () => {
  emit('update:open', false);
};

const deletePrice = () => {
  router.delete(route('coursePrices.destroy', selectedPrice.value), {
    onSuccess: () => {
      toast.success('Course price deleted successfully', {
        description: 'The course price has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting course price', {
        description: 'There was an error deleting the course price.',
      });
    },
    onFinish: () => {
      openDeletePrice.value = false;
    },
  });
};
</script>

<template>
  <Dialog :open="props.open" @update:open="closeModal">
    <DialogContent>
      <DialogHeader>
        <DialogTitle>{{ title }}</DialogTitle>
        <DialogDescription v-if="description">{{ description }}</DialogDescription>
      </DialogHeader>

      <Table>
        <TableHeader>
          <TableRow>
            <TableHead>Started date</TableHead>
            <TableHead>Ended date</TableHead>
            <TableHead>Currency</TableHead>
            <TableHead>Price</TableHead>
            <TableHead></TableHead>
          </TableRow>
        </TableHeader>
        <TableBody>
          <TableRow v-for="coursePrice in course.prices">
            <TableCell>
              {{ typeof coursePrice.started_at === 'string'
                ? df.format(new Date(coursePrice.started_at))
                : '' }}
            </TableCell>
            <TableCell>
              {{ typeof coursePrice.ended_at === 'string'
                ? df.format(new Date(coursePrice.ended_at))
                : '' }}
            </TableCell>
            <TableCell>{{ coursePrice.currency }}</TableCell>
            <TableCell>{{ coursePrice.price }}</TableCell>
            <TableCell class="text-right">
              <DropdownMenu>
                <DropdownMenuTrigger as-child>
                  <Button variant="ghost" size="sm">
                    <span class="sr-only">Open menu</span>
                    <MoreHorizontal class="w-4 h-4" />
                  </Button>
                </DropdownMenuTrigger>
                <DropdownMenuContent align="end">
                  <DropdownMenuLabel>Actions</DropdownMenuLabel>
                  <DropdownMenuItem @select="openPriceForm(coursePrice)">
                    Edit price
                  </DropdownMenuItem>
                  <DropdownMenuSeparator />
                  <DropdownMenuItem class="text-red-600" @select="openDeleteForm(coursePrice)">
                    Delete price
                  </DropdownMenuItem>
                </DropdownMenuContent>
              </DropdownMenu>
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>

      <DialogFooter class="gap-2">
        <DialogClose as-child>
          <Button variant="secondary" @click="closeModal()"> Close </Button>
        </DialogClose>
      </DialogFooter>
    </DialogContent>

    <CoursePriceForm v-if="selectedPrice?.id" v-model:open="openPrice" title="Edit Course Price"
      description="Edit the price of the course" :course="course" :course-price="selectedPrice" />

    <AlertDialog v-model:open="openDeletePrice">
      <AlertDialogContent>
        <AlertDialogHeader>
          <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
          <AlertDialogDescription>
            This action cannot be undone. This course will no longer be
            accessible by you or others you've shared it with.
          </AlertDialogDescription>
        </AlertDialogHeader>
        <AlertDialogFooter>
          <AlertDialogCancel>Cancel</AlertDialogCancel>
          <Button variant="destructive" @click="deletePrice">
            Delete
          </Button>
        </AlertDialogFooter>
      </AlertDialogContent>
    </AlertDialog>
  </Dialog>
</template>