<template>
    <div v-if="pagination.total > 0" class="flex items-center justify-between m-auto mt-4 max-w-screen-lg">
        <button @click="changePage(pagination.current_page - 1)" :disabled="pagination.current_page === 1"
            class="px-4 py-2 bg-blue-400 text-white rounded-lg hover:bg-blue-500">
            Anterior
        </button>

        <div class="flex items-center space-x-2">
            <span class="text-sm text-gray-700">Página {{ pagination.current_page }} de {{ pagination.last_page
                }}</span>
        </div>

        <button @click="changePage(pagination.current_page + 1)"
            :disabled="pagination.current_page === pagination.last_page"
            class="px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-500">
            Próxima
        </button>
    </div>
</template>

<script>
export default {
    props: {
        pagination: {
            type: Object,
            required: true
        }
    },
    methods: {
        changePage(page) {
            if (page >= 1 && page <= this.pagination.last_page) {
                this.$emit('change-page', page);
            }
        }
    }
}
</script>