var amount_of_subs_data_list2 = Object.keys(coal_data_list).length;
var chartData2 = [];

for (var i = 0; i < amount_of_subs_data_list2; i++) {
    var format_date = new Date(coal_data_list[i]['coal_hst_datetime']);
    chartData2[i] = ({
        date: format_date,
        futures_coal: coal_data_list[i]['coal']
    });
}

var chart_coal2 = AmCharts.makeChart("chartdiv_coal", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "futures_coal",
                    toField: "futures_coal"
                }
            ],
            dataProvider: chartData2,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Settlement_Price ($/ton)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                {
                    id: "g2",
                    title: "Coal",
                    valueField: "futures_coal",
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
        graph: "g2"
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
        selectFromStart: true, // 2016/03/11
        periods: [
            {
//                selected: true,
                period: "YYYY",
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
                "label": dict["ダウンロード"],
                "title": "Export chart to CSV",
                "fileName": "FuturesSettlements_Coal_" + export_date
            }]
    }
});
