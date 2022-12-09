<script setup>
import Dropdown from '@/Components/Dropdown.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import SelectInput from '@/Components/SelectInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { computed, onMounted } from '@vue/runtime-core';
import Textarea from '@/Components/Textarea.vue';

let props = defineProps({
    model: {
        type: Object,
        default: () => ({}),
    }
});

let headTitle = computed(() => { return props.model.id > 0 ? "Create Broadcast" : "Edit Broadcast #" + props.model.id; })

const form = useForm({
    id: props.model.id,
    subject: props.model.subject,
    content: props.model.content,
    form_ids: props.model.form_ids,
    tag_ids: props.model.tag_ids,
});

const submit = () => {
    if (props.model.id > 0) {
        form.put(route('broadcasts.update', props.model.id))
    } else {
        form.post(route('broadcasts.store'));
    }
};
</script>


<template>

    <Head title="Broadcast Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Broadcast Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <label for="Subject"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Subject</label>
                                <TextInput type="text" v-model="form.subject" name="subject"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" />
                                <div v-if="form.errors.subject" class="text-sm text-red-600">
                                    {{ form.errors.subject }}
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="Content"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Content</label>
                                <Textarea v-model="form.content" name="content"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full h-auto p-2.5"
                                    placeholder="" />
                                <div v-if="form.errors.content" class="text-sm text-red-600">
                                    {{ form.errors.content }}
                                </div>
                            </div>
                            <div class="flex mb-6">
                                <div class="w-10/12">
                                    <SelectInput v-model="form.form_ids" label="Form IDs" :error="form.errors.form_ids"
                                        :is-multiple="true" name="form_ids"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="">
                                        <option value="CA">Canada</option>
                                        <option value="US">United States</option>
                                    </SelectInput>
                                </div>
                                <div class="w-2/12"></div>
                                <div class="w-10/12">
                                    <SelectInput v-model="form.tag_ids" label="Tag IDs" :error="form.errors.tag_ids"
                                        :is-multiple="true" name="tag_ids"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="">
                                        <option value="CA">Canada</option>
                                        <option value="US">United States</option>
                                    </SelectInput>
                                </div>
                            </div>
                            <button type="submit"
                                class="text-white bg-blue-700  focus:outline-none  font-medium rounded-lg text-sm px-5 py-2.5 "
                                :disabled="form.processing" :class="{ 'opacity-25': form.processing }">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>