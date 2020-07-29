<template>

    <widget :meta="meta" no-padding>

        <template v-slot="{ value }">


            <LineChart ref="chart"
                       class="relative w-full h-full"
                       :width="width"
                       :height="height"
                       :options="options"
                       :chart-data="value"/>


        </template>

    </widget>

</template>

<script>
// interface Meta {
// }
// interface Coordinates {
//     width: number,
//     height: number,
//     x: number,
//     y: number
// }

import LineChart from './LineChart'

export default {
    name: 'ChartWidget',
    components: { LineChart },
    props: {
        meta: { type: Object, default: null },
        card: { type: Object, default: null },
        coordinates: { type: Object }
    },
    data() {
        return {
            collection: null,
            options: null,
            width: 0,
            height: 0,
        }
    },
    mounted() {

        console.log(this.meta)

        this.$nextTick(() => {

            this.width = this.$el.clientWidth
            this.height = this.$el.clientHeight

        })

    },
    computed: {
        options() {
            if (this.meta) {
                return this.meta.options
            }
            return this.card.options
        }
    }
}
</script>
