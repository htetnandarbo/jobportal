<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, useForm } from '@inertiajs/vue3';

// Routes & controllers imports
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

// Types imports

// Custom components imports

import AppLayout from '@/layouts/AppLayout.vue';

// Props
const props = defineProps<{
    category: any;
}>();

// Form
const form = useForm({
    name: props.category.name ?? '',
    image: props.category.image ?? '',
});

const submit = () => {
    if (!props.category.id) {
        form.submit(CategoryController.store());
    } else {
        form.submit(CategoryController.update(props.category.id));
    }
};
</script>

<template>
    <Head title="Categories Create" />

    <AppLayout>
        <div class="max-w-2xl flex-1 rounded-xl p-6">
            <form @submit.prevent="submit" class="space-y-3">
                <!-- Name -->
                <div class="grid gap-2">
                    <Label for="name">Name</Label>
                    <Input
                        id="name"
                        type="name"
                        name="name"
                        placeholder="Name"
                        v-model="form.name"
                        required
                    />
                </div>

                <!-- Image Upload -->
                <div class="grid gap-2">
                    <Label for="image">Image</Label>
                    <Input
                        id="name"
                        type="file"
                        name="name"
                       
                        @change="e => form.image = e.target.files[0]"
                      
                    />

                    <div v-if="props.category.image">
    <img :src="`/storage/${props.category.image}`" class="w-20 h-20 object-cover">
</div>

                </div>

                <div>
                    <Button> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
