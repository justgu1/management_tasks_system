<script setup>

const router = useRouter();
const showDescriptionMap = reactive({});

const toggleDescription = (id) => {
    showDescriptionMap[id] = !showDescriptionMap[id];
};

const getActionText = (id, action) => {
    if (action.name === 'toggle-description') {
        return showDescriptionMap[id] ? 'Menos' : 'Mais';
    }
    return action.label;
};

const handleAction = (action, item) => {
    if (action.name === 'edit') {
        router.push(`/tasks/edit/${item.id}`);
    } else if (action.name === 'delete') {
        router.push(`/tasks/delete/${item.id}`);
    } else if (action.name === 'toggle-description') {
        toggleDescription(item.id);
    }
};

const showDescription = (id) => {
    return showDescriptionMap[id] === true;
};
</script>

<template>
    <div
        class="overflow-x-auto bg-blue-200 max-w-screen-lg text-base mx-auto my-4 shadow-xl border-2 rounded-md text-blue-900 text-bold">
        <div class="flex ">
            <div v-for="(header, index) in headers" :key="index" class="flex-1 px-4 py-2 font-semibold">
                {{ header.label }}
            </div>
            <div v-if="actions" class="px-4 py-2 font-semibold flex-1">Ações</div>
        </div>

        <div v-for="(item, index) in data" :key="item.id" class="flex flex-wrap "
            :class="{ 'bg-blue-100': index % 2 === 0 }">
            <div v-for="(header, index) in headers" :key="index" class="flex-1 px-4 py-2">
                {{ item[header.key] }}
            </div>

            <div v-if="actions" class="px-4 py-2 flex-1 flex flex-wrap gap-2">
                <div v-for="action in actions" :key="action.name" class="inline-block mr-2">
                    <Button :text="getActionText(item.id, action)" @action-click="handleAction(action, item)"
                        class="px-4 py-2 mx-auto mb-0 w-min text-white rounded hover:   bg-blue-700" />
                </div>
            </div>

            <div v-if="item['description'] && showDescription(item.id)"
                class="px-4 py-2 flex-4 w-full break-words whitespace-pre-wrap mt-2">
                {{ item['description'] }}
            </div>
        </div>
    </div>
</template>

<script>
import { reactive } from 'vue';
import Button from '@components/commoms/Button.vue';
import { useRouter } from 'vue-router';

export default {
    components: {
        Button
    },
    props: {
        headers: {
            type: Array,
            required: true
        },
        data: {
            type: Array,
            required: true
        },
        actions: {
            type: Array,
            default: () => []
        }
    },
}
</script>
