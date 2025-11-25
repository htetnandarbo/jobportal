<script setup lang="ts">
import {
    NavigationMenu,
    NavigationMenuContent,
    NavigationMenuItem,
    NavigationMenuLink,
    NavigationMenuList,
    NavigationMenuTrigger,
    navigationMenuTriggerStyle,
} from '@/components/ui/navigation-menu'
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const currentUrl = ref(window.location.pathname)
</script>

<template>
    <nav class="max-w-7xl mx-auto py-4">
        <div class="flex flex-col lg:flex-row justify-start lg:justify-between items-center">
            <div>
                <Link href="/">CAREER BRIDGE</Link>
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
                    </NavigationMenuList>
                </NavigationMenu>
            </div>
            <div>
                <NavigationMenu :viewport="false">
                    <NavigationMenuList>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/' ? 'bg-green-400' : '']">
                                <Link href="/login">JOB SEEKER</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/companies' ? 'bg-green-400' : '']">
                                <Link href="/login">FREELANCER</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                        <NavigationMenuItem>
                            <NavigationMenuLink as-child
                                :class="[navigationMenuTriggerStyle(), currentUrl === '/companies' ? 'bg-green-400' : '']">
                                <Link href="/login">COMPANY</Link>
                            </NavigationMenuLink>
                        </NavigationMenuItem>
                    </NavigationMenuList>
                </NavigationMenu>
            </div>
        </div>
    </nav>
</template>

<style lang="scss" scoped></style>