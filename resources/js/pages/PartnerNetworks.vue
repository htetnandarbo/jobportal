<script setup lang="ts">
import {
    Card,
    CardContent,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

defineProps<{ partnerNetworks: any }>()
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6 min-h-[84vh]">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Partner Networks</h2>
            <div v-if="partnerNetworks.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <template v-for="partnerNetwork in partnerNetworks" :key="partnerNetwork.id">
                    <a :href="partnerNetwork.website" target="_blank">
                        <Card class="h-full">
                            <CardContent>
                                <img :src="`images/${partnerNetwork.logo}`" alt="" />
                                <p class="text-center mt-2">{{ partnerNetwork.name }}</p>
                            </CardContent>
                        </Card>
                    </a>
                </template>
            </div>
            <p v-else class="text-center">No partner networks found.</p>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
