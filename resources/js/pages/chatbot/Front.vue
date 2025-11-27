<template>
  <div class="min-h-screen bg-slate-50 p-6">
    <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-4 gap-6">
      <!-- Middle: Messages area -->
      <main class="lg:col-span-3 grid grid-rows-[auto,1fr,auto]">
        <Card class="h-full flex flex-col">
          <!-- Header -->
          <CardHeader class="border-b">
            <div class="flex items-center justify-between gap-4">
              <div class="flex items-center gap-4">
                <Link variant="ghost" size="icon" :href="FrontController.welcome().url">
                  <ChevronLeft />
                </Link>
                <div>
                  <p class="font-semibold">{{ user.name }}</p>
                </div>
              </div>

              <div class="flex items-center gap-2">
                <Button variant="ghost" size="icon" title="Call">
                  <Phone />
                </Button>
                <Button variant="ghost" size="icon" title="More">
                  <MoreVertical />
                </Button>
              </div>
            </div>
          </CardHeader>

          <!-- Messages -->
          <CardContent class="p-6 overflow-auto" ref="messageList">
            <div class="space-y-6">
              <!-- Date divider -->
              <div class="flex items-center justify-center">
                <span class="bg-slate-100 text-xs px-3 py-1 rounded-full">Today</span>
              </div>

              <template v-if="chats">
                <!-- Received message -->
                <div class="flex items-start gap-3">
                  <!-- :src="`/images/${payment.voucher_image}`" -->
                  <Avatar size="sm"><img src="/images/chatbot.png" alt="Anna"/></Avatar>
                  <div>
                    <div class="bg-sky-600 text-white p-3 rounded-xl shadow-sm max-w-prose">
                      <p class="text-sm">{{ chats.data[0].question }}</p>
                    </div>
                  </div>
                </div>

                <!-- Sent message -->
                <div class="flex items-end justify-end">
                  <div class="text-right">
                    <div v-for="option in chats.data[0].faq_options" :key="option.id" class="block my-3 border border-gray-800 cursor-pointer px-3 py-1 rounded-xl shadow-sm max-w-prose">
                      <p class="text-sm" @click="selectOption(option.id)">{{ option.option_text }}</p>
                    </div>
                  </div>
                </div>

                <!-- Typing indicator -->
                <div v-if="typing" class="flex items-start gap-3">
                  <Avatar size="sm"><img src="/images/chatbot.png" alt="Anna"/></Avatar>
                  <div class="bg-white p-2 rounded-xl shadow-sm">
                    <div class="flex gap-1 items-center px-2 py-1">
                      <span class="dot h-2 w-2 rounded-full animate-pulse bg-slate-500"></span>
                      <span class="dot h-2 w-2 rounded-full animate-pulse bg-slate-500 delay-150"></span>
                      <span class="dot h-2 w-2 rounded-full animate-pulse bg-slate-500 delay-300"></span>
                    </div>
                  </div>
                </div>

                <!-- Received message -->
                <div v-if="!typing" class="flex items-start gap-3">
                  <Avatar v-if="answer" size="sm"><img src="/images/chatbot.png" alt="Anna"/></Avatar>
                  <div v-if="answer">
                    <div  class="bg-sky-600 text-white p-3 rounded-xl shadow-sm max-w-prose">
                      <p class="text-sm">{{ answer?.answer_text }}</p>
                    </div>
                  </div>
                </div>

                <div v-if="answer && !typing" class="flex items-end justify-end">
                  <div class="text-right">
                    <div  class="block my-3 border border-gray-800 cursor-pointer px-3 py-1 rounded-xl shadow-sm max-w-prose">
                      <p class="text-sm" @click="nextQuestion()">Continue</p>
                    </div>
                  </div>
                </div>
              </template>
            </div>
          </CardContent>

        </Card>
      </main>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, onMounted, nextTick } from 'vue';
import { Card, CardHeader, CardContent, CardFooter } from '@/components/ui/card';
import { Avatar } from '@/components/ui/avatar';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Plus, ChevronLeft, Phone, MoreVertical, Paperclip, Check } from 'lucide-vue-next';
import { Link, useForm } from '@inertiajs/vue3';
import ChatBotController from '@/actions/App/Http/Controllers/ChatBotController';
import FrontController from '@/actions/App/Http/Controllers/FrontController';

const message = ref('');
const typing = ref(false);
const messageList = ref(null);

function goBack(){
  // your navigation logic
  history.back();
}

function attachFile(){
  // open file picker
  alert('Attach file (implement)');
}

function sendMessage(){
  if(!message.value.trim()) return;
  // push message to list (mock)
  // In real app, emit to server (WebSocket) or post to API
  message.value = '';
  typing.value = false;
  // scroll to bottom
  nextTick(() => {
    if(messageList.value) messageList.value.scrollTop = messageList.value.scrollHeight;
  });
}

onMounted(() => {
  // mock typing indicator
  // setTimeout(() => { typing.value = true; }, 1500);
  typing.value = true;
  setTimeout(() => { typing.value = false; }, 2000);
});

const props = defineProps({
  chats : Array,
  user : Object,
  answer : Object
})

const selectOption = (optionId) => 
{
    useForm({employer_id: props.user.id, option_id: optionId, order: props.chats.data[0].order}).submit(ChatBotController.show(props.user.id));
}

const nextQuestion = () => {
  useForm({employer_id: props.user.id, order: props.chats.data[0].order + 1}).submit(ChatBotController.show(props.user.id));
}
</script>

<style scoped>
.max-w-prose { max-width: 60ch; }
.text-muted-foreground { color: rgba(100,100,110,0.85); }
.dot { opacity: 0.9; }
</style>
