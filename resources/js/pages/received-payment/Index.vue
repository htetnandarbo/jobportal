<script setup lang="ts">
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
import PaymentController from '@/actions/App/Http/Controllers/PaymentController';
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
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// Props
defineProps<{
    payments: any;
}>();

// Delete
const approve = (id: any) => {
    useForm({}).submit(PaymentController.update(id));
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
                                        >User</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Voucher Image</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Payment Status</TableHead
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
                                    v-for="(payment, index) in payments"
                                    :key="payment.id"
                                >
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ index + 1 }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        payment.user.name
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">
                                        <img :src="`/images/${payment.voucher_image}`" class="w-30 h-30 object-cover rounded-md"/>
                                    </TableCell>
                                    <TableCell class="h-fit py-2" :class="
                                    {
                                        'text-amber-400' : payment.payment_status == 'pending',
                                        'text-green-500' : payment.payment_status == 'completed'
                                    }
                                    ">{{
                                        payment.payment_status
                                    }}</TableCell>
                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            

                                            <Button
                                                v-if="payment.payment_status == 'pending'"
                                                size="sm"
                                                variant="outline"
                                                @click="approve(payment.id)"
                                                >Approve</Button
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
