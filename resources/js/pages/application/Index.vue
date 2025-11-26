<script setup lang="ts">
import ApplicationController from '@/actions/App/Http/Controllers/ApplicationController';
import CategoryController from '@/actions/App/Http/Controllers/CategoryController';
import ChatBotController from '@/actions/App/Http/Controllers/ChatBotController';
import ResumeController from '@/actions/App/Http/Controllers/ResumeController';
import ScheduleController from '@/actions/App/Http/Controllers/ScheduleController';
import { Button } from '@/components/ui/button';
import { ScrollArea, ScrollBar } from '@/components/ui/scroll-area';
import {
    Table,
    TableBody,
    TableCell,
    TableHead,
    TableHeader,
    TableRow,
} from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { create as categoryCreate } from '@/routes/categories';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { PlusIcon } from 'lucide-vue-next';

// Props
defineProps<{
    applications: any;
}>();

// Delete

const seeResume = (id: string, applicationId : string) => {
    useForm({user_id: id, isHide: true, application_id : applicationId, status: 'reviewed'}).submit(ResumeController.index());
}

const acceptResume = (id: string) => {
    useForm({status: 'accepted'}).submit(ApplicationController.update(id))
}

const rejectResume = (id: string) => {
    useForm({status: 'rejected'}).submit(ApplicationController.update(id))
}

const sendSchedule = (id: string, applicationId : string, jobId: string) => {
    useForm({user_id: id, application_id: applicationId, job_id: jobId}).submit(ScheduleController.create());
}
</script>

<template>
    <Head title="Table Components" />

    <AppLayout>
        <div class="m-5">
            <div class="mb-5">
            </div>
            <div class="grid gap-5 rounded-xl border p-5">
                <div class="lg:flex lg:items-center lg:justify-between">
                    <!-- Search -->
                </div>

                <div>
                    <ScrollArea class="grid w-full grid-cols-1 overflow-auto">
                        <Table>
                            <TableHeader class="border-none bg-gray-100">
                                <TableRow class="border-none">
                                    <TableHead
                                        class="h-fit rounded-l-full py-3"
                                    >
                                        No
                                    </TableHead>
                                    <TableHead class="h-fit py-3"
                                        >Candidate</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Job</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Status</TableHead
                                    >
                                    <TableHead class="h-fit py-3"
                                        >Schedule Sent</TableHead
                                    >
                                    <TableHead
                                        class="h-fit rounded-r-full py-3"
                                    >
                                        Options 
                                    </TableHead>
                                </TableRow>
                            </TableHeader>
                            <TableBody>
                                <TableRow
                                    v-for="(application,index) in applications"
                                    :key="application.id"
                                >
                                    <TableCell
                                        class="h-fit rounded-l-full py-2"
                                    >
                                        {{ index + 1 }}
                                    </TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        application.candidate.name
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{
                                        application.job.title
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2"
                                    :class="{
                                        'text-amber-500' : application.status == 'pending',
                                        'text-blue-500' : application.status == 'reviewed',
                                        'text-green-500' : application.status == 'accepted',
                                        'text-red-500' : application.status == 'rejected'
                                    }">{{
                                        application.status
                                    }}</TableCell>
                                    <TableCell class="h-fit py-2">{{ 
                                        application.schedule_sent ? 'Schedule has sent to candidate' : "Schedule hasn't sent yet"
                                    }}</TableCell>

                                    <TableCell
                                        class="h-fit rounded-r-full py-2"
                                    >
                                        <div class="flex gap-2">
                                            <Button
                                                @click="seeResume(application.candidate_id, application.id)"
                                                size="sm"
                                                variant="outline"
                                                >Resume</Button
                                            >
                                            <Button
                                                v-if="application.status == 'accepted' && !application.schedule_sent"
                                                @click="sendSchedule(application.candidate_id, application.id, application.job_id)"
                                                size="sm"
                                                variant="outline"
                                                >Send Schedule</Button
                                            >
                                            <Button
                                                
                                                size="sm"
                                                variant="outline"
                                                @click="
                                                    acceptResume(application.id)
                                                "
                                                >Accept</Button
                                            >
                                            <Button
                                                size="sm"
                                                variant="destructive"
                                                @click="
                                                    rejectResume(application.id)
                                                "
                                                >Reject</Button
                                            >
                                        </div>
                                    </TableCell>
                                </TableRow>
                            </TableBody>
                        </Table>
                        <ScrollBar orientation="horizontal" />
                    </ScrollArea>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
