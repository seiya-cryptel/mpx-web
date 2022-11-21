// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_half_hourly_data_list = Object.keys(half_hourly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in half_hourly_data_list) {
    var format_date = half_hourly_data_list[i]['fc_datetime'];
    chartData[j] = ({
        date: format_date,
        halfhourly: format_value(half_hourly_data_list[i]['price']), // 2016/03/15
        east_halfhourly: format_value(half_hourly_data_list[i]['east_price']),
        west_halfhourly: format_value(half_hourly_data_list[i]['west_price']),
        hokkaido_halfhourly: format_value(half_hourly_data_list[i]['hokkaido_price']),  // 2017/04/07
        kyushu_halfhourly: format_value(half_hourly_data_list[i]['kyushu_price']),
    });
    j++;
}

var chart = AmCharts.makeChart("chartdiv2", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "30mm",
        maxSeries: 1500
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "halfhourly",
                    toField: "halfhourly"
                },
                {
                    fromField: "east_halfhourly",
                    toField: "east_halfhourly"
                },
                {
                    fromField: "west_halfhourly",
                    toField: "west_halfhourly"
                },
                {
                    fromField: "hokkaido_halfhourly",   // 2017/04/07
                    toField: "hokkaido_halfhourly"
                },
                {
                    fromField: "kyushu_halfhourly",
                    toField: "kyushu_halfhourly"
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
                // Half hourly
                {
                    id: "g1",
                    title: "システムプライス・Half hourly",
                    valueField: "halfhourly", // 2016/03/15
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
                    title: "東エリア・Half hourly",
                    valueField: "east_halfhourly", // 2016/03/15
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
                    title: "西エリア・Half hourly",
                    valueField: "west_halfhourly", // 2016/03/15
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
                // Hokkaido Half hourly 2017/04/07
                {
                    id: "g4",
                    title: "北海道・Half hourly",
                    valueField: "hokkaido_halfhourly",
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
                // Kyushu Half hourly   2017/04/07
                {
                    id: "g5",
                    title: "九州・Half hourly",
                    valueField: "kyushu_halfhourly",
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
                "fileName": "ForwardCurve_HalfHourly_" + export_date + filename_area
            }]
    }
});
