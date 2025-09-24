<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type Course, BreadcrumbItem, Enum, Facet, Student } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import Heading from '@/components/Heading.vue';
import { DropdownMenu, DropdownMenuContent, DropdownMenuItem, DropdownMenuLabel, DropdownMenuSeparator, DropdownMenuTrigger } from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { MoreHorizontal } from 'lucide-vue-next';
import { AlertDialog, AlertDialogCancel, AlertDialogContent, AlertDialogDescription, AlertDialogFooter, AlertDialogHeader, AlertDialogTitle } from '@/components/ui/alert-dialog';
import { toast } from 'vue-sonner';
import { useDateFormatter } from '@/composables/useDateFormatter';
import DataTable from '@/components/ui/data-table/DataTable.vue';
import { columns } from '@/components/enrollments/columns';
import EnrollmentSelection from '@/components/enrollments/EnrollmentSelection.vue';
import CoursePriceForm from '@/components/course-prices/FormModal.vue';
import HistoryModal from '@/components/course-prices/HistoryModal.vue';

interface Props {
  course: Course;
  courseStatuses: Enum[];
  enrollmentStatuses: Enum[];
  students?: Student[];
}

const props = defineProps<Props>();

const { df } = useDateFormatter();

const loading = ref(false);
const openCourse = ref(false);
const openDeleteCourse = ref(false);
const openNewPrice = ref(false);
const openCurrentPrice = ref(false);
const openPriceHistory = ref(false);
const openSelectStudents = ref(false);
const studentsEnrolled = computed(() => props.course.enrollments.map((enrollment) => enrollment.student));

const facets: Facet[] = [
  {
    value: 'status',
    label: 'Status',
    options: props.courseStatuses,
  }
];

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: 'Courses',
    href: '/teacher/courses',
  },
  {
    title: 'Course details',
    href: '/teacher/courses/' + props.course.id,
  }
];

const fetchStudents = () => {
  router.reload({
    only: ['students'],
    onError: () => toast.error('Error fetching students', {
      description: 'There was an error fetching the students.',
    }),
    onFinish: () => {
      openSelectStudents.value = true;
    },
  });
};

const deleteCourse = () => {
  router.delete(route('courses.destroy', props.course), {
    onSuccess: () => {
      toast.success('Course deleted successfully', {
        description: 'The course has been deleted.',
      });
    },
    onError: () => {
      toast.error('Error deleting course', {
        description: 'There was an error deleting the course.',
      });
    },
    onFinish: () => {
      openDeleteCourse.value = false;
    },
  });
};
</script>

<template>

  <Head title="Course details" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col rounded-xl p-4 overflow-x-auto">
      <Heading title="Course details" description="This is the course details page."></Heading>
      <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <Card class="lg:col-span-3">
          <CardHeader class="flex justify-between">
            <CardTitle>Course details</CardTitle>
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button variant="ghost" size="sm">
                  <span class="sr-only">Open menu</span>
                  <MoreHorizontal class="w-4 h-4" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuItem @select="openCourse = true">
                  Edit course
                </DropdownMenuItem>
                <DropdownMenuSeparator />
                <DropdownMenuItem class="text-red-600" @select="openDeleteCourse = true">
                  Delete course
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </CardHeader>
          <CardContent>
            <div class="grid grid-cols-2 gap-4">
              <div class="col-span-2">
                <p class="text-sm text-muted-foreground">Title:</p>
                <p class="font-medium leading-none">{{ course.title }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Started date:</p>
                <p class="font-medium leading-none">{{ df.format(new Date(course.started_at as string)) }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Status:</p>
                <p class="font-medium leading-none">{{ course.status.label }}</p>
              </div>
              <div class="col-span-2">
                <p class="text-sm text-muted-foreground">Description:</p>
                <p class="font-medium leading-none">{{ course.description }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Schedule:</p>
                <p class="font-medium leading-none">{{ course.schedule }}</p>
              </div>
            </div>
          </CardContent>

          <AlertDialog v-model:open="openDeleteCourse">
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
                <Button variant="destructive" @click="deleteCourse">
                  Delete
                </Button>
              </AlertDialogFooter>
            </AlertDialogContent>
          </AlertDialog>
        </Card>

        <Card>
          <CardHeader class="flex justify-between">
            <CardTitle>Current price</CardTitle>
            <DropdownMenu>
              <DropdownMenuTrigger as-child>
                <Button variant="ghost" size="sm">
                  <span class="sr-only">Open menu</span>
                  <MoreHorizontal class="w-4 h-4" />
                </Button>
              </DropdownMenuTrigger>
              <DropdownMenuContent align="end">
                <DropdownMenuLabel>Actions</DropdownMenuLabel>
                <DropdownMenuItem @select="openCurrentPrice = true">
                  Edit price
                </DropdownMenuItem>
                <DropdownMenuItem @select="openNewPrice = true">
                  New price
                </DropdownMenuItem>
                <DropdownMenuItem @select="openPriceHistory = true">
                  View history
                </DropdownMenuItem>
              </DropdownMenuContent>
            </DropdownMenu>
          </CardHeader>
          <CardContent>
            <div class="grid gap-4">
              <div>
                <p class="text-sm text-muted-foreground">Currency:</p>
                <p class="font-medium leading-none">{{ course.lastPrice.currency }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Price:</p>
                <p class="font-medium leading-none">{{ course.lastPrice.price }}</p>
              </div>
              <div>
                <p class="text-sm text-muted-foreground">Started date:</p>
                <p class="font-medium leading-none">{{ df.format(new Date(course.lastPrice.started_at as string)) }}</p>
              </div>
            </div>
          </CardContent>

          <CoursePriceForm v-model:open="openCurrentPrice" title="Edit Course Price"
            description="Edit the price of the course" :course="course" :course-price="course.lastPrice" />
          <CoursePriceForm v-model:open="openNewPrice" title="New Course Price"
            description="Create a new price for the course" :course="course" />
          <HistoryModal v-model:open="openPriceHistory" title="Price History"
            description="View the price history for this course" :course="course" />
        </Card>

        <Card class="col-span-4">
          <CardHeader>
            <CardTitle>Students enrolled</CardTitle>
          </CardHeader>
          <CardContent>
            <DataTable :columns="columns" :data="course.enrollments ?? []" :facets="facets"
              :options="{ settings: false, rowsPerPage: false, actionButton: 'Enroll student' }"
              @action-button-click="fetchStudents" />

            <EnrollmentSelection v-model:open="openSelectStudents" :all-students="students ?? []"
              :selected-students="studentsEnrolled" :course="props.course" />
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>