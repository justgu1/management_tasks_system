<script setup>
import { ref, onMounted } from 'vue';
import api from '@utils/api';
import { Bar, Doughnut } from 'vue-chartjs';
import { Chart as ChartJS, Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement } from 'chart.js';

ChartJS.register(Title, Tooltip, Legend, BarElement, CategoryScale, LinearScale, ArcElement);

const totalTasks = ref(0);
const authorsData = ref([]);
const statusData = ref({ pendente: 0, emAndamento: 0, concluida: 0 });

const chartAuthorsData = ref({
  labels: [],
  datasets: [{
    label: 'Tarefas por Autor',
    data: [],
    backgroundColor: 'rgba(75, 192, 192, 0.2)',
    borderColor: 'rgba(75, 192, 192, 1)',
    borderWidth: 1,
  }],
});

const chartStatusData = ref({
  labels: ['Pendente', 'Em andamento', 'Concluída'],
  datasets: [{
    label: 'Status das Tarefas',
    data: [],
    backgroundColor: [
      'rgba(255, 99, 132, 0.2)',
      'rgba(54, 162, 235, 0.2)',
      'rgba(75, 192, 192, 0.2)',
    ],
    borderColor: [
      'rgba(255, 99, 132, 1)',
      'rgba(54, 162, 235, 1)',
      'rgba(75, 192, 192, 1)',
    ],
    borderWidth: 1,
  }],
});

const fetchDashboardData = async () => {
    try {
        const response = await api.get('/task', { params: { is_dashboard: true } });
        const tasks = response.data;

        totalTasks.value = tasks.length;

        const authors = tasks.reduce((acc, task) => {
            acc[task.author] = (acc[task.author] || 0) + 1;
            return acc;
        }, {});

        chartAuthorsData.value.labels = Object.keys(authors);
        chartAuthorsData.value.datasets[0].data = Object.values(authors);

        const statusCount = tasks.reduce((acc, task) => {
            acc[task.status] = (acc[task.status] || 0) + 1;
            return acc;
        }, {});

        statusData.value = statusCount;
        chartStatusData.value.datasets[0].data = [
            statusCount.pendente || 0,
            statusCount['em andamento'] || 0,
            statusCount.concluida || 0
        ];

    } catch (error) {
        console.error('Erro ao carregar dados do dashboard:', error);
    }
};


onMounted(() => {
  fetchDashboardData();
});
</script>

<template>
  <div class="dashboard-container p-6">
    <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>

    <div class="mb-6" style="height: 60vh;" v-if="chartAuthorsData.labels.length > 0">
      <h3 class="text-lg font-semibold mb-4">Tarefas por Autor</h3>
      <Bar :data="chartAuthorsData" :options="{ responsive: true, maintainAspectRatio: false }" />
    </div>

    <div class="flex space-x-4" v-if="chartStatusData.datasets[0].data.length > 0">
      <div class="w-1/2" style="height: 40vh;">
        <h3 class="text-lg font-semibold mb-4">Distribuição das Tarefas por Status</h3>
        <Doughnut :data="chartStatusData" :options="{ responsive: true, maintainAspectRatio: false }" />
      </div>

      <div class="w-1/2" style="height: 40vh;">
        <h3 class="text-lg font-semibold mb-4">Status das Tarefas (Contagem)</h3>
        <Doughnut :data="chartStatusData" :options="{ responsive: true, maintainAspectRatio: false }" />
      </div>
    </div>
  </div>
</template>


<style scoped>
.dashboard-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}
</style>
