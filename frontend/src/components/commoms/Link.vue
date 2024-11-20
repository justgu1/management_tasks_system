<template>
    <a :href="href" class="w-full py-2 text-gray-600 rounded-md hover:text-blue-900 focus:outline-none">
    {{ text }}
</a>
</template>

<script>
export default {
    name: "button",
    props: {
        text: String,
        href: String,
    }
}
</script>