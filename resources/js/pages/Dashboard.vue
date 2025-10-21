<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { Card, CardContent } from '@/components/ui/card';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="grid grid-cols-4 gap-4">
                <Card>
                    <CardContent class="flex flex-col items-center justify-center">
                        <div class="text-2xl font-bold">12</div>
                        <div class="text-sm text-sidebar-text/70">Students</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent class="flex flex-col items-center justify-center">
                        <div class="text-2xl font-bold">75</div>
                        <div class="text-sm text-sidebar-text/70">Lessons</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent class="flex flex-col items-center justify-center">
                        <div class="text-2xl font-bold">$ 956.000,00</div>
                        <div class="text-sm text-sidebar-text/70">Revenue</div>
                    </CardContent>
                </Card>
                <Card>
                    <CardContent class="flex flex-col items-center justify-center">
                        <div class="text-2xl font-bold">$ 1.876.000,00</div>
                        <div class="text-sm text-sidebar-text/70">Estimated Revenue</div>
                    </CardContent>
                </Card>
            </div>

            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                    <PlaceholderPattern />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
                <PlaceholderPattern />
            </div>
        </div>
    </AppLayout>
</template>
