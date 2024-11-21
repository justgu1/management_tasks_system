<script setup>
import { inject, computed, ref, onMounted } from 'vue';
import Table from '@components/commoms/Table.vue';
import Pagination from '@components/commoms/Pagination.vue';
import api from '@utils/api';
const tasks = ref([]);
const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
    next_page_url: null,
    prev_page_url: null,
});
const actions = ref([
    { name: 'edit', label: 'Editar' },
    { name: 'delete', label: 'Excluir' },
    { name: 'toggle-description', label: 'Mais' }
]);

const tableHeaders = ref([
    { label: 'ID', key: 'id' },
    { label: 'Título', key: 'title' },
    { label: 'Status', key: 'status' },
]);

const fetchTasks = async (page = 1) => {
    try {
        const response = await api.get(`/task?page=${page}`);
        console.log(response)
        tasks.value = response.data;
        pagination.value = {
            current_page: response.current_page,
            last_page: response.last_page,
            total: response.total,
            next_page_url: response.links.find(link => link.label === 'Next »')?.url || null,
            prev_page_url: response.links.find(link => link.label === '« Previous')?.url || null
        };
    } catch (error) {
        console.log(error);
    }
};

onMounted(() => {
    fetchTasks();
});

const handlePageChange = (page) => {
    fetchTasks(page);
}
</script>

<template>
    <div>
        <Table :headers="tableHeaders" :data="tasks" :actions="actions" />
        <Pagination :pagination="pagination" @change-page="handlePageChange" />
        <router-view></router-view>
    </div>
</template>
<script>
export default {
    name: "Tasks"
}
</script>