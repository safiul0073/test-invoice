<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, Link } from "@inertiajs/vue3";
import PageHeader from "@/Components/PageHeader.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/inertia-vue3";

const props = defineProps({
    invoices: {
        type: Object,
        default: () => ({}),
    },
});
const form = useForm();

function destroy(id) {
    if (confirm("Are you sure you want to Delete")) {
        form.delete(route("invoice.destroy", id));
    }
}
</script>

<template>
    <Head title="Invoice" />

    <AuthenticatedLayout>
        <template #header>
            <page-header
                title="Invoice"
                :linkItem="{
                    route: 'invoice.create',
                    title: 'Add',
                }"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div
                    v-if="$page.props?.message"
                    class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800"
                    role="alert"
                >
                    <span class="font-medium">
                        {{ $page.props?.message }}
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">User Name</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                                <th scope="col" class="px-6 py-3">Quantity</th>
                                <th scope="col" class="px-6 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                v-for="item in props.invoices.data"
                                :key="item.id"
                            >
                                <td>{{ item.id }}</td>
                                <td>{{ item.user?.name }}</td>
                                <td>{{ item.total_amount }}</td>
                                <td>{{ item.total_quantity }}</td>
                                <td>
                                    <div class="flex flex-row items-center">
                                        <Link
                                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                            :href="
                                                route('invoice.edit', item.id)
                                            "
                                        >
                                            Edit
                                        </Link>
                                        <PrimaryButton
                                            class="bg-red-700"
                                            @click="destroy(item.id)"
                                        >
                                            Delete
                                        </PrimaryButton>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
