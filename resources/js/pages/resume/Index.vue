<template>
  <Head title="Your Resume" />

    <AppLayout>
      <div class="flex justify-end">
          
      </div>
      <div class="max-w-4xl mx-auto p-6 space-y-6">
        <div class="flex justify-end">
        <Link
        v-if="hideButton"
          :href="previousUrl" >
            <Button
                class="ms-auto mb-5 cursor-pointer rounded-2xl  text-white shadow-sm shadow-amber-50 transition-all  sm:w-auto"
                >
                 <ArrowLeft></ArrowLeft>Back
              </Button>
        </Link>

        <Link
          v-if="!hideButton"
          :href="
            resume ? 
            ResumeController.edit(resume?.id).url
            :
            ResumeController.create().url" >
            <Button
                class="ms-auto mb-5 cursor-pointer rounded-2xl bg-amber-500 text-white shadow-sm shadow-amber-50 transition-all hover:bg-amber-600 hover:shadow-sm hover:shadow-amber-300 sm:w-auto"
                >
                {{ resume?.id ? 'Update' : 'Add New' }} <PlusIcon></PlusIcon
            ></Button>
        </Link>

        </div>

        <template v-if="resume">
          <!-- Header Section -->
          <Card class="shadow-md p-6 space-y-2">
            <div class="w-40 h-40 rounded-full ms-auto overflow-hidden">
              <img :src="`/images/${resume.image}`" alt="" class="w-full h-full object-cover">
            </div>

            <h1 class="text-3xl font-bold">{{ resume.name }}</h1>
            <p class="text-lg text-gray-600">{{ resume.title }}</p>
            <p class="text-gray-500">📍 {{ resume.location }}</p>

            <div class="flex gap-4 mt-4 flex-wrap">
              <Badge variant="secondary">{{ resume.job_level }}</Badge>
              <Badge variant="secondary">{{ resume.job_type }}</Badge>
              <Badge variant="secondary">{{ resume.experience_years }} yrs experience</Badge>
              <Badge variant="secondary">Expected: {{ resume.expected_salary }} MMK</Badge>
            </div>
          </Card>

          <!-- Summary -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Summary</h2>
            <p class="text-gray-700 leading-relaxed">{{ resume.summary }}</p>
          </Card>

          <!-- Skills -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Skills</h2>
            <div class="flex flex-wrap gap-2">
              <Badge v-for="(skill, index) in resume.skills" :key="index" class="text-sm">{{ skill.name }}</Badge>
            </div>
          </Card>

          <!-- Languages -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Languages</h2>
            <ul class="list-disc list-inside space-y-1">
              <li v-for="(lang, index) in resume.languages" :key="index">{{ lang.name }}</li>
            </ul>
          </Card>

          <!-- Education -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Education</h2>
            <div v-for="(edu, index) in resume.education" :key="index" class="mb-4">
              {{ edu.name }}
            </div>
          </Card>

          <!-- Certifications -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Certifications</h2>
            <ul class="list-disc list-inside space-y-1">
              <li v-for="(cert, index) in resume.certifications" :key="index">{{ cert.name }}</li>
            </ul>
          </Card>

          <!-- Social Links -->
          <Card class="shadow p-6">
            <h2 class="text-xl font-semibold mb-2">Contact</h2>
            <div class="flex flex-col gap-2">
              <ul class="list-disc list-inside space-y-1">
                <li v-for="(url, index) in resume.social" :key="index">{{ url.name }}</li>
              </ul>
            </div>
          </Card>
        </template>

        
      </div>

      <template v-if="!resume">
          <h1 class="max-w-4xl  p-6 space-y-6">Create your resume</h1>
        </template>
    </AppLayout>
</template>

<script setup lang="ts">
import { Card } from "@/components/ui/card";
import { Badge } from "@/components/ui/badge";
import { Head, Link } from "@inertiajs/vue3";
import AppLayout from "@/layouts/AppLayout.vue";
import Button from "@/components/ui/button/Button.vue";
import ResumeController from "@/actions/App/Http/Controllers/ResumeController";
import { ArrowLeft, PlusIcon } from "lucide-vue-next";

// // Example data — replace with real resume data from backend
// const resume = {
//   name: "John Doe",
//   title: "Senior Web Developer",
//   summary: "Experienced developer with strong background in Vue, Laravel, and modern UI frameworks.",
//   experience_years: 5,
//   expected_salary: "800000",
//   job_level: "senior",
//   job_type: "full-time",
//   location: "Yangon, Myanmar",
//   skills: ["Vue.js", "Laravel", "Tailwind", "MySQL", "REST APIs"],
//   languages: ["English", "Myanmar"],
//   education: [
//     { degree: "B.C.Sc Computer Science", school: "UCSY", year: "2019" }
//   ],
//   certifications: ["Google UX Certificate", "Laravel Advanced Certificate"],
//   social_links: {
//     Facebook: "https://facebook.com/username",
//     LinkedIn: "https://linkedin.com/in/username",
//     GitHub: "https://github.com/username"
//   }
// };

const props = defineProps({
  resume: {
    type: Array
  },
  hideButton: {
    type: Boolean
  },
  previousUrl: {
    type: String
  }
})
</script>
