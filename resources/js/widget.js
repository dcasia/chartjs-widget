import LineChartWidget from './components/LineChartWidget'
import BarChartWidget from './components/BarChartWidget'

Nova.booting((Vue, router, store) => {

    Vue.component('line-chart-widget', LineChartWidget)
    Vue.component('bar-chart-widget', BarChartWidget)

})
