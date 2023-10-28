<template>

    <Card class="chartjs-widget flex justify-center items-center overflow-hidden"
          :class="{ 'p-1': activeTab.title }"
          :style="{
              '--background-color-dark': activeTab.backgroundColorDark,
              '--background-color-light': activeTab.backgroundColorLight
          }">

        <LoadingView
            :loading="isLoading"
            class="flex flex-col justify-center items-center w-full h-full">

            <div class="flex w-full justify-between mb-1" v-if="activeTab?.title">

                <div class="p-2 text-sm font-bold" v-if="activeTab?.title">{{ activeTab.title }}</div>

                <div class="flex justify-end space-x-1" v-if="value.length > 1">

                    <Button
                        class="whitespace-nowrap"
                        v-for="{ key, leadingIcon, trailingIcon, buttonTitle } of value"
                        :variant="activeTabKey === key ? 'link' : 'ghost'"
                        :leading-icon="leadingIcon"
                        :trailing-icon="trailingIcon"
                        @click="activeTabKey = key">

                        {{ buttonTitle }}

                    </Button>

                </div>

            </div>

            <div class="bg-[var(--chart-background-color)] w-full h-full rounded overflow-hidden">

                <component
                    :is="activeTab.type"
                    :key="activeTabKey"
                    :options="chartOptions"
                    :data="currentValue"/>

            </div>

        </LoadingView>

    </Card>

</template>

<script>

    import { Chart, elements, plugins, scales } from 'chart.js'
    import ChartDataLabels from 'chartjs-plugin-datalabels'
    import { Bar, Bubble, Doughnut, Line, Pie, PolarArea, Radar, Scatter } from 'vue-chartjs'
    import { Button } from 'laravel-nova-ui'

    Chart.register(
        plugins,
        elements,
        scales,
        ChartDataLabels,
    )

    export default {
        components: {
            Line,
            Bar,
            Bubble,
            PolarArea,
            Radar,
            Scatter,
            Doughnut,
            Pie,
            Button,
        },
        props: [ 'card' ],
        data() {
            return {
                activeTabKey: this.card.value[ 0 ].key,
            }
        },
        computed: {
            chartOptions() {

                const plugins = {}

                if (this.activeTab.legend) {
                    plugins.legend = this.activeTab.legend
                }

                if (this.activeTab.tooltip) {
                    plugins.tooltip = this.activeTab.tooltip
                }

                return {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: this.activeTab.animation,
                    elements: this.activeTab.elements,
                    scales: this.activeTab.scales,
                    layout: {
                        padding: this.activeTab.padding,
                    },
                    plugins,
                }
            },
            activeTab() {
                return this.value.find(tab => tab.key === this.activeTabKey) ?? this.value[ 0 ]
            },
            currentValue() {
                return this.activeTab?.value
            },
        },
    }

</script>

<style lang="scss">

    .dark .chartjs-widget {
        --chart-background-color: var(--background-color-dark, var(--bg-gray-700))
    }

    .chartjs-widget {
        @apply bg-gray-200 dark:bg-gray-700 #{!important};

        --chart-background-color: var(--background-color-light, var(--bg-gray-200))
    }

</style>

