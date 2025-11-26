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
import UserController from '@/actions/App/Http/Controllers/UserController';
import InputError from '@/components/InputError.vue';

// Props
const props = defineProps<{
    user: any;
}>();

// Form
const form = useForm({
    name: props.user.name ?? '',
    email: props.user.email ?? '',
    password: ''
});

const submit = () => {
    if (!props.user.id) {
        form.submit(UserController.store());
    } else {
        form.submit(UserController.update(props.user.id));
    }
};
</script>

<template>
    <Head title="Admin User Create" />

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

                <div class="grid gap-2">
                    <Label for="email">Email</Label>
                    <Input
                        id="email"
                        type="email"
                        name="email"
                        placeholder="Email"
                        v-model="form.email"
                        required
                    />
                </div>

                <div class="grid gap-2">
                    <Label for="password">Password</Label>
                    <Input
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Password"
                        v-model="form.password"
                    />
                    <InputError :message="form.errors.password"/>
                </div>

                <div>
                    <Button> Submit </Button>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
