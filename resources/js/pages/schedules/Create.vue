<script setup lang="ts">

// Shadcn ui 
import Button from "@/components/ui/button/Button.vue";
import Label from "@/components/ui/label/Label.vue";
import {
  Select,
  SelectTrigger,
  SelectValue,
  SelectContent,
  SelectItem
} from "@/components/ui/select";
import Calendar  from "@/components/ui/calendar/Calendar.vue";
import Input from "@/components/ui/input/Input.vue";

// Custom components 
import AppLayout from '@/layouts/AppLayout.vue';

// Type
import { type BreadcrumbItem } from '@/types';
import { Head, useForm } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import dayjs from "dayjs";
import Textarea from "@/components/ui/textarea/Textarea.vue";
import ScheduleController from "@/actions/App/Http/Controllers/ScheduleController";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Schedules',
        href: '#'
    },
];

const scheduleDate = ref(null);

const hours = Array.from({ length: 24 }, (_, i) => String(i).padStart(2, "0"));
const minutes = Array.from({ length: 60 }, (_, i) => String(i).padStart(2, "0"));
const selectedHour = ref("00");
const selectedMinute = ref("00");

// For search
const hourSearch = ref("");
const minuteSearch = ref("");

const filteredHours = computed(() =>
  hours.filter(h => h.includes(hourSearch.value))
);

const filteredMinutes = computed(() =>
  minutes.filter(m => m.includes(minuteSearch.value))
);





const props = defineProps({
    candidates: {
        type: Array,
        required: true
    }
})

const form = useForm({
    candidate_id: '',
    scheduleDate: '',
    description: ''
})

const handleSubmit = () => {
    form.scheduleDate = scheduleDate.value ? dayjs(scheduleDate.value).format('YYYY-MM-DD') + ' ' + selectedHour.value + ':' + selectedMinute.value : '';
    form.submit(ScheduleController.store());
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
           <form @submit.prevent="handleSubmit" class="space-y-4 max-w-md">
                <!-- Select Candidate -->
                <div>
                    <Label for="candidate" class="mb-3">Select Candidate</Label>
                    <Select v-model="form.candidate_id">
                        <SelectTrigger>
                        <SelectValue placeholder="Select candidate" />
                        </SelectTrigger>
                        <SelectContent>
                        <SelectItem v-for="candidate in candidates" :key="candidate.id" :value="candidate.id">
                            {{ candidate.name }}
                        </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <!-- Date & Time Picker -->
                <Label for="scheduleDate" class="mb-3">Interview Date & Time</Label>

                <Input
                    readonly
                    placeholder="Pick date & time"
                    :value="scheduleDate ? dayjs(scheduleDate).format('YYYY-MM-DD') + ' ' + selectedHour + ':' + selectedMinute : ''"
                />

                <div>
                    <!-- Calendar -->
                    <Calendar v-model="scheduleDate" class="mb-4" />

                    <div class="flex space-x-2">
                    <!-- Hour -->
                    <div class="flex-1">

                        <Label class="mb-3">Hour</Label>
                        <Select v-model="selectedHour">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="HH" />
                        </SelectTrigger>
                        <SelectContent>
                            <input
                            type="text"
                            v-model="hourSearch"
                            placeholder="Search hour"
                            class="w-full px-2 py-1 border-b mb-2"
                            />
                            <SelectItem v-for="h in filteredHours" :key="h" :value="h">{{ h }}</SelectItem>
                        </SelectContent>
                        </Select>
                    </div>

                    <!-- Minute -->
                    <div class="flex-1">
                        <Label class="mb-3">Minute</Label>
                        <Select v-model="selectedMinute">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="MM" />
                        </SelectTrigger>
                        <SelectContent>
                            <input
                            type="text"
                            v-model="minuteSearch"
                            placeholder="Search minute"
                            class="w-full px-2 py-1 border-b mb-2"
                            />
                            <SelectItem v-for="m in filteredMinutes" :key="m" :value="m">{{ m }}</SelectItem>
                        </SelectContent>
                        </Select>
                    </div>
                    </div>

                </div>

                <div>
                    <Label class="block text-sm font-medium text-gray-700 mb-1">Description</Label>
                    <Textarea v-model="form.description" placeholder="Enter interview description" rows="3" />
                </div>

                <!-- Submit Button -->
                <Button type="submit">Schedule</Button>
            </form>
        </div>
    </AppLayout>
</template>
