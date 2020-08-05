<template>

    <widget v-bind="$props" no-padding>

        <template v-slot="{ value, namespace, options }">

            <div class="flex flex-col flex-1 h-full">

                <div v-if="options.widget_title" class="px-6 py-4 text-base text-80 font-bold">
                    {{ options.widget_title }}
                </div>

                <component :is="component"
                           v-if="value.dataset.length"
                           class="absolute flex-1 w-full h-full z-1"
                           :coordinates="coordinates"
                           :extra="meta.meta"
                           :width="width"
                           :height="height"
                           :options="options"
                           :namespace="namespace"
                           :chart-data="value"/>

                <div v-if="!value.dataset.length" class="flex flex-col items-center h-full justify-center">

                    <NoDataIcon class="mb-3 text-primary" style="height: 50%"/>

                    <h3 class="text-base text-80 font-normal">
                        {{ __('There is no data to be shown.') }}
                    </h3>

                </div>

            </div>

        </template>

    </widget>

</template>

<script>

import 'chartjs-plugin-colorschemes'
import NoDataIcon from './NoDataIcon'

export default {
    name: 'ChartJsWidget',
    components: { NoDataIcon },
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

    }

}

</script>
