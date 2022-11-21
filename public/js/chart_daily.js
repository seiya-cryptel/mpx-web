// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.round(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_daily_data_list = Object.keys(daily_data_list).length;

// カウンタ変数
var j = 0;
for (var i in daily_data_list) {
    var format_date = new Date(daily_data_list[i]['fc_datetime']);
    chartData[j] = ({
        date: format_date,
        daily: format_value(daily_data_list[i]['price']), // 2016/03/15
    });
    j++;
}

var chart = AmCharts.makeChart("chartdiv", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD",
    categoryAxesSettings: {
        minPeriod: "DD",
        maxSeries: 1500  // 2016/03/11
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "daily", // 2016/03/15
                    toField: "daily"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: dict["Forward Price (円/kWh)"],
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // Daily
                {
                    id: "g1",
                    title: "Daily",
                    valueField: "daily", // 2016/03/15
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
                        format: "YYYY",
                    },
                    {
                        period: "MM",
                        format: "YYYY-MM",
                    },
                    {
                        period: "WW",
                        format: "YYYY-MM-DD",
                    },
                    {
                        period: "DD",
                        format: "YYYY-MM-DD",
                    },
                    {
                        period: "mm",
                        format: "YYYY-MM-DD",
                    },
                    {
                        period: "ss",
                        format: "YYYY-MM-DD",
                    },
                    {
                        period: "fff",
                        format: "YYYY-MM-DD",
                    },
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM-DD",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        periods: [
            {
                period: "MM",
                count: 1,
                label: "1 month"
            }, {
                // selected: true,
                period: "YYYY",
                count: 1,
                label: "1 year",
            }, {
                period: "YTD",
                label: "YTD"
            }, {
                period: "MAX",
                label: "MAX"
            }]
    },
    "export": {
        "enabled": true, // TODO CSV の　ダウンロード
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "ダウンロード",
                "title": "Export chart to CSV",
                "fileName": "ForwardCurve_Daily_" + export_date + filename_area
            }]
    }
});
