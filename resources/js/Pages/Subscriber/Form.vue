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
import { formatMessages } from 'esbuild';

let props = defineProps({
    model: {
        type: Object,
        default: () => ({}),
    }
});

let headTitle = computed(() => { return this.model.subscriber.id > 0 ? "Create Subscriber" : "Edit Subscriber #" + this.model.subscriber.id; })

const form = useForm({
    id: null,
    first_name: null,
    last_name: null,
    email: null,
    form_id: null,
    tag_ids: null,
    forms: null,
    tags: null,
});

if (props.model.subscriber) {
    form = {
        id: props.model.subscriber.id,
        first_name: props.model.subscriber.first_name,
        last_name: props.model.subscriber.last_name,
        email: props.model.subscriber.email,
        form_id: props.model.subscriber.form_id,
        tag_ids: props.model.subscriber.tag_ids,
        forms: props.model.forms,
        tags: props.model.tags,
    }
}

const submit = () => {
    if (this.model.subscriber.id > 0) {
        form.put(route('subscribers.update', this.model.subscriber.id))
    } else {
        form.post(route('subscribers.store'));
    }
};
</script>


<template>

    <Head title="Subscriber Create" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Subscriber Create
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="flex mb-6">
                                <div class="w-10/12">
                                    <label for="First Name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">First
                                        Name</label>
                                    <TextInput type="text" v-model="form.first_name" name="first_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="" />
                                    <div v-if="form.errors.first_name" class="text-sm text-red-600">
                                        {{ form.errors.first_name }}
                                    </div>
                                </div>
                                <div class="w-2/12"></div>
                                <div class="w-10/12">
                                    <label for="Last Name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Last
                                        Name</label>
                                    <TextInput type="text" v-model="form.last_name" name="last_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="" />
                                    <div v-if="form.errors.last_name" class="text-sm text-red-600">
                                        {{ form.errors.last_name }}
                                    </div>
                                </div>
                            </div>
                            <div class="mb-6">
                                <label for="Email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                                <TextInput type="email" v-model="form.email" name="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="" />
                                <div v-if="form.errors.email" class="text-sm text-red-600">
                                    {{ form.errors.email }}
                                </div>
                            </div>
                            <div class="flex mb-6">
                                <div class="w-10/12">
                                    <SelectInput v-model="form.form_id" label="Form ID" :error="form.errors.form_id"
                                        name="form_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                        placeholder="">
                                        <option :value="null" />
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
                                        <option :value="null" />
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