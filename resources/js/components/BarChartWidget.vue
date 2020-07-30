<script>

import BaseWidget from './BaseWidget'
import BarChart from './BarChart'

export default {
    name: 'LineChartWidget',
    extends: BaseWidget,
    data() {
        return {
            component: BarChart
        }
    }
}

</script>
