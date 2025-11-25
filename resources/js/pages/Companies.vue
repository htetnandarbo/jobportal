<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

const companies = [
    {
        id: 1,
        name: 'Company 1',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 2,
        name: 'Company 2',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 3,
        name: 'Company 3',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 4,
        name: 'Company 4',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
]
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6 min-h-[84vh]">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Hiring Companies</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <Card v-for="company in companies" :key="company.id">
                    <CardContent>
                        <img :src="company.image" alt="" />
                        <p class="text-center mt-2">{{ company.name }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
