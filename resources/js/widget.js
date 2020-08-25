import LineChartWidget from './components/LineChartWidget'
import BarChartWidget from './components/BarChartWidget'
import PieChartWidget from './components/PieChartWidget'

Nova.booting((Vue, router, store) => {

    Vue.component('line-chart-widget', LineChartWidget)
    Vue.component('bar-chart-widget', BarChartWidget)
    Vue.component('pie-chart-widget', PieChartWidget)

})
