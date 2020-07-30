<script>

import { Bar } from 'vue-chartjs'

export default {
    extends: Bar,
    props: {
        chartData: {
            type: Object,
            default: null
        },
        options: {
            type: Object,
            default: null
        },
        width: {
            type: Number,
            default: 0
        },
        height: {
            type: Number,
            default: 0
        }
    },
    mounted() {

        const context = this.$refs.canvas.getContext('2d')
        const defaults = {
            pointBorderWidth: 8,
            pointHoverRadius: 10,
            pointHoverBorderWidth: 5,
            pointRadius: 4,
            borderWidth: 4,
            cubicInterpolationMode: 'monotone'
        }

        const parseColor = (colorPayload) => {

            if (!colorPayload) {

                return 'black'

            }

            if (colorPayload.type === 'solid') {

                return colorPayload.color

            }

            if (colorPayload.type === 'gradient') {

                return this.generateGradient(context, colorPayload.colors, colorPayload.direction)

            }

        }

        const data = {
            labels: this.chartData.labels,
            datasets: this.chartData.dataset.map(({
                                                      data,
                                                      label,
                                                      backgroundColor,
                                                      borderColor,
                                                      hoverBackgroundColor,
                                                      hoverBorderColor,
                                                      pointBackgroundColor,
                                                      pointBorderColor,
                                                      pointHoverBackgroundColor,
                                                      pointHoverBorderColor,
                                                      ...settings
                                                  }) => {

                const options = _.defaults(settings, defaults)

                return {
                    ...options,
                    backgroundColor: parseColor(backgroundColor),
                    borderColor: parseColor(borderColor),
                    hoverBackgroundColor: parseColor(hoverBackgroundColor),
                    hoverBorderColor: parseColor(hoverBorderColor),
                    pointBackgroundColor: parseColor(pointBackgroundColor),
                    pointBorderColor: parseColor(pointBorderColor),
                    pointHoverBackgroundColor: parseColor(pointHoverBackgroundColor),
                    pointHoverBorderColor: parseColor(pointHoverBorderColor),
                    label,
                    data
                }

            })
        }

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: this.options.showLegend,
                position: this.options.positioning,
                align: this.options.alignment,
                labels: {
                    fontFamily: 'Nunito',
                    usePointStyle: true,
                    padding: 8,
                    boxWidth: 8
                }
            },
            layout: {
                padding: this.options.padding
            },
            tooltips: {
                titleFontFamily: 'Nunito',
                footerFontFamily: 'Nurito',
                bodyFontFamily: 'Nunito',
                titleAlign: 'center',
                ...this.options.tooltips,
                displayColors: this.options.tooltipSettings?.showColors,
                intersect: this.options.tooltipSettings?.intersect,
                enabled: this.options.tooltipSettings?.show
            },
            scales: {
                xAxes: [
                    {
                        display: this.options.horizontalAxis.display,
                        gridLines: {
                            display: this.options.horizontalAxis.showGridLines,
                            drawBorder: this.options.horizontalAxis.showGridLinesBorder
                        },
                        ticks: {
                            lineHeight: 5,
                            padding: this.options.horizontalAxisTicksPadding
                        }
                    }
                ],
                yAxes: [
                    {
                        display: this.options.verticalAxis.display,
                        gridLines: {
                            display: this.options.verticalAxis.showGridLines,
                            drawBorder: this.options.verticalAxis.showGridLinesBorder
                        },
                        ticks: {
                            lineHeight: 5,
                            padding: this.options.verticalAxisTicksPadding
                        }
                    }
                ]
            }
        }

        this.renderChart(data, options)

    },
    methods: {
        generateGradient(context, colors, direction) {

            let gradient

            /**
             * Horizontal
             */
            if (direction === 0) {

                gradient = context.createLinearGradient(0, 0, this.width, 0)

            } else if (direction === 1) {

                gradient = context.createLinearGradient(0, 0, 0, this.height)

            }

            if (Array.isArray(colors)) {

                colors.forEach((color, index) => {
                    gradient.addColorStop(index / (colors.length - 1), color)
                })

            } else {

                Object.keys(colors).forEach(stop => {

                    gradient.addColorStop(stop / 100, colors[ stop ])

                })

            }

            return gradient

        },
        relativeHeight(number) {
            return (this.height * number) / 100
        },
        relativeWidth(number) {
            return (this.width * number) / 100
        }
    }
}

</script>
