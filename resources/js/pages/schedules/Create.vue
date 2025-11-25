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
import { Popover, PopoverContent, PopoverTrigger } from "@/components/ui/popover";
import Calendar  from "@/components/ui/calendar/Calendar.vue";
import Input from "@/components/ui/input/Input.vue";

// Custom components 
import AppLayout from '@/layouts/AppLayout.vue';

// Type
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { computed, ref } from 'vue';
import dayjs from "dayjs";

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Schedules',
        href: '#'
    },
];

const candidate = ref("");
const scheduleDate = ref(null);

const candidates = ["Alice", "Bob", "Charlie"];

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

const handleSubmit = () => {
  console.log({
    candidate: candidate.value,
    scheduleDate: scheduleDate.value,
  });
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
                    <Label for="candidate">Select Candidate</Label>
                    <Select v-model="candidate">
                        <SelectTrigger>
                        <SelectValue placeholder="Select candidate" />
                        </SelectTrigger>
                        <SelectContent>
                        <SelectItem v-for="c in candidates" :key="c" :value="c">
                            {{ c }}
                        </SelectItem>
                        </SelectContent>
                    </Select>
                </div>

                <!-- Date & Time Picker -->
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

                <!-- Submit Button -->
                <Button type="submit">Schedule</Button>
            </form>
        </div>
    </AppLayout>
</template>
