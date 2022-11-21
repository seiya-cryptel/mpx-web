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
     system_price: "システムプライス"
     hokkaido: "北海道"
     tohoku: "東北"
     tokyo: "東京"
     chubu: "中部"
     hokuriku: "北陸"
     kansai: "関西"
     chugoku: "中国"
     shikoku: "四国"
     kyushu: "九州"
     */
}

var chartSpat = AmCharts.makeChart("chartdiv_spot_all", {
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
            title: "Spot Price (円/kWh)",
            showCategoryAxis: false,
            percentHeight: 70,
            stockGraphs: [
                // システムプライス
                {
                    id: "g1",
                    title: "システムプライス",
                    valueField: "system_price",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>システムプライス [[value]]</span>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // 北海道
                {
                    id: "g2",
                    title: "北海道",
                    valueField: "hokkaido",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>北海道 [[value]]</span>",
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
                // 東北
                {
                    id: "g3",
                    title: "東北",
                    valueField: "tohoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>東北 [[value]]</span>",
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
                // 東京
                {
                    id: "g4",
                    title: "東京",
                    valueField: "tokyo",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>東京 [[value]]</span>",
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
                // 中部
                {
                    id: "g5",
                    title: "中部",
                    valueField: "chubu",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>中部 [[value]]</span>",
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
                // 北陸
                {
                    id: "g6",
                    title: "北陸",
                    valueField: "hokuriku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>北陸 [[value]]</span>",
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
                // 関西
                {
                    id: "g7",
                    title: "関西",
                    valueField: "kansai",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>関西 [[value]]</span>",
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
                // 中国
                {
                    id: "g8",
                    title: "中国",
                    valueField: "chugoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>中国 [[value]]</span>",
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
                // 四国
                {
                    id: "g9",
                    title: "四国",
                    valueField: "shikoku",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>四国 [[value]]</span>",
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
                // 九州
                {
                    id: "g10",
                    title: "九州",
                    valueField: "kyushu",
                    useDataSetColors: false,
                    balloonText: "<span style='font-size:12px;'>九州 [[value]]</span>",
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
                "label": "ダウンロード",
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

