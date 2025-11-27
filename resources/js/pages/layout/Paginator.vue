<script setup lang="ts">
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationNext,
    PaginationPrevious
} from '@/components/ui/pagination'

import { router } from '@inertiajs/vue3'

const props = defineProps<{
    routeName: string,
    meta: any,
    qValue?: string,
}>();

const currentPage = props.meta.current_page

const goToPage = (page: number) => {
    router.get(props.routeName, { page, ...(props.qValue ? { q: props.qValue } : {}), }, {
        preserveScroll: true,
        preserveState: true,
    })
}

</script>
<template>
    <Pagination v-slot="{ page }" :items-per-page="props.meta.per_page" :total="props.meta.total"
        :default-page="currentPage" v-if="props.meta.total > props.meta.per_page">
        <PaginationContent v-slot="{ items }">
            <PaginationPrevious @click="goToPage(currentPage - 1)" />
            <PaginationEllipsis v-if="props.meta.current_page > 3" />
            <template v-for="(item, index) in items" :key="index">
                <PaginationItem v-if="item.type === 'page'" :value="item.value" :is-active="item.value === page"
                    @click="goToPage(item.value)">
                    {{ item.value }}
                </PaginationItem>
            </template>
            <PaginationEllipsis v-if="props.meta.last_page > 5 && props.meta.current_page < 4" />
            <PaginationNext @click="goToPage(props.meta.current_page + 1)" />
        </PaginationContent>
    </Pagination>
</template>

<style scoped></style>