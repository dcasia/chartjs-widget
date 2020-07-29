<script>

import { Line } from 'vue-chartjs'

export default {
    extends: Line,
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
            default: null
        }
    },
    mounted() {

        console.log(this.chartData.dataset)

        const ctx = this.$refs.canvas.getContext('2d')

        const gradientFill = ctx.createLinearGradient(0, 0, 0, this.height / 1.5)
        gradientFill.addColorStop(0, '#F9D423')
        gradientFill.addColorStop(1, 'rgb(215,182,52,0)')

        const redGradientFill = ctx.createLinearGradient(0, 0, 0, this.height / 1.5)
        redGradientFill.addColorStop(0, '#EA384D')
        redGradientFill.addColorStop(1, 'rgb(215,182,52,0)')

        const orange = this.generateGradient(ctx, '#e65c00', '#F9D423')
        const red = this.generateGradient(ctx, '#D31027', '#EA384D')

        const defaults = {
            pointBorderWidth: 8,
            pointHoverRadius: 10,
            pointHoverBorderWidth: 5,
            pointRadius: 4,
            borderWidth: 4,
            cubicInterpolationMode: 'monotone'
        }

        const data = {
            labels: this.chartData.labels,
            datasets: this.chartData.dataset.map(({ label, data, ...settings }) => {

                const options = _.defaults(settings, defaults)

                return {
                    backgroundColor: gradientFill,
                    borderColor: orange,
                    pointBorderColor: orange,
                    pointBackgroundColor: orange,
                    pointHoverBackgroundColor: orange,
                    pointHoverBorderColor: orange,
                    ...options,
                    label,
                    data
                }

            })
        }

        const options = {
            scaleShowVerticalLines: false,
            responsive: true,
            maintainAspectRatio: false,
            legend: {
                display: false
            },
            labels: {
                hidden: true
            },
            layout: {
                padding: {
                    left: 0,
                    right: 50,
                    top: 0,
                    bottom: 0
                }
            },
            scales: {
                xAxes: [
                    {
                        display: true,
                        gridLines: {
                            display: false,
                            drawBorder: true
                        }
                    }
                ],
                yAxes: [
                    {
                        gridLines: {
                            // https://www.chartjs.org/docs/latest/axes/styling.html#grid-line-configuration
                            display: false,
                            drawBorder: true
                        },
                        display: true,
                        ticks: {
                            lineHeight: 5,
                            padding: 50,
                            z: 100
                        }
                    }
                ]
            }
        }

        this.renderChart(data, options)
    },
    methods: {
        getRandomInt() {
            return Math.floor(Math.random() * (50 - 5 + 1)) + 5
        },
        generateGradient(context, leftColor, rightColor) {

            const gradientStroke = context.createLinearGradient(0, 0, this.percentage(100), 0)
            gradientStroke.addColorStop(0, leftColor)
            gradientStroke.addColorStop(1, rightColor)

            return gradientStroke

        },
        percentage(number) {

            return (this.width * number) / 100

        }
    }
}

</script>
