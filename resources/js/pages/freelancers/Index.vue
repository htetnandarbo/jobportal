<script setup lang="ts">
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
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
import { create as categoryCreate } from '@/routes/categories';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';
import { ref } from 'vue';

// Props
defineProps<{
    users: any;
}>();

// Delete
const deleteUser = (id: any) => {
    useForm({}).submit(UserController.deleteFreelancer(id));
};

const q = ref<string>("");
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="mb-5">
                
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
                                        >Name</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Email</TableHead
                                    >
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        Action
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="(user, index) in users"
                                    :key="user.id"
                                >
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ index + 1 }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        user.name
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        user.email
                                    }}</TableCell>

                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            

                                            <Button
                                                v-if="$page.props.auth.user.id != user.id"
                                                size="sm"
                                                variant="outline"
                                                @click="
                                                    deleteUser(user.id)
                                                "
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
