var amount_of_interconnect_data_list = Object.keys(interconnect_data_list).length;

var chartData = [];

for (var i = 0; i < amount_of_interconnect_data_list; i++) {
    var format_date = new Date(interconnect_data_list[i]['dt']);
    chartData[i] = ({
        date: format_date,
        forward: interconnect_data_list[i]['forward'],
        reverse: interconnect_data_list[i]['reverse'],
    });
}

var date = new Date();
var yyyy = date.getFullYear().toString();
var mm = (date.getMonth() + 1).toString();
var dd = date.getDate().toString();
// ダウンロード日
var download_date = yyyy + (mm[1] ? mm : "0" + mm[0]) + (dd[1] ? dd:"0" + dd[0]);

var chart_interconnect = AmCharts.makeChart("chartdiv_interconnect", {
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
                    fromField: "forward",
                    toField: "forward"
                },
                {
                    fromField: "reverse",
                    toField: "reverse"
                }
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 0,   // 2016/04/15
            title: "Capacity（MW）",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // Forward
                {
                    id: "g1",
                    title: "順方向",
                    valueField: "forward",
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
                // Reverse
                {
                    id: "g2",
                    title: "逆方向",
                    valueField: "reverse",
                    useDataSetColors: false,
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average",
                    // hidden: true, 2016/04/18
                }
            ],
            // 上のグラフのタイトル
            stockLegend: {
                backgroundColor: "red",
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
        selectFromStart: true,
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
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
                selected: true,
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
                "fileName": "Interconnection_" + export_file + download_date,
            }]
    }
});
