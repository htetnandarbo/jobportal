<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

const careerResources = [
    {
        id: 1,
        title: 'Job Interview Tips',
        description: 'Description 1',
        youtube_src: 'https://www.youtube.com/embed/QcQfXSfLHJk?si=Wt1F4uzTrGCqc-zJ',
    },
    {
        id: 2,
        title: 'Job Interview Tips',
        description: 'Description 2',
        youtube_src: 'https://www.youtube.com/embed/QcQfXSfLHJk?si=Wt1F4uzTrGCqc-zJ',
    },
    {
        id: 3,
        title: 'Job Interview Tips',
        description: 'Description 3',
        youtube_src: 'https://www.youtube.com/embed/QcQfXSfLHJk?si=Wt1F4uzTrGCqc-zJ',
    },
    {
        id: 4,
        title: 'Job Interview Tips',
        description: 'Description 4',
        youtube_src: 'https://www.youtube.com/embed/QcQfXSfLHJk?si=Wt1F4uzTrGCqc-zJ',
    },
]
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6 min-h-[84vh]">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Career Resources</h2>
            <p class="text-center mb-4">Explore career opportunities and resources for job seekers and employers.</p>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <Card v-for="careerResource in careerResources" :key="careerResource.id">
                    <CardContent>
                        <div>
                            <iframe :src="careerResource.youtube_src" class="w-full h-96"
                                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                        <div class="p-4">
                            <p>{{ careerResource.title }}</p>
                            <p>{{ careerResource.description }}</p>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
