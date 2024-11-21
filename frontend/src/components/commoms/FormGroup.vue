<template>
    <div class="mb-4">
        <label :for="id" class="block text-sm font-semibold text-gray-700">{{ label }}</label>

        <template v-if="type === 'textarea'">
            <textarea :id="id" v-model="inputValue" :placeholder="placeholder" :class="{ 'border-red-500': error }"
                class="w-full p-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400 resize-none"></textarea>
        </template>

        <template v-else-if="type === 'select'">
            <select :id="id" v-model="inputValue" :class="{ 'border-red-500': error }"
                class="w-full p-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option disabled value="">Selecione uma opção</option>
                <option v-for="(option, index) in options" :key="index" :value="option">{{ option }}</option>
            </select>
        </template>

        <template v-else-if="type === 'radio'">
            <div class="flex flex-col mt-2 space-y-2">
                <label v-for="(option, index) in options" :key="index" class="inline-flex items-center space-x-2">
                    <input type="radio" :id="`${id}-${index}`" :value="option" v-model="inputValue"
                        class="form-radio text-blue-500 focus:ring focus:ring-blue-400" />
                    <span>{{ option }}</span>
                </label>
            </div>
        </template>

        <template v-else>
            <input :type="type" :id="id" v-model="inputValue" :placeholder="placeholder"
                :class="{ 'border-red-500': error }"
                class="w-full p-2 mt-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-400" />
        </template>

        <span v-if="error" class="text-xs text-red-500 mt-1">{{ error }}</span>
    </div>
</template>

<script>
export default {
    props: {
        label: String,
        id: String,
        modelValue: [String, Number],
        placeholder: String,
        error: String,
        type: {
            type: String,
            default: 'text',
        },
        options: {
            type: Array,
            default: () => [],
        },
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
};
</script>
