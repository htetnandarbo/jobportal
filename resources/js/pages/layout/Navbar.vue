<script setup lang="ts">
import DashboardController from '@/actions/App/Http/Controllers/DashboardController';
import FrontController from '@/actions/App/Http/Controllers/FrontController';
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import { dashboard, logout } from '@/routes';
import { Link, router, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentUrl = ref(window.location.pathname)

const formSubmit = (role : string) => {
    useForm({'role' : role}).submit(DashboardController.index())
}

const login = () => {
    router.get('login');
}

const logoutAcc = () => {
    router.flushAll();
}

const register = () => {
    router.get('register')
}

const freelancerProject = () => {
    useForm({'show_freelance_project' : true}).submit(FrontController.welcome())
}
</script>

<template>
    <nav class="max-w-7xl mx-auto py-4">
        <div class="flex flex-col lg:flex-row justify-start lg:justify-between items-center">
            <div>
                <Link href="/" class="text-2xl font-bold text-green-500">CAREER BRIDGE</Link>
            </div>
            <div>
                <NavigationMenu :viewport="false">
                    <NavigationMenuList>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/companies' ? 'bg-green-400' : '']">
                                <Link href="/companies">ALL HIRING COMPANIES</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/partner-networks' ? 'bg-green-400' : '']">
                                <Link href="/partner-networks">PARTNER NETWORK</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/career-resources' ? 'bg-green-400' : '']">
                                <Link href="/career-resources">CAREER RESOURCES</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/career-resources' ? 'bg-green-400' : '']">
                                <p @click="freelancerProject()">FREELANCERS' PROJECTS</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
            </div>
            <div>
                <NavigationMenu :viewport="false">
                    <NavigationMenuList v-if="$page.props.auth.user">
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                v-if="$page.props.auth.user.role == 'job-seeker'"
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/' ? 'bg-green-400' : '']">
                                <p class="cursor-pointer" @click="formSubmit('job-seeker')" href="/admin/dashboard">JOB SEEKER</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                v-if="$page.props.auth.user.role == 'freelancer'"
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/companies' ? 'bg-green-400' : '']">
                                <p class="cursor-pointer" @click="formSubmit('freelancer')">FREELANCER</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                v-if="$page.props.auth.user.role == 'employer'"
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/companies' ? 'bg-green-400' : '']">
                                <p class="cursor-pointer" @click="formSubmit('employer')">COMPANY</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                class="px-5">
                                <Link class="cursor-pointer" :href="logout()" @click="logoutAcc()">Logout</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                    <NavigationMenuList v-else>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                            class="px-5"
                                >
                                <p class="cursor-pointer" @click="login()">Login</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                            class="px-5"
                                >
                                <p class="cursor-pointer" @click="register()">Register</p>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        
                    </NavigationMenuList>
                </NavigationMenu>
            </div>
        </div>
    </nav>
</template>

<style lang="scss" scoped></style>