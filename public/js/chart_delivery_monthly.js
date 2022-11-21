//var amount_of_delivery_monthly_data_list = Object.keys(delivery_monthly_data_list).length;

var hoge = [];

// 折れ線グラフのタイトル
var line_title_list = [];
var i = 1;
for (var j in delivery_monthly_data_list) {
    line_title_list[i] = j;
    i++;
}

var chartData1 = [];

var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[1]]) {
    // console.log(delivery_monthly_data_list[line_title_list[1]][j]);
    var format_date = new Date(delivery_monthly_data_list[line_title_list[1]][j]["target_date"]);
    chartData1[i] = {date: format_date};
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[1]]) {
    chartData1[i].price_base_1 = delivery_monthly_data_list[line_title_list[1]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[2]]) {
    chartData1[i].price_base_2 = delivery_monthly_data_list[line_title_list[2]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[3]]) {
    chartData1[i].price_base_3 = delivery_monthly_data_list[line_title_list[3]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[4]]) {
    chartData1[i].price_base_4 = delivery_monthly_data_list[line_title_list[4]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[5]]) {
    chartData1[i].price_base_5 = delivery_monthly_data_list[line_title_list[5]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[6]]) {
    chartData1[i].price_base_6 = delivery_monthly_data_list[line_title_list[6]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[7]]) {
    chartData1[i].price_base_7 = delivery_monthly_data_list[line_title_list[7]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[8]]) {
    chartData1[i].price_base_8 = delivery_monthly_data_list[line_title_list[8]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[9]]) {
    chartData1[i].price_base_9 = delivery_monthly_data_list[line_title_list[9]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[10]]) {
    chartData1[i].price_base_10 = delivery_monthly_data_list[line_title_list[10]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[11]]) {
    chartData1[i].price_base_11 = delivery_monthly_data_list[line_title_list[11]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[12]]) {
    chartData1[i].price_base_12 = delivery_monthly_data_list[line_title_list[12]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[13]]) {
    chartData1[i].price_base_13 = delivery_monthly_data_list[line_title_list[13]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[14]]) {
    chartData1[i].price_base_14 = delivery_monthly_data_list[line_title_list[14]][j]["price_base"];
    i++;
}
var i = 0;
for (var j in delivery_monthly_data_list[line_title_list[15]]) {
    chartData1[i].price_base_15 = delivery_monthly_data_list[line_title_list[15]][j]["price_base"];
    i++;
}
// 凡例
i = 1;
for (var j in line_title_list) {
    var dt = new Date(line_title_list[j]);
    line_title_list[i] = dt.getFullYear() + "年" + (" " + (dt.getMonth() + 1)).slice(-2) + "月";
    // console.log(line_title_list[i]);
    i++;
}

var chart_coal2 = AmCharts.makeChart("chartdiv_hst_demands", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500  // 2016/03/11
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "price_base_1",
                    toField: "price_base_1"
                },
                {
                    fromField: "price_base_2",
                    toField: "price_base_2"
                },
                {
                    fromField: "price_base_3",
                    toField: "price_base_3"
                },
                {
                    fromField: "price_base_4",
                    toField: "price_base_4"
                },
                {
                    fromField: "price_base_5",
                    toField: "price_base_5"
                },
                {
                    fromField: "price_base_6",
                    toField: "price_base_6"
                },
                {
                    fromField: "price_base_7",
                    toField: "price_base_7"
                },
                {
                    fromField: "price_base_8",
                    toField: "price_base_8"
                },
                {
                    fromField: "price_base_9",
                    toField: "price_base_9"
                },
                {
                    fromField: "price_base_10",
                    toField: "price_base_10"
                },
                {
                    fromField: "price_base_11",
                    toField: "price_base_11"
                },
                {
                    fromField: "price_base_12",
                    toField: "price_base_12"
                },
                {
                    fromField: "price_base_13",
                    toField: "price_base_13"
                },
                {
                    fromField: "price_base_14",
                    toField: "price_base_14"
                },
                {
                    fromField: "price_base_15",
                    toField: "price_base_15"
                }
            ],
            dataProvider: chartData1,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2, // 2016/06/28
            title: "受渡月別価格推移（円/kWh）",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                {
                    id: "g1",
                    title: line_title_list[1],
                    valueField: "price_base_1",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g2",
                    title: line_title_list[2],
                    valueField: "price_base_2",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g3",
                    title: line_title_list[3],
                    valueField: "price_base_3",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g4",
                    title: line_title_list[4],
                    valueField: "price_base_4",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g5",
                    title: line_title_list[5],
                    valueField: "price_base_5",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g6",
                    title: line_title_list[6],
                    valueField: "price_base_6",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g7",
                    title: line_title_list[7],
                    valueField: "price_base_7",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g8",
                    title: line_title_list[8],
                    valueField: "price_base_8",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g9",
                    title: line_title_list[9],
                    valueField: "price_base_9",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g10",
                    title: line_title_list[10],
                    valueField: "price_base_10",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g11",
                    title: line_title_list[11],
                    valueField: "price_base_11",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g12",
                    title: line_title_list[12],
                    valueField: "price_base_12",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g13",
                    title: line_title_list[13],
                    valueField: "price_base_13",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g14",
                    title: line_title_list[14],
                    valueField: "price_base_14",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                {
                    id: "g15",
                    title: line_title_list[15],
                    valueField: "price_base_15",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>[[category]]: [[value]]</span>",
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
        dateFormat: "YYYY-MM-DD",
        position: "top",
        toText: "To:",
        selectFromStart: false,
        periods: [
            /* 2016/06/20
            {
                period: "DD",
                count: 1,
                label: "1 day"
            },
            */
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
    /* 2016/06/20
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
                "fileName": "HistoricalDemand"
            }]
    }
    */
});
