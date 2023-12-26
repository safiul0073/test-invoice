<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PageHeader from "@/Components/PageHeader.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import { ref } from "vue";
const props = defineProps({
    products: {
        type: Object,
        default: () => ({}),
    },
    users: {
        type: Array,
        default: () => [],
    },
});

const itemList = ref([]);

const form = useForm({
    user_id: "",
    items: [],
});

const submit = () => {
    form.items = itemList.value.map(item => ({
        product_id: item.productId,
        quantity: item.quantity
    }))
    form.post(route("invoice.store"));
};

const selectAProduct = (product) => {
    let found = itemList.value.find((item) => item.productId === product.id);
    if (found) return;
    itemList.value.push({
        productId: product.id,
        name: product.name,
        quantity: 1,
        price: product.price,
    });
};

const changeQuantity = (type, id) => {
    itemList.value.map((item) => {
        if (id === item.productId) {
            if (type === "plus") {
                item.quantity = Number(item.quantity) + 1;
            } else {
                item.quantity = Number(item.quantity) - 1;
            }
        }

        return item;
    });
};
</script>

<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <page-header
                title="Invoice"
                :linkItem="{
                    route: 'invoice.index',
                    title: 'List',
                }"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-4">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    >
                        <thead
                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                        >
                            <tr>
                                <th scope="col" class="px-6 py-3">Id</th>
                                <th scope="col" class="px-6 py-3">Name</th>
                                <th scope="col" class="px-6 py-3">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700"
                                v-for="item in props.products.data"
                                :key="item.id"
                                @click="selectAProduct(item)"
                                :class="
                                    itemList.find(
                                        (product) => product.id === item.id
                                    )
                                        ? 'bg-slate-300'
                                        : ''
                                "
                            >
                                <td>{{ item.id }}</td>
                                <td>{{ item.name }}</td>
                                <td>{{ item.price }}</td>
                            </tr>
                        </tbody>
                    </table>
                    <form
                        @submit.prevent="submit"
                        enctype="multipart/form-data"
                    >
                        <div>
                            <InputLabel for="user" value="User" />

                            <select
                                id="user"
                                class="mt-1 block w-full"
                                v-model="form.user_id"
                                required
                            >
                                <option value="" disabled selected>
                                    Select A User
                                </option>
                                <option
                                    v-for="item in props.users"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                </option>
                            </select>

                            <InputError
                                class="mt-2"
                                :message="form.errors.user_id"
                            />
                        </div>

                        <ul class="my-4">
                            <li v-for="item in itemList" :key="item.productId">
                                <div class="flex justify-between items-center">
                                    <h1>{{ item.name }}</h1>
                                    <h1>{{ item.price }}</h1>
                                    <h1>{{ item.quantity }}</h1>
                                    <div class="flex flex-row gap-3">
                                        <div
                                            class="text-xl p-2 rounded-full cursor-pointer text-white border border-gray-400 bg-green-700"
                                            @click="
                                                changeQuantity(
                                                    'plus',
                                                    item.productId
                                                )
                                            "
                                        >
                                            +
                                        </div>
                                        <div
                                            class="text-xl p-2 rounded-full cursor-pointer text-white border border-gray-400 bg-yellow-700"
                                            @click="
                                                changeQuantity(
                                                    'minus',
                                                    item.productId
                                                )
                                            "
                                        >
                                            -
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Save
                        </PrimaryButton>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
