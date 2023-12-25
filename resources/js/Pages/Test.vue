<template>
    <div>
        <h1 class="bg-red text-red-700 ">Hello World!</h1>
        <p class=""> {{ message }}</p>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true,
        },
    },
};
</script>
