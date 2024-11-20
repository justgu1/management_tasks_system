<template>
    <button type="submit"
        class="w-full p-3 bg-blue-600 mb-3 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
        {{ text }}
    </button>
</template>

<script>
export default {
    name: "button",
    props: {
        text: String,
    }
}
</script>