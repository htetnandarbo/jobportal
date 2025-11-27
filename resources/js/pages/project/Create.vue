<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import {
  Select,
  SelectTrigger,
  SelectValue,
  SelectContent,
  SelectItem
} from "@/components/ui/select";

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, router, useForm } from '@inertiajs/vue3';

// Routes & controllers imports

// Types imports

// Custom components imports

import PartnerNetworkController from '@/actions/App/Http/Controllers/PartnerNetworkController';
import AppLayout from '@/layouts/AppLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';
import ProjectController from '@/actions/App/Http/Controllers/ProjectController';
import Textarea from '@/components/ui/textarea/Textarea.vue';

// Props
const props = defineProps<{
    project: any;
}>();

const statuses = [
    {value: 'in_progress', name: 'In progress'},
    {value: 'completed', name: 'Completed'}
]

// Form
const form = useForm({
    title: props.project.title ?? '',
    description: props.project.description ??'',
    start_date: props.project.start_date ??'',
    end_date: props.project.end_date ??'',
    status: props.project.status ??'',
    thumbnail: props.project.thumbnail ??''
});

const submit = () => {
    if (!props.project.id) {
        form.submit(ProjectController.store());
    } else {
        router.post(ProjectController.update(props.project.id), {
            ...(form as any),
            _method: 'put',
        });
    }

};
</script>

<template>
    <Head title="Project Create" />

    <AppLayout>
        <div class="max-w-2xl flex-1 rounded-xl p-6">
            <form @submit.prevent="submit" class="space-y-3">
                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Title</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Project Title"
                        v-model="form.title"
                        required
                    />
                </div>

                <!-- Image Upload -->
                <div class="grid gap-2">
                    <Label for="image">Thumbnail</Label>
                    <Input
                        id="name"
                        type="file"
                        name="name"
                        @change="(e: any) => (form.thumbnail = e.target.files[0])"
                    />

                    <div class="text-red-400">{{ form.errors.thumbnail }}</div>

                    <div v-if="props.project.thumbnail">
                        <img
                            :src="`/images/${props.project.thumbnail}`"
                            class="h-20 w-20 object-cover"
                        />
                    </div>
                </div>

                <!-- Website -->
                <div class="grid gap-2">
                    <Label for="website">Start Date</Label>
                    <Input
                        id="website"
                        type="datetime-local"
                        name="website"
                        placeholder="Start Daate"
                        v-model="form.start_date"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="website">End Date</Label>
                    <Input
                        id="website"
                        type="datetime-local"
                        name="website"
                        placeholder="End Daate"
                        v-model="form.end_date"
                        required
                    />
                </div>

                <div class="flex-1">
                    <Label for="role" class="mb-3">Status</Label>
                    <Select name="role" v-model="form.status">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select status" />
                        </SelectTrigger>
                        <SelectContent>     
                            <SelectItem v-for="status in statuses" :key="status.value" :value="status.value">{{ status.name }}</SelectItem>
                        </SelectContent>
                    </Select>

                    <InputError :message="form.errors.status" />

                </div>

                <div class="grid gap-2">
                    <Label for="website">Description</Label>
                    <Textarea
                        id="website"
                        type="datetime-local"
                        name="website"
                        placeholder="Description"
                        v-model="form.description"
                        required
                    />
                </div>

                <div>
                    <Button :disabled="form.processing"> 
                         <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
                        Submit 
                     </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
