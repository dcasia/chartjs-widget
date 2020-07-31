<script>

import { Line } from 'vue-chartjs'
import Common from '../common'

export default {
    extends: Line,
    mixins: [ Common ],
    props: {
        extra: {
            type: Object,
            default: () => ({})
        },
        chartData: {
            type: Object,
            default: null
        },
        options: {
            type: Object,
            default: null
        }
    },
    mounted() {

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

        const options = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                colorschemes: {
                    scheme: this.options.colorScheme ?? this.extra.colorScheme ?? 'office.Yellow6'
                }
            },
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

    }
}

</script>
