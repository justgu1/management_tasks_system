<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-semibold text-gray-700">{{ label }}</label>
        <input :type="type" :id="id" v-model="inputValue" :class="{ 'border-red-500': error }"
            class="w-full p-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400"
            :placeholder="placeholder" />
        <span v-if="error" class="text-xs text-red-500 mt-1">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        id: String,
        modelValue: String,
        placeholder: String,
        error: String,
        type: String
    },
    computed: {
        inputValue: {
            get() {
                return this.modelValue;
            },
            set(value) {
                this.$emit('update:modelValue', value);
            },
        },
    },
}
</script>