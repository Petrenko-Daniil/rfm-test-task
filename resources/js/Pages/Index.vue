<template>
    <main class="main-content w-full pb-8 pl-2 pr-2">
        <div class="flex items-center justify-between py-5 lg:py-6">
            <div class="flex items-center space-x-1">
                <h2 class="text-xl font-medium text-slate-700 line-clamp-1 dark:text-navy-50 lg:text-2xl">
                    RFM Segments
                </h2>
            </div>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 sm:gap-5 lg:grid-cols-3 lg:gap-6">
            <Card v-for="bucket in report.aggregations.segments.buckets" :bucket="bucket"></Card>
        </div>
    </main>
</template>

<script setup>
import {usePage} from "@inertiajs/vue3";
import Card from "../Components/Card.vue"

const page = usePage();
const report = page.props.report;

console.log(report);
</script>

<style scoped>

</style>
