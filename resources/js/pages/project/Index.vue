<script setup lang="ts">
import PaymentController from '@/actions/App/Http/Controllers/PaymentController';
import ProjectController from '@/actions/App/Http/Controllers/ProjectController';
import UserController from '@/actions/App/Http/Controllers/UserController';
import BasicSearch from '@/components/BasicSearch.vue';
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
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';
import { ref } from 'vue';

// Props
defineProps<{
    projects: any;
}>();

const q = ref<string>("");

const deleteProject = (id:string) => {
    useForm({}).submit(ProjectController.destroy(id))
}
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="mb-5 flex justify-end">
                <Link
                    :href="ProjectController.create().url" >
                        <Button
                            class="ms-auto mb-5 cursor-pointer rounded-2xl bg-amber-500 text-white shadow-sm shadow-amber-50 transition-all hover:bg-amber-600 hover:shadow-sm hover:shadow-amber-300 sm:w-auto"
                            >
                            Add new <PlusIcon></PlusIcon
                        ></Button>
                    </Link>
            </div>
            <div class="grid gap-5 rounded-xl border p-5">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <!-- Search -->
                    <BasicSearch :url="UserController.index().url" :q="q" />
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
                                        >Title</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Thumbnail</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Start Date</TableHead
                                    >
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        End Date
                                    </TableHead>
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        Status
                                    </TableHead>
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        Option
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="(project, index) in projects"
                                    :key="project.id"
                                >
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ index + 1 }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        project.title
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">
                                        <img :src="`/images/${project.thumbnail}`" class="w-32 h-20 object-cover rounded-md"/>
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        project.start_date ?? '--'
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        project.end_date ?? '--'
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        project.status 
                                    }}</TableCell>

                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            <Link
                                                :href="
                                                    ProjectController.edit(project.id)
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
                                                @click="deleteProject(project.id)"
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
