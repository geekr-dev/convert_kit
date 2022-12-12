<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Head from '@inertiajs/inertia-vue3';

let props = defineProps({
    model: {
        type: Object,
        default: () => ({}),
    }
});
</script>

<template>

    <Head title="Broadcast Preview" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ model.subject }}
            </h2>
        </template>
        <div v-html="model.content" class="py-12 max-w-7xl mx-auto"></div>
    </AuthenticatedLayout>
</template>
    