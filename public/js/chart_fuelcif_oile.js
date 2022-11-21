// js/chart_fuelcif_oil.js

var chartData = [];

// カウンタ変数
var j = 0;
for (var i in sub_oil_data_list) {
    var format_date = new Date(sub_oil_data_list[i]['fc_datetime']);
    chartData[j] = ({
        date: format_date,
        cif_oil: sub_oil_data_list[i]['price'],
    });
    j++;
}
// console.log("chartDatfafafae");
// console.log(chartData);

var chart_sub_oil = AmCharts.makeChart("chartdiv_sub_oil", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "cif_oil",
                    toField: "cif_oil"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Price (JPY/kl)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // OIL
                {
                    id: "g1",
                    title: "Oil",
                    valueField: "cif_oil",
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
    balloonSettings: {
    },
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
                        format: "MMM YYYY"
                    },
                    {
                        period: "WW",
                        format: "MMM YYYY"
                    },
                    {
                        period: "DD",
                        format: "MMM YYYY"
                    },
                    {
                        period: "mm",
                        format: "MMM YYYY"
                    },
                    {
                        period: "ss",
                        format: "MMM YYYY"
                    },
                    {
                        period: "fff",
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
                // selected: true,
                count: 1,
                label: "1 year"
            }, {
                period: "YTD",
                label: "YTD"
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
                "fileName": "CIF_Oil_" + export_date
            }]
    }
});
