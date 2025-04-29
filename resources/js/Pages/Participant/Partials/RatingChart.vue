<script setup>
import Chart from 'primevue/chart';
import { ref, onMounted, computed } from "vue";

const props = defineProps({
    results: {
        type: Array,
        required: true
    },
})

onMounted(() => {
    options.value = setChartOptions();
    data.value = setData();
});

const footer = (tooltipItems) => {
    const delta = rev_results.value[tooltipItems[0].parsed.x].delta;
    return `Delta: ${delta < 0 ? '-' : '+'}${delta}`;
};

const rev_results = computed(() => props.results.reverse());

const options = ref();
const data = ref();

const setData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    let ratings = 0;
    const rating_changes = [];

    const rating_results = rev_results.value.map((result) => {
        ratings += result.delta;
        rating_changes.push(ratings);
        return {
            contest_date: result.contest_date,
            delta: result.delta
        }
    });

    return {
        labels: rating_results.map(x => x.contest_date),
        datasets: [
            {
                label: 'Rating',
                data: rating_changes,
                fill: false,
                tension: 0,
                borderColor: documentStyle.getPropertyValue('--color-accent'),
            }
        ]
    }
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--color-base-content');
    const surfaceBorder = documentStyle.getPropertyValue('--color-gray-500');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            },
            tooltip: {
                callbacks: {
                    footer: footer,
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColor
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColor
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
</script>
<template>
    <div class="bg-base-200 p-4 shadow-sm sm:rounded-lg sm:p-8">
        <Chart type="line" :data="data" :options="options" class="h-[30rem]" />
    </div>
</template>
