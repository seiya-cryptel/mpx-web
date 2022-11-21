//// 小数点第2以下切り捨て
//function format_value(value) {
//    var formatted_value = Math.floor(value * 100) / 100;
//    formatted_value = String(formatted_value);
//    return formatted_value;
//}
var chartData = [];

var amount_of_half_hourly_data_list = Object.keys(sub_coal_data_list).length;

// カウンタ変数
var j = 0;
for (var i in sub_coal_data_list) {
    var format_date = new Date(sub_coal_data_list[i]['fc_datetime']);
    chartData[j] = ({
        date: format_date,
        assumption_coal: sub_coal_data_list[i]['price'],
    });
    j++;
}

var chart_sub_coal = AmCharts.makeChart("chartdiv_sub_coal", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "assumption_coal",
                    toField: "assumption_coal"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: dict["Price (千円/MWh)"],
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // COAL
                {
                    id: "g1",
                    title: "Coal",
                    valueField: "assumption_coal",
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
                "label": dict["ダウンロード"],
                "title": "Export chart to CSV",
                "fileName": "Assumption_Coal_" + export_date
            }]
    }
});
