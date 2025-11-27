<script setup lang="ts">
// Shadcn ui imports
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

// Lucide icons imports

// Vue, inertia & other libraries imports
import { Head, router, useForm } from '@inertiajs/vue3';

// Routes & controllers imports

// Types imports

// Custom components imports

import PartnerNetworkController from '@/actions/App/Http/Controllers/PartnerNetworkController';
import AppLayout from '@/layouts/AppLayout.vue';
import { LoaderCircle } from 'lucide-vue-next';

// Props
const props = defineProps<{
    partnerNetwork: any;
}>();

// Form
const form = useForm({
    name: props.partnerNetwork.name ?? '',
    logo: null,
    website: props.partnerNetwork.website ?? '',
});

const submit = () => {
    if (!props.partnerNetwork.id) {
        form.submit(PartnerNetworkController.store());
    } else {
        router.post(PartnerNetworkController.update(props.partnerNetwork.id), {
            ...(form as any),
            _method: 'put',
        });
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
                        @change="(e: any) => (form.logo = e.target.files[0])"
                    />

                    <div class="text-red-400">{{ form.errors.logo }}</div>

                    <div v-if="props.partnerNetwork.logo">
                        <img
                            :src="`/images/${props.partnerNetwork.logo}`"
                            class="h-20 w-20 object-cover"
                        />
                    </div>
                </div>

                <!-- Website -->
                <div class="grid gap-2">
                    <Label for="website">Website</Label>
                    <Input
                        id="website"
                        type="website"
                        name="website"
                        placeholder="Website"
                        v-model="form.website"
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
