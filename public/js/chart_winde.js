var chartData = [];

for (var i in demand_forecast_data_list) {
    var format_date = new Date(demand_forecast_data_list[i]['fc_datetime']);
    var assumption_wind = demand_forecast_data_list[i]['wind'];
    chartData[i] = ({
        date: format_date,
        assumption_wind: assumption_wind
    });
}

var chart_solar = AmCharts.makeChart("chartdiv_wind", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM-DD JJ:NN",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500 // 2016/03/11
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "assumption_wind",
                    toField: "assumption_wind"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 0,
            title: "Production(MW)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // Half hourly
                {
                    id: "g1",
                    title: "Wind",
                    valueField: "assumption_wind",
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
                        format: "YYYY-MM"
                    },
                    {
                        period: "WW",
                        format: "MMM DD, YYYY"
                    },
                    {
                        period: "DD",
                        format: "MMM DD, YYYY"
                    },
                    {
                        period: "mm",
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "ss",
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "fff",
                        format: "MMM DD, YYYY JJ:NN"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        dateFormat: "MMM DD, YYYY JJ:NN",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
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
        "enabled": true,
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "Assumption_Wind_" + export_date + filename_area
            }]
    }
});
