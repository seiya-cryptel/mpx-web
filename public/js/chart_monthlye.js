// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.round(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_monthly_data_list = Object.keys(monthly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in monthly_data_list) {
    var format_date = new Date(monthly_data_list[i]['fc_datetime']);
    chartData[j] = ({
        date: format_date,
        monthly_base: format_value(monthly_data_list[i]['price_base']),
        monthly_peak: format_value(monthly_data_list[i]['price_offpeak']),
        monthly_daytime: format_value(monthly_data_list[i]['price_peak']),
    });
    j++;
}

var chart = AmCharts.makeChart("monthly_chart", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM",   2020/02/11
    // dataDateFormat: "MMM YYYY",
    dataDateFormat: "YYYY/MM/DD",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "monthly_base",
                    toField: "monthly_base"
                },
                {
                    fromField: "monthly_peak",
                    toField: "monthly_peak"
                },
                {
                    fromField: "monthly_daytime",
                    toField: "monthly_daytime"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Forward Price (JPY/kWh)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // price_base
                {
                    id: "g1",
                    title: "Base Load",
                    valueField: "monthly_base",
                    useDataSetColors: false,
                    lineColor: "blue",
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
                // price_offpeak
                {
                    id: "g2",
                    title: "Peak Load",
                    valueField: "monthly_peak",
                    useDataSetColors: false,
                    lineColor: "orange",
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
                // price_peak
                {
                    id: "g3",
                    title: "Daytime Load",
                    valueField: "monthly_daytime",
                    useDataSetColors: false,
                    lineColor: "gray",
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
                        format: "YYYY",
                    },
                    {
                        period: "MM",
                        // format: "YYYY-MM",
                        format: "MMM YYYY",
                    },
                    {
                        period: "WW",
                        // format: "YYYY-MM-DD",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "DD",
                        // format: "YYYY-MM-DD",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "mm",
                        // format: "YYYY-MM-DD",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "ss",
                        // format: "YYYY-MM-DD",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "fff",
                        // format: "YYYY-MM-DD",
                        format: "MMM DD, YYYY",
                    },
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM",   2020/02/11
        dateFormat: "MMM YYYY",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        periods: [
            {
                selected: true,
                period: "YYYY",
                count: 1,
                label: "1 year"
            },
            {
                period: "MAX",
                label: "MAX"
            }]
    },
    "export": {
        "enabled": true, // TODO CSV の　Download
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "ForwardCurve_Monthly_" + export_date + filename_area
            }]
    }
});
