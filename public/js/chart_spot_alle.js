var chartData1 = [];
for (var i in spot_all_data_list) {
    var format_date = new Date(spot_all_data_list[i]['hst_datetime']);
    chartData1[i] = ({
        date: format_date,
        volume: spot_all_data_list[i]['contract'],
        system_price: spot_all_data_list[i]['price_system'],
        hokkaido: spot_all_data_list[i]['price_area_01'],
        tohoku: spot_all_data_list[i]['price_area_02'],
        tokyo: spot_all_data_list[i]['price_area_03'],
        chubu: spot_all_data_list[i]['price_area_04'],
        hokuriku: spot_all_data_list[i]['price_area_05'],
        kansai: spot_all_data_list[i]['price_area_06'],
        chugoku: spot_all_data_list[i]['price_area_07'],
        shikoku: spot_all_data_list[i]['price_area_08'],
        kyushu: spot_all_data_list[i]['price_area_09'],
    });
    /*
     "date": "時間"
     volume: "約定総量"
     system_price: "System Price"
     hokkaido: "Hokkaido"
     tohoku: "Tohoku"
     tokyo: "Tokyo Area"
     chubu: "Chubu Area"
     hokuriku: "Hokuriku Area"
     kansai: "Kansai Area"
     chugoku: "Chugoku Area"
     shikoku: "Shikoku Area"
     kyushu: "Kyushu Area"
     */
}

var chartSpat = AmCharts.makeChart("chartdiv_spot_all", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM-DD JJ:NN",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "system_price",
                    toField: "system_price"
                },
                {
                    fromField: "hokkaido",
                    toField: "hokkaido"
                },
                {
                    fromField: "tohoku",
                    toField: "tohoku"
                },
                {
                    fromField: "tokyo",
                    toField: "tokyo"
                },
                {
                    fromField: "chubu",
                    toField: "chubu"
                },
                {
                    fromField: "hokuriku",
                    toField: "hokuriku"
                },
                {
                    fromField: "kansai",
                    toField: "kansai"
                },
                {
                    fromField: "chugoku",
                    toField: "chugoku"
                },
                {
                    fromField: "shikoku",
                    toField: "shikoku"
                },
                {
                    fromField: "kyushu",
                    toField: "kyushu"
                },
                {
                    fromField: "volume",
                    toField: "volume"
                }

            ],
            dataProvider: chartData1,
            categoryField: "date"
        }
    ],
    panels: [{
            precision: 2,
            title: "Spot Price (JPY/kWh)",
            showCategoryAxis: false,
            percentHeight: 70,
            stockGraphs: [
                // System Price
                {
                    id: "g1",
                    title: "System Price",
                    valueField: "system_price",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>System Price [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // Hokkaido
                {
                    id: "g2",
                    title: "Hokkaido Area",
                    valueField: "hokkaido",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Hokkaido Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Tohoku
                {
                    id: "g3",
                    title: "Tohoku Area",
                    valueField: "tohoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Tohoku Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Tokyo Area
                {
                    id: "g4",
                    title: "Tokyo Area",
                    valueField: "tokyo",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Tokyo Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Chubu Area
                {
                    id: "g5",
                    title: "Chubu Area",
                    valueField: "chubu",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Chubu Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Hokuriku Area
                {
                    id: "g6",
                    title: "Hokuriku Area",
                    valueField: "hokuriku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Hokuriku Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Kansai Area
                {
                    id: "g7",
                    title: "Kansai Area",
                    valueField: "kansai",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Kansai Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Chugoku Area
                {
                    id: "g8",
                    title: "Chugoku Area",
                    valueField: "chugoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Chugoku Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Shikoku Area
                {
                    id: "g9",
                    title: "Shikoku Area",
                    valueField: "shikoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Shikoku Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // Kyushu Area
                {
                    id: "g10",
                    title: "Kyushu Area",
                    valueField: "kyushu",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>Kyushu Area [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
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
            title: "Settlement volume[kWh]",
            percentHeight: 30,
            stockGraphs: [{
                    title: "TTV(kWh)",
                    valueField: "volume",
                    useDataSetColors: false,
                    lineColor: "orange",
                    type: "column",
                    showBalloon: true,
                    balloonText: "<span style='font-size:15px;>'[[date]]<br>Settlement volume:[[value]]</span>",
                    fillAlphas: 1
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
                        "format": "MMM DD, YYYY"
                    },
                    {
                        period: "DD",
                        "format": "MMM DD, YYYY"
                    },
                    {
                        period: "mm",
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "ss",
                        format: "MMM DD, YYYY JJ:NN"
                    },
                    {
                        period: "fff",
                        format: "MMM DD, YYYY JJ:NN"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        dateFormat: "MMM DD, YYYY JJ:NN",
        position: "top",
        toText: "To:",
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
                period: "DD",
                selected: true,
                count: 1,
                label: "1 day"
            },
            {
                period: "MM",
//                selected: true,
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
        "enabled": true,
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "JEPX_Spot"
            }]
    },
    "numberFormatter": {
        "precision": 2,
        "decimalSeparator": ",",
        "thousandsSeparator": ""
    }
});

