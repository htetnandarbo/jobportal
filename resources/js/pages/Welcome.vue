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
import { useForm } from '@inertiajs/vue3'
import applications from '@/routes/applications'
import ApplicationController from '@/actions/App/Http/Controllers/ApplicationController'
import { useBasicSearch } from '@/composables/useBasicSearch'
import { ref, watch } from 'vue'
import FrontController from '@/actions/App/Http/Controllers/FrontController'

const props = defineProps({
    jobs: {
        type: Array
    },
    categories: {
        type: Array
    }
})

const form = useForm({
    'job_id': '',
    'candidate_id' : '',
    'employer_id':'',
})

const applyJob = (jobId, employerId) => {
    form.job_id = jobId
    form.employer_id = employerId
    form.submit(ApplicationController.store())
}

const q = ref('')

// watch(q.value, ()=>{
//     useBasicSearch(FrontController.welcome().url, q.value);
// })

useBasicSearch(FrontController.welcome().url, q);

const search = (id: string) => {
    useForm({category_id: id}).submit(FrontController.welcome());
}

</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Filter  -->
    <section class="max-w-7xl mx-auto py-4  rounded-lg mt-6">
        <div class="flex items-center gap-2 px-6">
            <div class="w-full">
                <Input placeholder="Keyword" v-model="q" />
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
            <div class="flex items-center gap-4 overflow-auto py-2">
                <div @click="search(category.id)" v-for="category in categories" :key="category.id" class="mb-2 p-1 rounded-md min-w-20 text-center border-2  hover:cursor-pointer">
                     {{ category.name }}
                </div>
            </div>
        </div>
    </section>

    <!-- Jobs -->
    <section class="max-w-7xl mx-auto py-4 mt-6">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Jobs</h2>
            <div class="space-y-4">
                <Card v-for="job in jobs" :key="job.id" class="relative border-2 "
                :class="{
                    'border-green-300' : job.application_status == 'accepted',
                    'border-blue-300' : job.application_status == 'viewed',
                    'border-red-300' : job.application_status == 'rejected'
                }"
                >
                    <div class="absolute right-5 top-2 text-xs bg-green-500 p-1 rounded-md text-white">Posted at {{ job.post_date }}</div>

                    <CardContent class="flex gap-4 ">
                        <img :src="job.image" alt="" class="h-44" />

                        <div class="flex flex-col justify-between ">
                            <div>
                                <h4 class="mt-2">{{ job.title }}</h4>
                                <p>Category : {{ job.category.name }}</p>
                                <p>Description : {{ job.description }}</p>
                                <p>Company : {{ job.company_name }}</p>
                                <p>Location : {{ job.location }}</p>
                                <p>Salary : {{ job.salary }}</p>
                                <p>Experience Level : {{ job.experience_level }}</p>
                                <p v-if="job.close_date" class="text-red-500">Close Date : {{ job.close_date }}</p>
                            </div>
                            <div class="my-5">
                                <h1 class="font-bold">
                                    Skills Required
                                </h1>
                                <p>
                                    {{ job.skills }}
                                </p>
                            </div>
                            
                        </div>
                    </CardContent>

                    <div class="p-4 ms-auto">
                        <Button @click="applyJob(job.id, job.employer_id)" v-if="!job.applied">Apply</Button>
                        <Button variant="outline" v-else>

                            <span v-if="job.application_status == 'pending'" class="text-amber-500">
                                {{ job.application_status }} ...
                            </span>

                            <span v-if="job.application_status == 'accepted'" class="text-green-500">
                                {{ job.application_status }}
                            </span>

                            <span v-if="job.application_status == 'reviewed'" class="text-blue-500">
                                {{ job.application_status }}
                            </span>

                            <span v-if="job.application_status == 'rejected'" class="text-red-500">
                                {{ job.application_status }}
                            </span>
                        </Button>

                    </div>
                </Card>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
