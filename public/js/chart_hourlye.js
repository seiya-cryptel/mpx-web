// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.round(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_hourly_data_list = Object.keys(hourly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in hourly_data_list) {
    chartData[j] = ({
        date: hourly_data_list[i]['dt'],
        hourly: format_value(hourly_data_list[i]['pr']),
    });
    j++;
}

var chart = AmCharts.makeChart("hourly_chart", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM-DD JJ:NN",      2020/02/12
    // dataDateFormat: "MMM DD, YYYY JJ:NN",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "hh",
        maxSeries: 1500     // 2016/04/15
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "hourly",
                    toField: "hourly"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2,
            title: "Forward Price (JPY/kWh)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                {
                    id: "g1",
                    title: "Hourly",
                    valueField: "hourly",
                    useDataSetColors: false,
                    lineColor: "#67b7dc",
                    balloonColor: "#67b7dc",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                }

            ],
            // 上のグラフのタイトル
            stockLegend: {
                periodValueTextComparing: "[[percents.value.close]]%",
                periodValueTextRegular: "[[value.close]]"
            }
        }

    ],
    valueAxesSettings: {
        inside: false,
        showLastLabel: true
    },
    panelsSettings: {
        "plotAreaFillAlphas": 1,
        "marginLeft": 80,
        "marginTop": 5,
        "marginBottom": 5
    },
    // 下のカーソル
    chartScrollbarSettings: {
        graph: "g1"
    },
    // 左と下に表示される値
    chartCursorSettings: {
        valueBalloonsEnabled: true,
        fullWidth: true,
        cursorAlpha: 0.1,
        valueLineBalloonEnabled: true,
        categoryBalloonDateFormats:
                [
                    {
                        period: "YYYY",
                        format: "YYYY"
                    },
                    {
                        period: "MM",
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    },
                    {
                        period: "WW",
                        // format: "YYYY-MM-DD"
                        format: "MMM DD, YYYY"
                    },
                    {
                        period: "DD",
                        // format: "YYYY-MM-DD"
                        format: "MMM DD, YYYY"
                    },
                    {
                        period: "mm",
                        // format: "YYYY-MM-DD JJ:NN"
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "ss",
                        // format: "YYYY-MM-DD JJ:NN"
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "fff",
                        // format: "YYYY-MM-DD JJ:NN"
                        format: "MMM DD, YYYY JJ:NN"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        dateFormat: "MMM DD, YYYY JJ:NN",   // 2020/02/12
        position: "top",
        toText: "To:",
        selectFromStart: true,
        inputFieldWidth: 160,   // 2016/06/28
        periods: [
            {
                period: "DD",
                count: 1,
                label: "1 day"
            },
            {
                period: "MM",
                count: 1,
                label: "1 month"
            }, {
                period: "YYYY",
                count: 1,
                label: "1 year"
            }, {
                period: "YTD",
                label: "YTD"
            }, {
//                selected: true,
                period: "MAX",
                label: "MAX"
            }]
    },
    "export": {
        "enabled": true, // TODO CSV の　Download
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "ForwardCurve_Hourly_" + export_date + filename_area
            }]
    }
});
