<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import PageHeader from "@/Components/PageHeader.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    variants: {
        type: Array,
        default: () => [],
    },
    groups: {
        type: Array,
        default: () => [],
    },
});

const form = useForm({
    name: "",
    price: "",
    description: "",
    group_id: "",
    variant_ids: [],
    images: [],
});

const submit = () => {
    form.post(route("product.store"));
};

const onChange = (e) => {
    form.images.push(e.target.files[0]);
};

const onSelected = (e) => {
    form.variant_ids.push(e.target.value);
};
</script>

<template>
    <Head title="Product" />

    <AuthenticatedLayout>
        <template #header>
            <page-header
                title="Product"
                :linkItem="{
                    route: 'product.index',
                    title: 'List',
                }"
            />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <form @submit.prevent="submit" enctype="multipart/form-data">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="price" value="Price" />

                        <TextInput
                            id="price"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.price"
                            required
                            autofocus
                            autocomplete="price"
                        />

                        <InputError class="mt-2" :message="form.errors.price" />
                    </div>

                    <div>
                        <InputLabel for="group" value="Group" />

                        <select
                            id="group"
                            class="mt-1 block w-full"
                            v-model="form.group_id"
                            required
                        >
                            <option value="" disabled selected>
                                Select A Group
                            </option>
                            <option
                                v-for="item in props.groups"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>

                        <InputError
                            class="mt-2"
                            :message="form.errors.group_id"
                        />
                    </div>

                    <div>
                        <InputLabel for="variant" value="Variant" />

                        <select
                            id="variant"
                            class="mt-1 block w-full"
                            @change="onSelected($event)"
                            required
                        >
                            <option value="" disabled selected>
                                Select A Group
                            </option>
                            <option
                                v-for="item in props.variants"
                                :key="item.id"
                                :value="item.id"
                            >
                                {{ item.name }}
                            </option>
                        </select>

                        <InputError
                            class="mt-2"
                            :message="form.errors.variants_id"
                        />
                    </div>
                    <div>
                        <InputLabel for="images" value="Images" />

                        <input
                            type="file"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            @change="onChange"
                        />

                        <InputError
                            class="mt-2"
                            :message="form.errors.images"
                        />
                    </div>
                    <div>
                        <InputLabel for="description" value="Description" />

                        <textarea
                            v-model="form.description"
                            id="description"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-full"
                            rows="5"
                        ></textarea>

                        <InputError
                            class="mt-2"
                            :message="form.errors.description"
                        />
                    </div>
                    <div class="flex items-center justify-end mt-4">
                        <PrimaryButton
                            class="ms-4"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                        >
                            Save
                        </PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
