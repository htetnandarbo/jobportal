<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, router, useForm } from '@inertiajs/vue3';

// Routes & controllers imports
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';

// Types imports

// Custom components imports

import AppLayout from '@/layouts/AppLayout.vue';
import { Loader, LoaderCircle } from 'lucide-vue-next';

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
        router.post(CategoryController.update(props.category.id), {...form as any, '_method': 'PUT'});
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
                       
                        @change="(e : any) => form.image = e.target.files[0]"
                      
                    />

                    <div class="text-red-400">{{ form.errors.image }}</div>

                    <div v-if="props.category.image">
                        <img :src="`/images/${props.category.image}`" class="w-20 h-20 object-cover">
                    </div>

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
