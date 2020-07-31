<template>

    <widget :meta="meta" no-padding>

        <template v-slot="{ value }">

            <div class="flex flex-col">

                <div v-if="meta.options.title" class="px-6 py-4 text-base text-80 font-bold">
                    {{ meta.options.title }}
                </div>

                <component :is="component"
                           class="absolute flex-1 w-full h-full z-1"
                           :extra="meta.meta"
                           :width="width"
                           :height="height"
                           :options="meta.options"
                           :chart-data="value"/>

            </div>

        </template>

    </widget>

</template>

<script>

import 'chartjs-plugin-colorschemes';


export default {
    name: 'ChartWidget',
    props: {
        meta: { type: Object, default: null },
        card: { type: Object, default: null },
        coordinates: { type: Object }
    },
    data() {
        return {
            component: null,
            width: 0,
            height: 0
        }
    },
    created() {

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
