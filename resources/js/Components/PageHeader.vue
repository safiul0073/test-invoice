<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    title: {
        type: String,
        default: "Header",
    },
    linkItem: {
        type: [Object],
        default: {},
    },
});
</script>

<template>
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ props.title }}
        </h2>
        <Link
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
            v-if="props.linkItem"
            :href="route(linkItem.route)"
        >
            {{ props.linkItem.title }}
        </Link>
    </div>
</template>
