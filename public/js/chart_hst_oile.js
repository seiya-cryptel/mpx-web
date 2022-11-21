var amount_of_subs_data_list = Object.keys(oil_data_list).length;
var chartData = [];
for (var i = 0; i < amount_of_subs_data_list; i++) {
    var format_date = new Date(oil_data_list[i]['oil_hst_datetime']);
    chartData[i] = ({
        date: format_date,
        futures_oil: oil_data_list[i]['oil']
    });
}

var chart_oil = AmCharts.makeChart("chartdiv_oil", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM-DD",
    dataDateFormat: "YYYY/MM/DD",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "futures_oil",
                    toField: "futures_oil"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Settlement_Price ($/bbl)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                {
                    id: "g1",
                    title: "Oil",
                    valueField: "futures_oil",
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
                    periodValue: "Average"  // 2016/03/11
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
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    },
                    {
                        period: "DD",
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    },
                    {
                        period: "mm",
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    },
                    {
                        period: "ss",
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    },
                    {
                        period: "fff",
                        // format: "YYYY-MM"
                        format: "MMM YYYY"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM",
        dateFormat: "MMM YYYY",
        position: "top",
        toText: "To:",
        selectFromStart: true, // 2016/03/11
        periods: [
            {
                period: "YYYY",
//                selected: true,
                count: 1,
                label: "1 year"
            }, {
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
                "fileName": "FuturesSettlements_Oil_" + export_date
            }]
    }
});
