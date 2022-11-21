// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_hourly_data_list = Object.keys(hourly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in hourly_data_list) {
    var format_date = hourly_data_list[i]['dt'];
    chartData[j] = ({
        date: format_date,
        hourly: format_value(hourly_data_list[i]['pr']), // 2016/03/15
        east_hourly: format_value(hourly_data_list[i]['east_pr']),
        west_hourly: format_value(hourly_data_list[i]['west_pr']),
        hokkaido_hourly: format_value(hourly_data_list[i]['hokkaido_pr']),  // 2017/04/07
        kyushu_hourly: format_value(hourly_data_list[i]['kyushu_pr']),
    });
    j++;
}

var chartFC3AreaHourly = AmCharts.makeChart("hourly_chart", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "hh",
        maxSeries: 1500
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "hourly",
                    toField: "hourly"
                },
                {
                    fromField: "east_hourly",
                    toField: "east_hourly"
                },
                {
                    fromField: "west_hourly",
                    toField: "west_hourly"
                },
                {
                    fromField: "hokkaido_hourly",   // 2017/04/07
                    toField: "hokkaido_hourly"
                },
                {
                    fromField: "kyushu_hourly",
                    toField: "kyushu_hourly"
                },
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2,
            title: "Forward Price (円/kWh)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // Hourly
                {
                    id: "g1",
                    title: "システムプライス・Hourly",
                    valueField: "hourly", // 2016/03/15
                    useDataSetColors: false,
//                    lineColor: "#67b7dc",
//                    balloonColor: "#67b7dc",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"  // 2016/03/11
                },
                // East Half hourly
                {
                    id: "g2",
                    title: "東エリア・Hourly",
                    valueField: "east_hourly", // 2016/03/15
                    useDataSetColors: false,
//                    lineColor: "#67b7dc",
//                    balloonColor: "#67b7dc",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"  // 2016/03/11
                },
                // West Half hourly
                {
                    id: "g3",
                    title: "西エリア・Hourly",
                    valueField: "west_hourly", // 2016/03/15
                    useDataSetColors: false,
//                    lineColor: "#67b7dc",
//                    balloonColor: "#67b7dc",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"  // 2016/03/11
                },
                // Hokkaido Half hourly
                {
                    id: "g4",
                    title: "北海道・Hourly",
                    valueField: "hokkaido_hourly",
                    useDataSetColors: false,
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // Kyushu Half hourly
                {
                    id: "g5",
                    title: "九州・Hourly",
                    valueField: "kyushu_hourly",
                    useDataSetColors: false,
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
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
        selectFromStart: true, // 2016/03/11
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
        "enabled": true, // TODO CSV の　ダウンロード
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "ダウンロード",
                "title": "Export chart to CSV",
                "fileName": "ForwardCurve_Hourly_" + export_date + filename_area
            }]
    }
});
