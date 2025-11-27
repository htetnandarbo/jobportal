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
} from '@/components/ui/card'
import Navbar from '@/pages/layout/Navbar.vue'
import Footer from './layout/Footer.vue'
import { useForm, Link } from '@inertiajs/vue3'
import ApplicationController from '@/actions/App/Http/Controllers/ApplicationController'
import { useBasicSearch } from '@/composables/useBasicSearch'
import { ref, watch } from 'vue'
import FrontController from '@/actions/App/Http/Controllers/FrontController'
import ChatBotController from '@/actions/App/Http/Controllers/ChatBotController'
import ProjectController from '@/actions/App/Http/Controllers/ProjectController'
import Switch from '@/components/ui/switch/Switch.vue'

defineProps<{
    jobs: any,
    categories: any,
    projects: any
}>();

const form = useForm({
    'job_id': '',
    'candidate_id' : '',
    'employer_id':'',
})

const applyJob = (jobId : any, employerId : any) => {
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

const chatBot = (employerId: string) => {
    useForm({employer_id: employerId}).submit(ChatBotController.show(employerId));
}

const searchByCategory = (event: any) => {
    useForm({category_id: event}).submit(FrontController.welcome());
}

const commentForm = useForm({
    project_id : '',
    comment: []
})
const sendcomment = (id:string) => {
    commentForm.project_id = id;
    // commentForm.submit(ProjectController.storeComment());
    commentForm.post(ProjectController.storeComment().url, {
        preserveScroll: true
    })

    commentForm.comment = []
}

const addcomment = (value:string, projectId : string) => {
    // const  isExist = commentForm.comment.find(comment => comment.id == projectId);
    // console.log(isExist, projectId);
    // if(isExist){
    //     commentForm.comment = commentForm.comment.filter(comment => comment.id == projectId)
    // }
    commentForm.comment = commentForm.comment.filter(comment => comment.id != projectId)
    commentForm.comment.push({id: projectId, comment: value})
}

const turnOffComment = ref([]);

const updateTurnOff = (projectId) => {
    const idx = turnOffComment.value.indexOf(projectId)

    if (idx === -1) {
        // Not in array → add it
        turnOffComment.value.push(projectId)
    } else {
        // Already in array → remove it
        turnOffComment.value.splice(idx, 1)
    }
}

</script>

<template>
    <!-- Navigation  -->
    <Navbar />

    <!-- Filter  -->
    <section v-if="!projects" class="max-w-7xl mx-auto py-4  rounded-lg mt-6">
        <div class="flex items-center gap-2 px-6">
            <div class="w-full">
                <Input placeholder="Keyword" v-model="q" />
            </div>
            <div class="w-full">
                <Select @update:modelValue="searchByCategory($event)">
                    <SelectTrigger>
                        <SelectValue placeholder="Select a category" />
                    </SelectTrigger>
                    <SelectContent>
                        <SelectItem v-for="category in categories" :key="category.id" :value="category.id">
                            {{ category.name }}
                        </SelectItem>
                    </SelectContent>
                </Select>
            </div>
        </div>
    </section>

    <!-- Category  -->
    <section v-if="!projects" class="max-w-7xl mx-auto py-4 mt-6">
        <h2 class="text-2xl text-center font-bold mb-4">Explore by Categories</h2>
        <div v-if="categories.length > 0" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <template v-for="category in categories" :key="category.id">
                <Link :href="FrontController.welcome({query: {category_id: category.id}})">
                    <Card class="h-full">
                        <CardContent>
                            <img :src="`images/${category.image}`" alt="" />
                            <p class="text-center mt-2">{{ category.name }}</p>
                        </CardContent>
                    </Card>
                </Link>
            </template>
        </div>
    </section>

    <!-- Jobs -->
    <section v-if="!projects" class="max-w-7xl mx-auto py-4 mt-6">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Jobs</h2>
            <div v-if="jobs.length > 0" class="space-y-4">
                <Card v-for="job in jobs" :key="job.id" class="relative border-2 "
                :class="{
                    'border-amber-300' : job.application_status == 'pending',
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
                                <h4 class="my-2 text-lg font-bold">{{ job.title }}</h4>
                                <p class="font-bold mb-2">Category : {{ job.category.name }}</p>
                                <p><span class="font-bold">Description :</span> {{ job.description }}</p>
                                <div class="mt-4"></div>
                                <p><span class="font-bold">Company :</span> {{ job.company_name }}</p>
                                <p><span class="font-bold">Location :</span> {{ job.location }}</p>
                                <p><span class="font-bold">Salary :</span> {{ job.salary }}</p>
                                <p><span class="font-bold">Experience Level :</span> {{ job.experience_level }}</p>
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

                    <div class="p-4 ms-auto space-x-5">
                        <Button v-if="job.employer_faq" type="button" @click="chatBot(job.employer_id)" variant="outline">Chat with employer</Button>
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
            <div v-else class="text-center">
                <p>No jobs found</p>
            </div>
        </div>
    </section>

    <!-- Projects  -->
    <section v-if="projects" class="max-w-7xl mx-auto py-4 mt-6">
        <div>
            <h2 class="text-2xl text-center font-bold mb-4">Projects</h2>
            <div v-if="projects.length > 0" class="space-y-4 grid grid-cols-2 gap-2">
                <Card v-for="(project,index) in projects" :key="project.id" class="relative border-2 "
                :class="{
                    'border-amber-300' : project.status == 'in_progress',
                    'border-blue-300' : project.status == 'completed',
                }"
                >

                    <div class="absolute right-5 top-2 text-xs  p-1 rounded-md text-white"
                        :class="{
                            'bg-green-500' : project.status == 'completed',
                            'bg-amber-500' : project.status == 'in_progress'
                        }"
                    > {{ project.status == 'in_progress' ? 'In Progress' : 'Completed' }}</div>

                    <CardContent class="flex flex-col gap-4 ">
                        
                        <img :src="`/images/${project.thumbnail}`" alt="" class="h-44 object-cover" />

                        <div class="flex flex-col justify-between ">
                            <div>
                                <h4 class="my-2 text-lg font-bold">{{ project.title }}</h4>
                                <p class="font-bold mb-2">Start Date : {{ project.start_date ?? '--' }}</p>
                                <p><span class="font-bold">End Date :</span> {{ project.end_date ?? '--' }}</p>
                                <div class="mt-4"></div>
                                
                            </div>
                            <div class="my-5">
                                <h1 class="font-bold">
                                    Description
                                </h1>
                                <p>
                                    {{ project.description }}
                                </p>
                            </div>
                            
                        </div>
                    </CardContent>

                    <div class="flex justify-end pe-5">
                        <Switch @update:modelValue="updateTurnOff(project.id)"/>
                    </div>
                    <!-- Input area -->
                    <footer v-if="!turnOffComment.includes(project.id)" class="p-4 border-t bg-surface">
                        <form   class="flex items-start gap-3">

                        <div class="flex-1">
                            <textarea
                            rows="2"
                            @input="(e:any) => addcomment(e.target.value, project.id)"
                            placeholder="Write a comment..."
                            class="w-full resize-none rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary"
                            ></textarea>

                            <div class="mt-2 flex items-center justify-between">

                            <div class="flex items-center gap-2">
                                <button
                                type="button"
                                class="text-sm px-3 py-1 rounded-md hover:bg-gray-100"
                                >Cancel</button>
                                <button
                                type="button"
                                @click="sendcomment(project.id)"
                                class="inline-flex items-center gap-2 rounded-md px-3 py-1 bg-primary text-white disabled:opacity-50"
                                >Send</button>
                            </div>
                            </div>
                        </div>
                        </form>

                        <div class="p-4 space-y-4 max-h-96 overflow-auto">
                            <template v-for="comment in project.comments" :key="comment.id">
                                <article class="flex gap-3 border-b-2 pb-2">
                                    <div class="flex-1">
                                    <div class="flex items-center justify-between">
                                        <div>
                                        <div class="text-sm font-medium">{{ comment.user.name }}</div>
                                        <div class="text-xs text-muted-foreground">{{ comment.comment_at }}</div>
                                        </div>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-800">{{ comment.comment }}</p>

                                    <!-- nested replies -->
                                    
                                    </div>
                                </article>
                            </template>

                            <div v-if="project.comments.length == 0" class="text-center text-sm text-muted-foreground py-8">
                            No comments yet — be the first to start the conversation.
                            </div>
                        </div>
                    </footer>
                    
                </Card>
            </div>
            <div v-else class="text-center">
                <p>No jobs found</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <Footer />
</template>
