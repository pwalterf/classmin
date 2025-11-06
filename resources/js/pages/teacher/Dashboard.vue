<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Enrollment, type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '@/components/PlaceholderPattern.vue';
import { Card, CardContent, CardHeader, CardTitle } from '@/components/ui/card';
import { BadgeDollarSign, GraduationCap, LibraryBig, NotebookPen } from 'lucide-vue-next';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';

import { use } from 'echarts/core';
import { BarChart, LineChart } from 'echarts/charts';
import {
    TooltipComponent,
    ToolboxComponent,
    LegendComponent,
    GridComponent
} from 'echarts/components';
import { CanvasRenderer } from 'echarts/renderers';
import type { ComposeOption } from 'echarts/core';
import type { BarSeriesOption, LineSeriesOption } from 'echarts/charts';
import type {
    TooltipComponentOption,
    ToolboxComponentOption,
    LegendComponentOption,
    GridComponentOption
} from 'echarts/components';
import { ref } from 'vue';
import VChart from "vue-echarts";

use([
    TooltipComponent,
    ToolboxComponent,
    LegendComponent,
    GridComponent,
    BarChart,
    LineChart,
    CanvasRenderer
]);

type EChartsOption = ComposeOption<
    | TooltipComponentOption
    | ToolboxComponentOption
    | LegendComponentOption
    | GridComponentOption
    | BarSeriesOption
    | LineSeriesOption
>;

interface Props {
    cards: {
        active_courses_count: number;
        active_students_count: number;
        monthly_lessons_count: number;
        income: number;
    };
    course_prices: {
        min: number;
        max: number;
        avg: number;
        count_prices: {
            min: number;
            max: number;
            above_avg: number;
            below_avg: number;
        };
    };
    debts: Enrollment[];
    enrollments_cards: {
        negative: number;
        positive: number;
        zero: number;
    };
    lessons_month: {
        months: [];
        series: [];
    };
    students_courses: {
        months: [];
        series: [];
    };
};

const props = defineProps<Props>();

const data = ref({
    tooltip: {
        trigger: 'axis',
    },
    legend: {
        data: props.lessons_month.series.map((item) => item[0]),
    },
    xAxis: {
        type: 'category',
        data: props.lessons_month.months,
        axisPointer: {
            type: 'shadow'
        }
    },
    yAxis: {
        type: 'value',
        name: 'Cantidad',
    },
    series: props.lessons_month.series.map((item) => ({
        name: item[0],
        type: item[0] === 'Lecciones' ? 'line' : 'bar',
        stack: item[0] === 'Lecciones' ? 'line' : 'bar',
        data: item[1],
    })),
});

const options = ref({
    tooltip: {
        trigger: 'axis',
    },
    legend: {
        data: props.students_courses.series.map((item) => item[0]),
    },
    xAxis: {
        type: 'category',
        data: props.lessons_month.months,
        axisPointer: {
            type: 'shadow'
        }
    },
    yAxis: {
        type: 'value',
        name: 'Cantidad',
        interval: 1,
    },
    series: props.students_courses.series.map((item) => ({
        name: item[0],
        type: 'bar',
        data: item[1],
    })),
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/teacher/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between">
                        <CardTitle class="text-sm font-medium">
                            Total Courses
                        </CardTitle>
                        <LibraryBig class="text-muted-foreground h-5 w-5" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ cards.active_courses_count }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            +20.1% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between">
                        <CardTitle class="text-sm font-medium">
                            Total Students
                        </CardTitle>
                        <GraduationCap class="text-muted-foreground h-5 w-5" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ cards.active_students_count }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            +20.1% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between">
                        <CardTitle class="text-sm font-medium">
                            Total Lessons
                        </CardTitle>
                        <NotebookPen class="text-muted-foreground h-5 w-5" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            {{ cards.monthly_lessons_count }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            +20.1% from last month
                        </p>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader class="flex flex-row items-center justify-between">
                        <CardTitle class="text-sm font-medium">
                            Total Income
                        </CardTitle>
                        <BadgeDollarSign class="text-muted-foreground h-5 w-5" />
                    </CardHeader>
                    <CardContent>
                        <div class="text-2xl font-bold">
                            $ {{ cards.income }}
                        </div>
                        <p class="text-xs text-muted-foreground">
                            +20.1% from last month
                        </p>
                    </CardContent>
                </Card>
            </div>

            <div class="grid auto-rows-min gap-4 grid-cols-1 xl:grid-cols-2">
                <Card>
                    <CardHeader>
                        <CardTitle>Lessons Attendance per Month</CardTitle>
                    </CardHeader>
                    <CardContent class="m-0 p-0">
                        <div class="h-[400px] w-full">
                            <VChart :option="data" :autoresize="true" />
                        </div>
                    </CardContent>
                </Card>
                <Card>
                    <CardHeader>
                        <CardTitle>Students and Courses per Month</CardTitle>
                    </CardHeader>
                    <CardContent class="m-0 p-0">
                        <div class="h-[400px] w-full">
                            <VChart :option="options" :autoresize="true" />
                        </div>
                    </CardContent>
                </Card>
            </div>
            <div class="flex-1">
                <Card>
                    <CardContent>
                        <div class="grid grid-cols-3 gap-4 mb-4">
                            <Card>
                                <CardContent class="flex justify-center">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl font-bold">{{ enrollments_cards.zero }}</span>
                                        <span class="text-xs text-muted-foreground">zero credits</span>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent class="flex justify-center">
                                    <div class="flex items-center space-x-2">
                                        <span class="text-xl font-bold">{{ enrollments_cards.positive }}</span>
                                        <span class="text-xs text-green-600">positive
                                            credits</span>
                                    </div>
                                </CardContent>
                            </Card>
                            <Card>
                                <CardContent class="flex justify-center">
                                    <div class="xl:flex items-center space-x-2">
                                        <span class="text-xl font-bold">{{ enrollments_cards.negative }}</span>
                                        <span class="text-xs text-red-600">negative credits</span>
                                    </div>
                                </CardContent>
                            </Card>
                        </div>

                        <h2 class="text-lg font-bold mb-2">Students with debts</h2>
                        <div class="border rounded">
                            <Table>
                                <TableHeader>
                                    <TableRow>
                                        <TableHead>Student</TableHead>
                                        <TableHead>Email</TableHead>
                                        <TableHead>Credits</TableHead>
                                    </TableRow>
                                </TableHeader>
                                <TableBody>
                                    <template v-if="debts.length === 0">
                                        <TableRow>
                                            <TableCell colspan="3" class="text-center py-4">
                                                No students with debt.
                                            </TableCell>
                                        </TableRow>
                                    </template>
                                    <TableRow v-for="debtor in debts" :key="debtor.id">
                                        <TableCell class="flex flex-col space-y-1">
                                            <span>{{ debtor.student.full_name }}</span>
                                            <span class="text-xs text-gray-500">{{ debtor.course?.title }}</span>
                                        </TableCell>
                                        <TableCell>{{ debtor.student.email }}</TableCell>
                                        <TableCell>{{ debtor.credits }}</TableCell>
                                    </TableRow>
                                </TableBody>
                            </Table>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AppLayout>
</template>
