<script setup lang="ts">
import { ref } from 'vue';
import { Combobox, ComboboxAnchor, ComboboxInput } from '@/components/ui/combobox';
import { Search } from 'lucide-vue-next';
import { useBasicSearch } from '@/composables/useBasicSearch';

const props = defineProps<{ 
    url: string, 
    q: string 
}>();

const q = ref(props.q);
useBasicSearch(props.url, q);
</script>

<template>
    <Combobox by="value" class="mb-3 lg:mb-0">
        <ComboboxAnchor class="w-full lg:w-3xs">
            <div class="relative w-full items-center">
                <ComboboxInput v-model="q"
                    class="w-full rounded-full border-0 bg-gray-100 pl-9 shadow-none"
                    placeholder="Search here" />
                <span class="absolute inset-y-0 start-0 flex items-center justify-center px-3">
                    <Search class="size-4 text-muted-foreground" />
                </span>
            </div>
        </ComboboxAnchor>
    </Combobox>
</template>

<style lang="scss" scoped>

</style>