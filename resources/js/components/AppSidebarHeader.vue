<script setup lang="ts">
import Breadcrumbs from '@/components/Breadcrumbs.vue';
import { SidebarTrigger } from '@/components/ui/sidebar';
import type { BreadcrumbItemType } from '@/types';
import { BellIcon } from 'lucide-vue-next';
import { usePage } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import PaymentController from '@/actions/App/Http/Controllers/PaymentController';

const page = usePage<any>();

withDefaults(
    defineProps<{
        breadcrumbs?: BreadcrumbItemType[];
    }>(),
    {
        breadcrumbs: () => [],
    },
);

const role = page.props.auth.user.role;
const paymentsCount = page.props.paymentsCount;
</script>

<template>
    <header
        class="flex h-16 shrink-0 items-center gap-2 border-b border-sidebar-border/70 px-6 transition-[width,height] ease-linear group-has-data-[collapsible=icon]/sidebar-wrapper:h-12 md:px-4"
    >
        <div class="flex justify-between items-center gap-2 w-full">
            <SidebarTrigger />
            <div class="relative mr-2" v-if="role === 'admin'">
                <Link :href="PaymentController.index().url">
                    <BellIcon />
                    <div class="absolute -top-4 left-4 px-2 py-1 text-red-500 bg-red-100 rounded-full text-xs">{{ paymentsCount }}</div>
                </Link>
            </div>
        </div>
    </header>
</template>
