import $ from 'jquery'
import "flot/dist/es5/jquery.flot"
import axios from '../axios'

const defaultLegends = {
    legend: {
        labelFormatter: null,
        noColumns: 5,
        sorted: "ascending",
        show: true,
        container: document.getElementById('stats-legend')
    },
}

const defaultOptions = {
    colors: ['#4C51BF'],
    grid: {
        borderWidth: 1,
        borderColor: '#edeff6',
        hoverable: true,
    },
    yaxis: {
        tickColor: '#edeff6',
        font: {color: '#001737', size: 10}
    },
    xaxis: {
        mode: 'categories',
        showTicks: false,
        gridLines: false,
        tickColor: '#edeff6',
        font: {color: '#001737', family: 'Roboto', weight: 'bold', size: 12}
    }
}

export default class StatisticChart {
    constructor(elements) {
        elements.forEach(async (element) => {
            const [url, type] = [
                element.getAttribute('data-url'),
                element.getAttribute('data-chart-type'),
            ];

            const data = await axios.get(url);

            switch (type) {
                case 'bar':
                    $.plot(element, data.data, {
                        series: {
                            bars: {
                                show: true,
                                lineWidth: 1.5,
                                barWidth: 0.5,
                                align: 'center',
                                fill: true,
                            },
                        },
                        ...defaultLegends,
                        ...defaultOptions
                    });
                    break
                case 'line':
                    $.plot(element, data.data, {
                        series: {
                            lines: {
                                show: true,
                                align: 'center',
                                lineWidth: 3.5,
                            }
                        },
                        ...defaultLegends,
                        ...defaultOptions
                    });
                    break;
                case 'pie':
                    $.plot(element, data.data, {
                        legend: {
                            labelFormatter: (l, s) => `${l} : ${s.data[0][1]}`,
                            noColumns: 4,
                            container: document.getElementById('stats-legend')
                        },
                        series: {
                            bars: {
                                show: true,
                                lineWidth: 0.3,
                                barWidth: 0.3,
                                align: 'center',
                                fill: true,
                            }
                        },
                        ...defaultLegends,
                        ...defaultOptions
                    });
                    break;
            }

            $("<div id='tooltip'></div>").css({
                position: "absolute",
                display: "none",
                color: "#fff",
                border: "1px solid #45B39D",
                padding: "2px",
                "background-color": "#45B39D",
                opacity: 1
            }).appendTo("body");

            $(element).bind("plothover", (e, p, i) => {
                if (!p.x || !p.y) return

                if (i) {
                    $("#tooltip")
                        .html(`${i.series.label} : ${i.datapoint[1]}`)
                        .css({top: i.pageY + 5, left: i.pageX + 5})
                        .fadeIn(100)
                } else {
                    $("#tooltip").hide()
                }
            });

            $(element).bind("plothovercleanup", () => $("#tooltip").hide());
        })
    }
}
