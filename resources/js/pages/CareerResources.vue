<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

defineProps<{careerResources: any}>()
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6 min-h-[84vh]">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Career Resources</h2>
            <p class="text-center mb-4">Explore career opportunities and resources for job seekers and employers.</p>
            <div v-if="careerResources.length > 0" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <template v-for="careerResource in careerResources" :key="careerResource.id">
                    <a :href="careerResource.youtube_src" target="_blank">
                    <Card>
                        <CardContent>
                            <div>
                                <iframe :src="careerResource.youtube_src" class="w-full h-96"
                                    allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                        </div>
                        <div class="p-4">
                            <p>{{ careerResource.name }}</p>
                        </div>
                    </CardContent>
                </Card>
                </a>
                </template>
            </div>
            <p v-else class="text-center">No career resources found.</p>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
