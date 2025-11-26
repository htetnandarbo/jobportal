<script setup lang="ts">
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
import MakePaymentController from '@/actions/App/Http/Controllers/MakePaymentController';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
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

// props
const props = defineProps<{
    userPayment: any
}>()


// form
const form = useForm<any>({
    voucher_image: null
})

const submit = () => {
    form.submit(MakePaymentController.makePayment(), {
        onSuccess: () => {
            form.reset();
            alert('Payment success')
        },
        onError: () => {
            alert('Payment failed')
        }
    });
}
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="grid gap-5 rounded-xl border p-5">
                <div v-if="userPayment">
                    <div v-if="userPayment.payment_status === 'pending'" class="bg-orange-300 p-2">
                        Your payment status is - {{userPayment.payment_status}}
                    </div>
                    <div v-else class="bg-green-300 p-2">
                        Your payment status is - {{userPayment.payment_status}}
                    </div>
                    <div class="mt-4">
                        <p class="font-bold mb-4">Payment voucher</p>
                        <img :src="`/images/${userPayment.voucher_image}`" alt="" class="w-44">
                    </div>
                </div>
                <div v-else>
                    <h4 class="font-bold text-xl">Make Payment here</h4>
                    <div class="mt-4">
                        <p>Employer fee: 500000 MMK</p>
                    </div>
                    <div class="mt-6">
                        <Label for="voucher" class="mb-2">Payment Voucher</Label>
                        <Input type="file" @input="form.voucher_image = $event.target.files[0]" required />
                        <Button class="mt-2" @click="submit">Make payment</Button>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
