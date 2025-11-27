<script setup lang="ts">
import CompanyController from '@/actions/App/Http/Controllers/CompanyController';
import PartnerNetworkController from '@/actions/App/Http/Controllers/PartnerNetworkController';
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

// Props
defineProps<{
    partnerNetworks: any;
}>();

// Delete
const deletePartnerNetwork = (id: any) => {
    useForm({}).submit(PartnerNetworkController.destroy(id));
};
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="mb-5">
                <div class="flex justify-end gap-2">
                    <Link :href="PartnerNetworkController.create().url">
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
                                        >Name</TableHead
                                    >
                                     <TableHead class="h-fit py-3"
                                        >Image</TableHead
                                    >
                                     <TableHead class="h-fit py-3"
                                        >Website</TableHead
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
                                    v-for="partnerNetwork in partnerNetworks"
                                    :key="partnerNetwork.id"
                                >
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ partnerNetwork.id }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        partnerNetwork.name
                                    }}</TableCell>
                                      <TableCell class="h-fit py-2">
                                        <img :src="`/images/${partnerNetwork.logo}`" class="w-20 h-20 object-cover" />
                                      </TableCell>

                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            <Link
                                                :href="
                                                    PartnerNetworkController.edit(
                                                        partnerNetwork.id,
                                                    )
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
                                                @click="
                                                    deletePartnerNetwork(partnerNetwork.id)
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
