<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, useForm } from '@inertiajs/vue3';

// Routes & controllers imports

// Types imports

// Custom components imports
import AppLayout from '@/layouts/AppLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';
import CareerResourceController from '@/actions/App/Http/Controllers/CareerResourceController';

// Props
const props = defineProps<{
    careerResource: any;
}>();

// Form
const form = useForm({
    name: props.careerResource.name ?? '',
    youtube_src: props.careerResource.youtube_src ?? '',
});

const submit = () => {
    if (!props.careerResource.id) {
        form.submit(CareerResourceController.store());
    } else {
        form.submit(CareerResourceController.update(props.careerResource.id));
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
                    <Label for="image">Youtube Source</Label>
                    <Input
                        id="youtube_src"
                        type="youtube_src"
                        name="youtube_src"
                        placeholder="Youtube Source"
                        v-model="form.youtube_src"
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
