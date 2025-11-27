<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

defineProps<{companies: any}>()
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6 min-h-[84vh]">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Hiring Companies</h2>
            <div v-if="companies.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template v-for="company in companies" :key="company.id">
                    <a :href="company.website" target="_blank">
                        <Card>
                            <CardContent>
                                <img :src="`images/${company.logo}`" alt="" />
                                <p class="text-center mt-2">{{ company.name }}</p>
                            </CardContent>
                        </Card>
                    </a>
                </template>
            </div>
            <p v-else class="text-center">No companies found.</p>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
