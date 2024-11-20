<script setup>
import { inject, computed } from 'vue';
import Table from '@components/commoms/Table.vue';
import api from '@utils/api';
try {
    const response = await api.get(`/task`);
    console.log(response)
} catch (error) {
    console.log(error)
}
</script>

<template>
    <div>
        tasks
    </div>
</template>
<script>
export default {
    name: "Tasks"
}
</script>