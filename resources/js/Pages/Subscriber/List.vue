<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import BreezeButton from "@/Components/PrimaryButton.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
import { useForm } from '@inertiajs/inertia-vue3'

defineProps({
    model: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm();

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route('subscribers.destroy', id));
    }
}

function prevPage() {
    if (!this.model.subscribers.prev_page_url) {
        return;
    }
    this.$inertia.get(this.model.subscribers.prev_page_url);
}

function nextPage() {
    if (!this.model.subscribers.next_page_url) {
        return;
    }
    this.$inertia.get(this.model.subscribers.next_page_url);
}

</script>

<template>

    <Head title="Subscribers" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Subscriber List
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="mb-2">
                            <Link :href="route('subscribers.create')">
                            <BreezeButton>New Subscriber</BreezeButton>
                            </Link>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">#</th>
                                        <th scope="col" class="px-6 py-3">
                                            First Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Last Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Edit
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Delete
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="subscriber in model.subscribers.data" :key="subscriber.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ subscriber.id }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ subscriber.first_name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ subscriber.last_name }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ subscriber.email }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <Link :href="
                                                route(
                                                    'subscribers.edit',
                                                    subscriber.id
                                                )
                                            " class="px-4 py-2 text-white bg-blue-600 rounded-lg">Edit</Link>
                                        </td>
                                        <td class="px-6 py-4">
                                            <BreezeButton class="bg-red-700" @click="destroy(subscriber.id)">
                                                Delete
                                            </BreezeButton>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :current-page="model.subscribers.current_page"
                            :has-more-pages="model.subscribers.next_page_url !== null" @paginated-prev="prevPage()"
                            @paginated-next="nextPage()">
                        </Pagination>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

