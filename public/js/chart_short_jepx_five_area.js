// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_short_data_list = Object.keys(short_data_list).length;

// カウンタ変数
var j = 0;
for (var i in short_data_list) {
    var format_date = short_data_list[i]['dt'];
    chartData[j] = ({
        date: format_date,
        system_price: format_value(short_data_list[i]['spot']),
        east_price: format_value(short_data_list[i]['spot_east']),
        west_price: format_value(short_data_list[i]['spot_west']),
        hokkaido_price: format_value(short_data_list[i]['spot_hokkaido']),   
        kyushu_price: format_value(short_data_list[i]['spot_kyushu']),
    });
    j++;
}

var chart_short = AmCharts.makeChart("chartdiv_shortjepx", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        // minPeriod: "30mm", 2022/07/16
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
                    fromField: "east_price",
                    toField: "east_price"
                },
                {
                    fromField: "west_price",
                    toField: "west_price"
                },
                {
                    fromField: "hokkaido_price",
                    toField: "hokkaido_price"
                },
                {
                    fromField: "kyushu_price",
                    toField: "kyushu_price"
                },
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
        precision: 2,
        title: dict["Spot Price (円/kWh)"],
        showCategoryAxis: true,
        percentHeight: 70,
        stockGraphs: [
        // System
        {
            id: "g1",
            title: dict["システムプライス"],
            valueField: "system_price",
            useDataSetColors: false,
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
        // East
        {
            id: "g2",
            title: dict["東エリアプライス"],
            valueField: "east_price",
            useDataSetColors: false,
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
        // West
        {
            id: "g3",
            title: dict["西エリアプライス"],
            valueField: "west_price",
            useDataSetColors: false,
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
        // 北海道 2017/02/20
        {
            id: "g4",
            title: dict["北海道エリアプライス"],
            valueField: "hokkaido_price",
            useDataSetColors: false,
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
        // 九州
        {
            id: "g5",
            title: dict["九州エリアプライス"],
            valueField: "kyushu_price",
            useDataSetColors: false,
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
        ],
        // 上のグラフのタイトル
        stockLegend: {
            periodValueTextComparing: "[[percents.value.close]]%",
            periodValueTextRegular: "[[value.close]]"
        }
    } ],
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
            /* 2016/10/16
            {
                period: "MM",
                count: 1,
                label: "1 month"
            }, {
                period: "YYYY",
                count: 1,
                label: "1 year"
            }, 
            {
                period: "YTD",
                label: "YTD"
            }, 
            */ 
            {
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
                "label": dict["ダウンロード"],
                "title": "Export chart to CSV",
                "fileName": "JEPX_forecast_" + export_date + filename_area
            }]
    }
});
