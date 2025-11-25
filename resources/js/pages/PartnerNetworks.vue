<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

const partnerNetworks = [
    {
        id: 1,
        name: 'Partner Network 1',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 2,
        name: 'Partner Network 2',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 3,
        name: 'Partner Network 3',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 4,
        name: 'Partner Network 4',
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
            <h2 class="text-2xl text-center font-bold mb-4">Partner Networks</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <Card v-for="partnerNetwork in partnerNetworks" :key="partnerNetwork.id">
                    <CardContent>
                        <img :src="partnerNetwork.image" alt="" />
                        <p class="text-center mt-2">{{ partnerNetwork.name }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
