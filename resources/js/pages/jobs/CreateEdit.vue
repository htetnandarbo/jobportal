<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select';
import { Textarea } from '@/components/ui/textarea';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, useForm } from '@inertiajs/vue3';

// Routes & controllers imports

// Types imports

// Custom components imports

import JobController from '@/actions/App/Http/Controllers/JobController';
import AppLayout from '@/layouts/AppLayout.vue';
// import categories from '@/routes/categories';

// Props
const props = defineProps<{
    job: any;
    categories: any;
}>();

// Form
const form = useForm({
    category_id: props.job.category_id ?? '',
    title: props.job.title ?? '',
    description: props.job.description ?? '',
    company_name: props.job.company_name ?? '',
    location: props.job.location ?? '',
    salary: props.job.salary ?? '',
    skills: props.job.skills ?? '',
    experience_level: props.job.experience_level ?? '',
    post_date: props.job.post_date ?? '',
    close_date: props.job.close_date ?? '',
});

const submit = () => {
    if (!props.job.id) {
        form.submit(JobController.store());
    } else {
        form.submit(JobController.update(props.job.id));
    }
};
</script>

<template>
    <Head title="Categories Create" />

    <AppLayout>
        <div class="max-w-2xl flex-1 rounded-xl p-6">
            <form @submit.prevent="submit" class="space-y-3">
                <div class="grid gap-2">
                    <Label for="unit_category">Job Category</Label>
                    <Select v-model="form.category_id" name="category_id">
                        <SelectTrigger>
                            <SelectValue placeholder="Select job category" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectGroup>
                                <SelectItem
                                    v-for="category in categories"
                                    :key="category.id"
                                    class="focus:bg-emerald-50 focus:text-emerald-900"
                                    :value="category.id"
                                >
                                    {{ category.name }}
                                </SelectItem>
                            </SelectGroup>
                        </SelectContent>
                    </Select>
                </div>

                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Title</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Title"
                        v-model="form.title"
                        required
                    />
                </div>

                <!-- Description -->
                <div class="grid gap-2">
                    <Label for="description">Description</Label>
                    <Textarea
                        placeholder="Type your description here."
                        name="description"
                        rows="3"
                        v-model="form.description"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Company Name</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Company Name"
                        v-model="form.company_name"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Location</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Location"
                        v-model="form.location"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Salary</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Salary"
                        v-model="form.salary"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="description">Skills</Label>
                    <Textarea
                        placeholder="Skills.."
                        name="description"
                        rows="3"
                        v-model="form.skills"
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="name">Experience Level</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Experience Level"
                        v-model="form.experience_level"
                        required
                    />
                </div>

                <div>
                    <Button> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
