<template>

    <Card class="chartjs-widget flex justify-center items-center overflow-hidden" :class="{ 'p-1': activeTab.title }">

        <LoadingView
            :loading="isLoading"
            class="flex flex-col justify-center items-center w-full h-full">

            <div class="flex w-full justify-between mb-1">

                <div class="p-2 text-sm font-bold" v-if="activeTab">{{ activeTab.title }}</div>

                <div class="flex justify-end space-x-1" v-if="value.length > 1">

                    <Button
                        v-for="{ key, leadingIcon, trailingIcon, buttonTitle } of value"
                        :variant="activeTabKey === key ? 'link' : 'ghost'"
                        :leading-icon="leadingIcon"
                        :trailing-icon="trailingIcon"
                        @click="activeTabKey = key">

                        {{ buttonTitle }}

                    </Button>

                </div>

            </div>

            <div class="bg-gray-200 w-full h-full rounded overflow-hidden p-2">
                <Line :key="activeTabKey" :options="chartOptions" :data="currentValue"/>
            </div>

        </LoadingView>

    </Card>

</template>

<script>

    import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip, Legend } from 'chart.js'
    import { Line } from 'vue-chartjs'
    import { Button } from 'laravel-nova-ui'

    ChartJS.register(
        CategoryScale,
        LinearScale,
        PointElement,
        LineElement,
        Title,
        Tooltip,
        Legend,
    )

    export default {
        components: { Line, Button },
        props: { card: Object },
        data() {
            return {
                activeTabKey: this.card.value[ 0 ].key,
                chartOptions: {
                    responsive: true,
                    maintainAspectRatio: false,
                },
            }
        },
        computed: {
            activeTab() {
                return this.value.find(tab => tab.key === this.activeTabKey)
            },
            currentValue() {
                return this.activeTab?.value
            },
        },
    }

</script>

<style lang="scss">

    .chartjs-widget {
        @apply bg-gray-200 dark:bg-gray-700 #{!important};
    }

</style>

