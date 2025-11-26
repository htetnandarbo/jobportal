<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import {
    Sidebar,
    SidebarContent,
    SidebarFooter,
    SidebarHeader,
    SidebarMenu,
    SidebarMenuButton,
    SidebarMenuItem,
} from '@/components/ui/sidebar';
import { dashboard } from '@/routes';
import { type NavItem } from '@/types';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';
import ScheduleController from '@/actions/App/Http/Controllers/ScheduleController';
import ChatBotController from '@/actions/App/Http/Controllers/ChatBotController';
import UserController from '@/actions/App/Http/Controllers/UserController';
import MakePaymentController from '@/actions/App/Http/Controllers/MakePaymentController';
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
import JobController from '@/actions/App/Http/Controllers/JobController';
import PaymentController from '@/actions/App/Http/Controllers/PaymentController';

// Routes and controllers 

  const page = usePage<any>()

  const hasPaid = page.props.auth.hasPaid;
  const userRole = page.props.auth.user.role;

const employerNavItems: any[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
        hasPaid: true,
    },
    {
        title: 'Make Payment',
        href: MakePaymentController.index(),
        icon: LayoutGrid,
        hasPaid: true,             
    },
    {
        title: 'Categories',
        href: CategoryController.index(),
        icon: LayoutGrid,
        hasPaid: hasPaid,
    },
    {
        title: 'Jobs',
        href: JobController.index(),
        icon: LayoutGrid,
        hasPaid: hasPaid,
    },
    {
        title: 'Schedules',
        href: ScheduleController.create(),
        icon: LayoutGrid,
    },
    {
        title: 'Chat Bot',
        href: ChatBotController.index(),
        icon: LayoutGrid,
    },
    {
        title: 'Admin User',
        href: UserController.index(),
        icon: LayoutGrid,
    },
    {
        title: 'Employers',
        href: UserController.employerIndex(),
        icon: LayoutGrid,
    },
    {
        title: 'Job Seekers',
        href: UserController.jobSeekerIndex(),
        icon: LayoutGrid,
        hasPaid: hasPaid,
    },
];

const employeeNavItems: any[] = [
   {
        title: 'Make Payment',
        href: MakePaymentController.index(),
        icon: LayoutGrid,
        hasPaid: true,             
    }, 
];

const adminNavItems: any[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
        icon: LayoutGrid,
        hasPaid: true
    },
    {
        title: 'Schedules',
        href: ScheduleController.create(),
        icon: LayoutGrid,
        hasPaid: true
    },
    {
        title: 'Admin User',
        href: UserController.index(),
        icon: LayoutGrid,
        hasPaid: true
    },
    {
        title: 'Employers',
        href: UserController.employerIndex(),
        icon: LayoutGrid,
        hasPaid: true
    },
    {
        title: 'Job Seekers',
        href: UserController.jobSeekerIndex(),
        icon: LayoutGrid,
        hasPaid: true,
    },
    {
        title: 'Freelancers',
        href: UserController.freelancerIndex(),
        icon: LayoutGrid,
        hasPaid: true,
    },
    {
        title: 'Payments',
        href: PaymentController.index(),
        icon: LayoutGrid,
        hasPaid: true,
    },
];


</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="dashboard()">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="employerNavItems" v-if="userRole === 'employer'" />
            <NavMain :items="employeeNavItems" v-if="userRole === 'freelancer'" />
            <NavMain :items="adminNavItems" v-if="userRole === 'admin'" />
            <NavMain :items="employeeNavItems" v-if="userRole === 'job-seeker'" />
        </SidebarContent>

        <SidebarFooter>
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
