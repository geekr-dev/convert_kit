<script>
import { v4 as uuid } from 'uuid'

export default {
    inheritAttrs: false,
    props: {
        id: {
            type: String,
            default() {
                return `select-input-${uuid()}`
            },
        },
        error: String,
        label: String,
        isMultiple: Boolean,
        modelValue: [String, Number, Boolean],
    },
    emits: ['update:modelValue'],
    data() {
        return {
            selected: this.modelValue,
        }
    },
    mounted: () => {
        console.log("is_multiple:" + this.isMultiple);
    },
    watch: {
        selected(selected) {
            this.$emit('update:modelValue', selected)
        },
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
    },
}
</script>

<template>
    <label v-if="label" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ label }}</label>
    <select v-if="isMultiple" :id="id" ref="input" v-model="selected" v-bind="{ ...$attrs, class: null }"
        :class="$attrs.class" multiple>
        <slot />
    </select>
    <select v-else :id="id" ref="input" v-model="selected" v-bind="{ ...$attrs, class: null }" :class="$attrs.class">
        <slot />
    </select>
    <div v-if="error" class="text-sm text-red-600">{{ error }}</div>
</template>