<template>
    <div class="card shadow-lg shadow-zinc-200 p-2 m-4 border rounded">
        <div class="pb-2 flex justify-between">
            <h2 class="text text-lg font-medium">
                {{ bucket.key }}
            </h2>
            <div
                :class="tagClass">
                Всего: {{ bucket.total_percent }}%
            </div>
        </div>
        <div class="text mt-1 mb-1 text-slate-600">
            {{ bucket.description }}
        </div>
        <div class="pt-1 flex flex-col">
            <div
                class="w-fit mb-1.5 pl-2 pr-2 p-0.5 tag rounded-full bg-slate-400 text-white">
                <div class="text">
                    Кол-во клиентов: {{ bucket.doc_count }}
                </div>
            </div>
            <div
                class="w-fit mb-1.5 pl-2 pr-2 p-0.5 tag rounded-full bg-slate-400 text-white">
                <div class="text">
                    Кол-во заказов: {{ bucket.orders.value }}
                </div>
            </div>
            <div
                class="w-fit mb-1.5 pl-2 pr-2 p-0.5 tag rounded-full bg-slate-400 text-white">
                <div class="text">
                    Сумма заказов: {{ bucket.total.value }}₽
                </div>
            </div>
            <div
                class="w-fit mb-1.5 pl-2 pr-2 p-0.5 tag rounded-full bg-slate-400 text-white">
                <div class="text">
                    Средний чек: {{ bucket.average_bill }}₽
                </div>
            </div>
        </div>

    </div>
</template>

<script setup>
import {useCardTagColorStore} from "../stores/cardTagColor.js";

const props = defineProps(['bucket'])
const cardTagColorStore = useCardTagColorStore();
const cardTagColorClass = cardTagColorStore.getTagColorClass();
const tagClass = "pl-2 pr-2 p-0.5 tag rounded-full text-white hover:text-black "
    + cardTagColorClass + ' '
    + 'hover:' + cardTagColorClass;

</script>


<style scoped>

</style>
