import { useForm } from "@inertiajs/vue3";
import { watch } from "vue";
import { Ref } from "vue";

export function useBasicSearch(url: string, q: Ref<string>) {
    const basicSearch = (newValue: string) => {
        const form = useForm({
            q: newValue
        })
        form.submit('get', url, {
            preserveScroll: true,
            preserveState: true,
        })
    }

    let debounceTimer: ReturnType<typeof setTimeout> | null = null;
    watch(q, (newValue) => {
        if (debounceTimer) {
            clearTimeout(debounceTimer);
        }
        debounceTimer = setTimeout(() => {
            basicSearch(newValue);
        }, 1000);
    })
}