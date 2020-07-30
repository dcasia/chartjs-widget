export default {
    props: {
        width: {
            type: Number,
            default: 0
        },
        height: {
            type: Number,
            default: 0
        }
    },
    computed: {
        context() {
            return this.$refs.canvas.getContext('2d')
        }
    },
    methods: {
        relativeHeight(number) {
            return (this.height * number) / 100
        },
        relativeWidth(number) {
            return (this.width * number) / 100
        },
        parseColor(colorPayload) {

            if (!colorPayload) {

                return 'black'

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
                    gradient.addColorStop(index / (colors.length - 1), color)
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
