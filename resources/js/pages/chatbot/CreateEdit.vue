<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, useForm } from '@inertiajs/vue3';

// Routes & controllers imports
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

// Types imports

// Custom components imports

import AppLayout from '@/layouts/AppLayout.vue';
import { ref } from 'vue';
import ChatBotController from '@/actions/App/Http/Controllers/ChatBotController';

// Props
const props = defineProps<{
    category: any;
}>();

// Form
const form = useForm<{question : string, optionAnswer: {id: string, option: string, answer: string}[]}>({
    question: '',
    optionAnswer: []
});

const faqOption = ref('');
const faqAnswer = ref('');

const faqOptionsAnswers = ref<{id: string, option: string, answer: string}[]>([]);

const addfaqOptionsAnswers = () => {
    if(faqOption.value == '' || faqAnswer.value == ''){
        return
    }
    faqOptionsAnswers.value.push(
        {
            id: Math.random().toString(36).substr(2, 5), 
            option: faqOption.value, 
            answer: faqAnswer.value 
        })

    faqOption.value = '';
    faqAnswer.value = '';
}

const deleteFaq = (id: string) => {
    faqOptionsAnswers.value = faqOptionsAnswers.value.filter(faq => faq.id != id)
}

const submit = () => {
    // if (!props.category.id) {
    //     form.submit(CategoryController.store());
    // } else {
    //     form.submit(CategoryController.update(props.category.id));
    // }

    form.optionAnswer = faqOptionsAnswers.value;
    form.submit(ChatBotController.store());
};
</script>

<template>
    <Head title="Categories Create" />

    <AppLayout>
        <div class="max-w-2xl flex-1 rounded-xl p-6">
            <form @submit.prevent="submit" class="space-y-3">
                <!-- Faq Question -->
                <div class="grid gap-2">
                    <Label for="name">Faq Question</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Faq Question"
                        v-model="form.question"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Faq Option</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Faq Option"
                        v-model="faqOption"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Faq Answer</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Faq Answer"
                        v-model="faqAnswer"
                        required
                    />
                </div>

                <Button @click="addfaqOptionsAnswers"> Add Option and Answer </Button>

                <Table>
                    <TableHeader class="border-none bg-gray-100">
                        <TableRow class="border-none">
                            <TableHead
                                class="h-fit rounded-l-full py-3"
                            >
                                No
                            </TableHead>
                            <TableHead class="h-fit py-3"
                                >Option</TableHead
                            >
                            <TableHead
                                class="h-fit rounded-r-full py-3"
                            >
                                Answer 
                            </TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow
                            v-for="faq in faqOptionsAnswers"
                            :key="faq.id"
                        >
                            <TableCell
                                class="h-fit rounded-l-full py-2"
                            >
                                {{ faq.option }}
                            </TableCell>
                            <TableCell class="h-fit py-2">{{
                                faq.answer
                            }}</TableCell>

                            <TableCell
                                class="h-fit rounded-r-full py-2"
                            >
                                <div class="flex gap-2">
                                    
                                    <Button
                                        size="sm"
                                        variant="outline"
                                        @click="deleteFaq(faq.id)"
                                        >Delete</Button
                                    >
                                </div>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
                

                <div>
                    <Button> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
