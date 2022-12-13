<script setup>
defineProps(['performance']);
</script>

<template>
    <div class="text-sm">
        {{ performance.total }} Recipients •
        {{ performance.openRate.formatted }} Open rate •
        {{ performance.clickRate.formatted }} Click rate
    </div>
</template>