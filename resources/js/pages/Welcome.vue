<script setup lang="ts">
import {
    Select,
    SelectContent,
    SelectItem,
    SelectTrigger,
    SelectValue,
} from '@/components/ui/select'
import { Input } from '@/components/ui/input'
import { Button } from '@/components/ui/button'
import {
    Card,
    CardContent,
    CardDescription,
    CardFooter,
    CardHeader,
    CardTitle,
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'

const categories = [
    {
        id: 1,
        name: 'Job Category 1',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 2,
        name: 'Job Category 2',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 3,
        name: 'Job Category 3',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
    {
        id: 4,
        name: 'Job Category 4',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
    },
]

const jobs = [
    {
        id: 1,
        name: 'Job 1',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
        description: 'Job Description 1',
    },
    {
        id: 2,
        name: 'Job 2',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
        description: 'Job Description 2',
    },
    {
        id: 3,
        name: 'Job 3',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
        description: 'Job Description 3',
    },
    {
        id: 4,
        name: 'Job 4',
        image: 'https://upload.wikimedia.org/wikipedia/commons/thumb/a/ae/20240314_Lisa_Manoban_07.jpg/250px-20240314_Lisa_Manoban_07.jpg',
        description: 'Job Description 4',
    },
]
</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Filter  -->
    <section class="max-w-7xl mx-auto py-4 border border-green-400 rounded-lg mt-6">
        <div class="flex items-center gap-2 px-6">
            <div class="w-full">
                <Input placeholder="Keyword" />
            </div>
            <div class="w-full">
                <Select>
                    <SelectTrigger>
                        <SelectValue placeholder="Select a fruit" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem value="apple">
                            Apple
                        </SelectItem>
                        <SelectItem value="banana">
                            Banana
                        </SelectItem>
                        <SelectItem value="blueberry">
                            Blueberry
                        </SelectItem>
                        <SelectItem value="grapes">
                            Grapes
                        </SelectItem>
                        <SelectItem value="pineapple">
                            Pineapple
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
            <div>
                <Button>Search</Button>
            </div>
        </div>
    </section>

    <!-- Category  -->
    <section class="max-w-7xl mx-auto py-4 mt-6">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Explore by Category</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <Card v-for="category in categories" :key="category.id">
                    <CardContent>
                        <img :src="category.image" alt="" />
                        <p class="text-center mt-2">{{ category.name }}</p>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>

    <!-- Jobs -->
    <section class="max-w-7xl mx-auto py-4 mt-6">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Jobs</h2>
            <div class="space-y-4">
                <Card v-for="job in jobs" :key="job.id">
                    <CardContent class="flex gap-4">
                        <img :src="job.image" alt="" class="h-44" />
                        <div class="flex flex-col justify-between">
                            <div>
                                <h4 class="mt-2">{{ job.name }}</h4>
                                <p>{{ job.description }}</p>
                            </div>
                            <div>
                                <Button>Apply</Button>
                            </div>
                        </div>
                    </CardContent>
                </Card>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
