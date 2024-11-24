<script setup>
import { ref, onMounted } from 'vue';
import axios from '../axios';
import ArrowUp from '/resources/images/svg/ArrowUp.svg';
import ArrowDown from '/resources/images/svg/ArrowDown.svg';
import ArrowUpInactive from '/resources/images/svg/ArrowUpInactive.svg';
import ArrowDownInactive from '/resources/images/svg/ArrowDownInactive.svg';
import ArrowToggle from '/resources/images/svg/ArrowToggle.svg';
import ZoomIcon from '/resources/images/svg/Zoom.svg';
import DeleteIcon from '/resources/images/svg/Recycle.svg';

const lists = ref([]);
const toggleList = ref({}); // Для управления состоянием раскрытия

onMounted(async () => {
    const response = await axios.get('/lists');
    lists.value = response.data;
});

const toggleSubList = (id) => {
    toggleList.value[id] = !toggleList.value[id];
};

const moveRowUp = async (index) => {
    if (index > 0) {
        await updateListNumbers(lists.value[index], lists.value[index - 1]);

        const temp = lists.value[index];
        lists.value[index] = lists.value[index - 1];
        lists.value[index - 1] = temp;
    }
};

const moveRowDown = async (index) => {
    if (index < lists.value.length - 1) {
        await updateListNumbers(lists.value[index], lists.value[index + 1]);

        const temp = lists.value[index];
        lists.value[index] = lists.value[index + 1];
        lists.value[index + 1] = temp;
    }
};

const updateListNumbers = async (listA, listB) => {
    try {
        await axios.post('/update-numbers', {
            items: [
                { id: listA.id, number: listB.number },
                { id: listB.id, number: listA.number },
            ],
        });
    } catch (error) {
        console.error('Ошибка обновления:', error);
    }
};

const deleteListItem = async (id, index) => {
    try {
        // Отправляем запрос на сервер
        await axios.delete(`/lists/${id}`);

        // Удаляем элемент из массива lists локально
        lists.value.splice(index, 1);
    } catch (error) {
        console.error('Ошибка при удалении элемента:', error);
    }
};

</script>

<template>
    <div class="pb-2 px-4 rounded-lg bg-white">
        <div class="grid grid-cols-[2fr_1fr_5fr_1fr] items-center font-semibold px-8 mb-0.5 py-4 gap-4">
            <div>Наименование</div>
            <div>Кол-во</div>
            <div class="flex items-center">
                <span class="w-36">Источник</span>
                <span class="w-36">Лазер</span>
                <span class="w-36">Сварка</span>
                <span class="w-36">Сборка</span>
                <span class="w-36">Электр</span>
            </div>
        </div>
        <div
            v-for="(list, index) in lists"
            :key="list.id"
            class="space-y-2 mb-2"
        >
            <div class="flex items-center">
                <div class="flex flex-col space-y-0.5 mr-1">
                    <button
                        @click="moveRowUp(index)" class="text-purple-500"
                        :disabled="index === 0"
                    >
                        <component
                            :is="index === 0 ? ArrowUpInactive : ArrowUp"
                            class="w-3 h-3"
                        />
                    </button>
                    <button
                        @click="moveRowDown(index)" class="text-purple-500"
                        :disabled="index === lists.length - 1"
                    >
                        <component
                            :is="index === lists.length - 1 ? ArrowDownInactive : ArrowDown"
                            class="w-3 h-3"
                        />
                    </button>
                </div>
                <div class="flex-1 rounded-lg bg-gray-100 grid grid-cols-[2fr_1fr_5fr_1fr] items-center px-1.5 py-4 gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-normal">{{ list.good_name.name }}</span>
                        <button
                            @click="toggleSubList(list.id)"
                            v-if="list.u_sub_lists && list.u_sub_lists.length > 0"
                        >
                            <ArrowToggle
                                class="w-3 h-3 text-gray-500 transform transition-transform"
                                :class="!toggleList[list.id] ? '-rotate-90' : ''"
                            />
                        </button>
                    </div>
                    <div>
                        <input
                            type="number"
                            v-model="list.quantity"
                            class="border rounded-md w-9 text-center appearance-text border-gray-300"
                        />
                    </div>
                    <div class="flex items-center">
                        <span class="w-36">{{ list.source.name }}</span>
                        <span class="w-36">{{ list.laser }}</span>
                        <span class="w-36">{{ list.welding }}</span>
                        <span class="w-36">{{ list.assembly }}</span>
                        <span class="w-36">{{ list.electric }}</span>
                    </div>
                    <div class="flex space-x-2 justify-end">
                        <button>
                            <ZoomIcon class="w-6 h-6 text-purple-500" />
                        </button>
                        <button @click="deleteListItem(list.id, index)">
                            <DeleteIcon class="w-6 h-6 text-red-500" />
                        </button>
                    </div>
                </div>
            </div>

            <div
                v-if="toggleList[list.id]"
                class="pl-8 grid gap-y-1"
            >
                <div
                    v-for="subList in list.u_sub_lists"
                    :key="subList.id"
                    class="grid grid-cols-[2fr_1fr_5fr_1fr] items-center bg-white border border-gray-300 px-4 py-2 rounded-lg"
                >
                    <div class="flex items-center space-x-4">
                        <span>
                            {{ subList.good_name.name }}
                        </span>
                    </div>
                    <div>
                        <span>
                            {{ subList.quantity }}
                        </span>
                    </div>
                    <div class="flex items-center space-x-11">
                        <span>
                            {{ subList.source.name }}
                        </span>
                        <span>
                            {{ subList.laser }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .appearance-text {
        appearance: textfield;
    }
</style>
