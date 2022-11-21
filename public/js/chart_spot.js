var chartData1 = [];
for (var i in spot_all_data_list) {
    var format_date = new Date(spot_all_data_list[i]['hst_datetime']);
    chartData1[i] = ({
        date: format_date,
        volume: spot_all_data_list[i]['contract'],
        system_price: spot_all_data_list[i]['price_system'],
    });
    /*
     "date": "時間"
     volume: "約定総量"
     system_price: "システムプライス"
     */
}

var chartSpat = AmCharts.makeChart("chartdiv_spot_all", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "system_price",
                    toField: "system_price"
                },
                {
                    fromField: "volume",
                    toField: "volume"
                }

            ],
            dataProvider: chartData1,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2,
            title: "Spot Price (円/kWh)",
            showCategoryAxis: false,
            percentHeight: 70,
            stockGraphs: [
                // システムプライス
                {
                    id: "g1",
                    title: "システムプライス",
                    valueField: "system_price",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>システムプライス [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },

            ],
            // 上のグラフのタイトル
            stockLegend: {
                periodValueTextComparing: "[[percents.value.close]]%",
                periodValueTextRegular: "[[value.close]]"
            }
        },
        {
            title: "約定総量[kWh]",
            percentHeight: 30,
            stockGraphs: [{
                    title: "TTV(kWh)",
                    valueField: "volume",
                    useDataSetColors: false,
                    lineColor: "orange",
                    type: "column",
                    showBalloon: true,
                    balloonText: "<span style='font-size:15px;>'[[date]]<br>約定総量:[[value]]</span>",
                    fillAlphas: 1
                }],
            // 下のグラフのタイトル
            stockLegend: {
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
                        format: "YYYY-MM-DD"
                    },
                    {
                        period: "DD",
                        format: "YYYY-MM-DD"
                    },
                    {
                        period: "mm",
                        format: "YYYY-MM-DD JJ:NN"
                    },
                    {
                        period: "ss",
                        format: "YYYY-MM-DD JJ:NN"
                    },
                    {
                        period: "fff",
                        format: "YYYY-MM-DD JJ:NN"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        position: "top",
        toText: "To:",
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
                period: "DD",
                selected: true,
                count: 1,
                label: "1 day"
            },
            {
                period: "MM",
//                selected: true,
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
                "label": "ダウンロード",
                "title": "Export chart to CSV",
                "fileName": "JEPX_Spot_One"
            }]
    },
    "numberFormatter": {
        "precision": 2,
        "decimalSeparator": ",",
        "thousandsSeparator": ""
    }
});

