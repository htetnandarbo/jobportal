<script setup lang="ts">
import JobController from '@/actions/App/Http/Controllers/JobController';
import { Button } from '@/components/ui/button';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';

// Props
defineProps<{
    jobs: any;
}>();

// Delete
const deleteJob = (id: any) => {
    useForm({}).submit(JobController.destroy(id));
};
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="mb-5">
                <div class="flex justify-end gap-2">
                    <Link :href="JobController.create()">
                        <Button
                            class="cursor-pointer rounded-2xl bg-amber-500 text-white shadow-sm shadow-amber-50 transition-all hover:bg-amber-600 hover:shadow-sm hover:shadow-amber-300 sm:w-auto"
                            >Add New <plus-icon></plus-icon
                        ></Button>
                    </Link>
                </div>
            </div>
            <div class="grid gap-5 rounded-xl border p-5">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <!-- Search -->
                </div>

                <div>
                    <ScrollArea class="grid w-full grid-cols-1 overflow-auto">
                        <Table>
                            <TableHeader class="border-none bg-gray-100">
                                <TableRow class="border-none">
                                    <TableHead
                                        class="h-fit rounded-l-full py-3"
                                    >
                                        No
                                    </TableHead>
                                    <TableHead class="h-fit py-3"
                                        >Category</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Title</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Description</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Company Name</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Location</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Salary</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Skills</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Experience Level</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Post Date</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Close Date</TableHead
                                    >
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        Action
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow v-for="job in jobs" :key="job.id">
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ job.id }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.category.name
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.title
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">
                                        <textarea rows="3" cols="25">{{ job.description }}</textarea>
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.company_name
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.location
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.salary
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.skills
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.experience_level
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.post_date
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        job.close_date
                                    }}</TableCell>
                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            <Link
                                                :href="
                                                    JobController.edit(job.id)
                                                "
                                            >
                                                <Button
                                                    size="sm"
                                                    variant="outline"
                                                    >Edit</Button
                                                >
                                            </Link>
                                            <Button
                                                size="sm"
                                                variant="outline"
                                                @click="deleteJob(job.id)"
                                                >Delete</Button
                                            >
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        <ScrollBar orientation="horizontal" />
                    </ScrollArea>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
