<script setup>
defineProps({ 'currentPage': Number, 'hasMorePages': Boolean })
</script>

<template>
    <nav role="navigation" aria-label="Pagination Navigation" class="flex justify-between mt-2">
        <span v-if="(currentPage == 1)"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            上一页
        </span>
        <a v-else href="javascript:void(0);" rel="prev" @click="$emit('paginatedPrev')"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            上一页
        </a>

        <a v-if="hasMorePages" href="javascript:void(0);" rel="next" @click="$emit('paginatedNext')"
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-md hover:text-gray-500 focus:outline-none focus:ring ring-gray-300 focus:border-blue-300 active:bg-gray-100 active:text-gray-700 transition ease-in-out duration-150">
            下一页
        </a>
        <span v-else
            class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md">
            下一页
        </span>
    </nav>
</template>