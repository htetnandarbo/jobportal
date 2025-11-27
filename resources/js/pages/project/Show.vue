<template>
  <div class="max-w-2xl mx-auto p-4">
    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-md overflow-hidden">
      <header class="flex items-center justify-between p-4 border-b">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center text-sm font-medium text-gray-700">WP</div>
          <div>
            <h3 class="text-sm font-semibold">Comments</h3>
            <p class="text-xs text-muted-foreground">Be respectful — keep it constructive.</p>
          </div>
        </div>
        <div class="text-xs text-muted-foreground">12 replies</div>
      </header>

      <!-- Comments list -->
      <div class="p-4 space-y-4 max-h-96 overflow-auto">
        <template v-for="comment in comments" :key="comment.id">
          <article class="flex gap-3">
            <img :src="comment.avatar" alt="avatar" class="w-10 h-10 rounded-full object-cover" />
            <div class="flex-1">
              <div class="flex items-center justify-between">
                <div>
                  <div class="text-sm font-medium">{{ comment.name }}</div>
                  <div class="text-xs text-muted-foreground">{{ comment.when }}</div>
                </div>
                <div class="flex items-center gap-2">
                  <button class="text-xs px-2 py-1 rounded-md hover:bg-gray-100">Reply</button>
                  <button class="text-xs px-2 py-1 rounded-md hover:bg-gray-100">Like ({{ comment.likes }})</button>
                </div>
              </div>
              <p class="mt-2 text-sm text-gray-800">{{ comment.text }}</p>

              <!-- nested replies -->
              <div v-if="comment.replies?.length" class="mt-3 pl-12 space-y-3">
                <div v-for="r in comment.replies" :key="r.id" class="flex gap-3">
                  <img :src="r.avatar" alt="avatar" class="w-8 h-8 rounded-full object-cover" />
                  <div>
                    <div class="text-xs font-medium">{{ r.name }} <span class="text-muted-foreground">· {{ r.when }}</span></div>
                    <div class="text-sm">{{ r.text }}</div>
                  </div>
                </div>
              </div>
            </div>
          </article>
        </template>

        <div v-if="!comments.length" class="text-center text-sm text-muted-foreground py-8">
          No comments yet — be the first to start the conversation.
        </div>
      </div>

      <!-- Input area -->
      <footer class="p-4 border-t bg-surface">
        <form @submit.prevent="sendComment" class="flex items-start gap-3">
          <img :src="currentUser.avatar" alt="me" class="w-10 h-10 rounded-full object-cover" />

          <div class="flex-1">
            <textarea
              v-model="newComment"
              rows="2"
              placeholder="Write a comment..."
              class="w-full resize-none rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary"
            ></textarea>

            <div class="mt-2 flex items-center justify-between">
              <div class="flex items-center gap-2">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                  <input type="file" @change="onAttach" class="hidden" ref="fileInput" />
                  <button type="button" @click="$refs.fileInput.click()" class="text-sm px-2 py-1 rounded-md hover:bg-gray-100">Attach</button>
                </label>
                <button type="button" @click="toggleEmoji" class="text-sm px-2 py-1 rounded-md hover:bg-gray-100">😊</button>
                <div v-if="attachmentName" class="text-xs text-muted-foreground">{{ attachmentName }}</div>
              </div>

              <div class="flex items-center gap-2">
                <button
                  type="button"
                  @click="cancel"
                  class="text-sm px-3 py-1 rounded-md hover:bg-gray-100"
                >Cancel</button>

                <button
                  :disabled="!canSend"
                  class="inline-flex items-center gap-2 rounded-md px-3 py-1 bg-primary text-white disabled:opacity-50"
                >Send</button>
              </div>
            </div>
          </div>
        </form>

        <!-- Simple emoji picker -->
        <div v-if="showEmoji" class="mt-3 grid grid-cols-8 gap-2 p-2 border rounded-lg bg-white">
          <button v-for="e in emojis" :key="e" type="button" @click="addEmoji(e)" class="p-1 rounded">{{ e }}</button>
        </div>
      </footer>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref, reactive, computed } from 'vue'

const currentUser = reactive({
  id: 1,
  name: 'You',
  avatar: 'https://i.pravatar.cc/100?img=12',
})

const comments = ref([
  {
    id: 1,
    name: 'Aye Aye',
    avatar: 'https://i.pravatar.cc/100?img=5',
    when: '2h ago',
    text: 'This looks great! Could you add a dark mode?',
    likes: 3,
    replies: [
      {
        id: 11,
        name: 'Win Pyae',
        avatar: 'https://i.pravatar.cc/100?img=8',
        when: '1h ago',
        text: 'Yes — I can sketch a version!',
      },
    ],
  },
  {
    id: 2,
    name: 'Ko Zin',
    avatar: 'https://i.pravatar.cc/100?img=7',
    when: '3d ago',
    text: 'Nice component, clean styles!',
    likes: 1,
    replies: [],
  },
])

const newComment = ref('')
const attachmentName = ref('')
const showEmoji = ref(false)
const emojis = ['😀','😊','👍','🔥','🎉','🤔','🙏','😅']

const fileInput = ref(null)

function onAttach(e) {
  const file = e.target.files?.[0]
  if (file) {
    attachmentName.value = file.name
  }
}

function toggleEmoji() {
  showEmoji.value = !showEmoji.value
}

function addEmoji(e) {
  newComment.value += e
  showEmoji.value = false
}

function sendComment() {
  if (!newComment.value.trim()) return

  const payload = {
    id: Date.now(),
    name: currentUser.name,
    avatar: currentUser.avatar,
    when: 'just now',
    text: newComment.value,
    likes: 0,
    replies: [],
  }

  comments.value.unshift(payload)
  newComment.value = ''
  attachmentName.value = ''
}

function cancel() {
  newComment.value = ''
  attachmentName.value = ''
}

const canSend = computed(() => newComment.value.trim().length > 0 || attachmentName.value)
</script>

<style scoped>
/* Example token classes for shadcn-like color names — adapt to your theme */
.bg-surface { background-color: #f9fafb; }
.text-muted-foreground { color: #6b7280; }
.bg-primary { background-color: #0f766e; }
.focus\:ring-primary { box-shadow: 0 0 0 3px rgba(15,118,110,0.12); }
</style>
