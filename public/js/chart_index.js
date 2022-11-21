var amount_of_data_length = Object.keys(index_data_list).length;
var chartData1 = [];
for (var i = 0; i < amount_of_data_length; i++) {
    var format_date = new Date(index_data_list[i]['hst_datetime']);
    chartData1[i] = ({
        date: format_date,
        volume: index_data_list[i]['ttv'],
        da_24: index_data_list[i]['da_24'],
        da_dt: index_data_list[i]['da_dt'],
        da_pt: index_data_list[i]['da_pt']
    });
}
// console.log("chartData1");
// console.log(chartData1);

var chartIndex = AmCharts.makeChart("chartdiv_index", {
    type: "stock",
    "theme": "light",
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "da_24",
                    toField: "da_24"
                },
                {
                    fromField: "da_dt",
                    toField: "da_dt"
                },
                {
                    fromField: "da_pt",
                    toField: "da_pt"
                },
                {
                    fromField: "volume",
                    toField: "volume"
                },
            ],
            dataProvider: chartData1,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2,
            title: "Spot Price (円/kWh)",
            showCategoryAxis: false,
            percentHeight: 70,
            stockGraphs: [
                // DA_24
                {
                    id: "g1",
                    title: "DA_24(円/kWh)",
                    valueField: "da_24",
                    useDataSetColors: false,
                    lineColor: "#67b7dc",
                    balloonColor: "#67b7dc",
                    balloonText: "<span style='font-size:12px;'>DA_24 [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // DA_DT
                {
                    id: "g2",
                    title: "DA_DT(円/kWh)",
                    valueField: "da_dt",
                    useDataSetColors: false,
                    lineColor: "#fdd400",
                    balloonText: "<span style='font-size:12px;'>DA_DT [[value]]</span>",
                    bullet: "square",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // DA_PT
                {
                    id: "g3",
                    title: "DA_PT(円/kWh)",
                    valueField: "da_pt",
                    useDataSetColors: false,
                    lineColor: "#84b761",
                    balloonText: "<span style='font-size:12px;'>DA_PT [[value]]</span>",
                    bullet: "triangleUp",
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
        },
        {
            precision: 2,
            title: "約定総量[kWh]",
            percentHeight: 30,
            stockGraphs: [{
                    title: "TTV(kWh)",
                    valueField: "volume",
                    useDataSetColors: false,
                    lineColor: "orange",
                    type: "column",
                    showBalloon: true,
                    balloonText: "<span style='font-size:15px;>'[[date]]<br>約定総量:[[value]]</span>",
                    fillAlphas: 1,
                    periodValue: "Average"
                }],
            // 下のグラフのタイトル
            stockLegend: {
                periodValueTextRegular: "[[value.close]]"
            }
        }
    ],
    valueAxesSettings: {
        inside: false,
        showLastLabel: true
    },
    "panelsSettings": {
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
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM-DD",
        position: "top",
        toText: "To:",
        periods: [{
                period: "MM",
                selected: true,
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
                "fileName": "JEPX_Index"
            }]
    }
});
