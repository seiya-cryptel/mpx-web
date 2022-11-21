var amount_of_subs_data_list = Object.keys(exchange_data_list).length;
var chartData = [];

for (var i = 0; i < amount_of_subs_data_list; i++) {
    var format_date = new Date(exchange_data_list[i]['exchange_hst_datetime']);
    chartData[i] = ({
        date: format_date,
        futures_exchange: exchange_data_list[i]['exchange']
    });
}

var chart_exchange = AmCharts.makeChart("chartdiv_exchange", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "futures_exchange",
                    toField: "futures_exchange"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Settlement_Price (円/$)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // Load
                {
                    id: "g1",
                    title: "Exchange",
                    valueField: "futures_exchange",
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
                        format: "YYYY-MM"
                    },
                    {
                        period: "DD",
                        format: "YYYY-MM"
                    },
                    {
                        period: "mm",
                        format: "YYYY-MM"
                    },
                    {
                        period: "ss",
                        format: "YYYY-MM"
                    },
                    {
                        period: "fff",
                        format: "YYYY-MM"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        periods: [
            {
                period: "YYYY",
                count: 1,
                label: "1 year"
            }, {
                period: "MAX",
                label: "MAX",
                selected: true
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
                "label": dict["ダウンロード"],
                "title": "Export chart to CSV",
                "fileName": "FuturesSettlements_Exchange_" + export_date
            }]
    }
});
