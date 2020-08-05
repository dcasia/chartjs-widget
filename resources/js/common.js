export default {
    props: {
        width: {
            type: Number,
            default: 0
        },
        height: {
            type: Number,
            default: 0
        },
        extra: {
            type: Object,
            default: () => ( {} )
        },
        chartData: {
            type: Object,
            default: null
        },
        options: {
            type: Object,
            default: null
        },
        coordinates: {
            type: Object,
            required: true
        },
        namespace: {
            type: String,
            required: true
        }
    },
    mounted() {

        const unWatch = this.$watch(() => ( this.coordinates.height, this.coordinates.width ), () => {
            this.$data._chart.update()
        })

        this.$on('hook:beforeDestroy', () => unWatch())

        const defaults = {
            borderWidth: 2,
            pointBorderWidth: 2,
            pointHitRadius: 10,
            pointRadius: 3,
            pointHoverBorderWidth: 2,
            pointHoverRadius: 4,
            cubicInterpolationMode: 'monotone'
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
                    backgroundColor: this.parseColor(backgroundColor),
                    borderColor: this.parseColor(borderColor),
                    hoverBackgroundColor: this.parseColor(hoverBackgroundColor),
                    hoverBorderColor: this.parseColor(hoverBorderColor),
                    pointBackgroundColor: this.parseColor(pointBackgroundColor),
                    pointBorderColor: this.parseColor(pointBorderColor),
                    pointHoverBackgroundColor: this.parseColor(pointHoverBackgroundColor),
                    pointHoverBorderColor: this.parseColor(pointHoverBorderColor),
                    label,
                    data
                }

            })
        }

        this.renderChart(data, {
            responsive: true,
            maintainAspectRatio: false,
            ...this.options
        })

    },
    computed: {
        options() {
            return this.$store.getters[ `${ this.namespace }/options` ]
        },
        context() {
            return this.$refs.canvas.getContext('2d')
        }
    },
    methods: {
        relativeHeight(number) {
            return ( this.height * number ) / 100
        },
        relativeWidth(number) {
            return ( this.width * number ) / 100
        },
        parseColor(colorPayload) {

            if (!colorPayload) {

                return undefined

            }

            if (colorPayload.type === 'solid') {

                return colorPayload.color

            }

            if (colorPayload.type === 'gradient') {

                return this.generateGradient(colorPayload.colors, colorPayload.direction)

            }

        },
        generateGradient(colors, direction) {

            let gradient

            /**
             * Horizontal
             */
            if (direction === 0) {

                gradient = this.context.createLinearGradient(0, 0, this.width, 0)

            } else if (direction === 1) {

                gradient = this.context.createLinearGradient(0, 0, 0, this.height)

            }

            if (Array.isArray(colors)) {

                colors.forEach((color, index) => {
                    gradient.addColorStop(index / ( colors.length - 1 ), color)
                })

            } else {

                Object.keys(colors).forEach(stop => {

                    gradient.addColorStop(stop / 100, colors[ stop ])

                })

            }

            return gradient

        }

    }
}
