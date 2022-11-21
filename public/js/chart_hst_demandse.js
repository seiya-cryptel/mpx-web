var amount_of_hst_demands_data_list = Object.keys(hst_demands_data_list).length;

var chartData2 = [];

for (var i = 0; i < amount_of_hst_demands_data_list; i++) {
    var format_date = new Date(hst_demands_data_list[i]['dt']);
    chartData2[i] = ({
        date: format_date,
        historicaldemand_all: hst_demands_data_list[i]['demand'],
        historicaldemand_east: hst_demands_data_list[i]['east'],
        historicaldemand_west: hst_demands_data_list[i]['west'],
        historicaldemand_hokkaido: hst_demands_data_list[i]['hokkaido'],        // 2017/02/19
        historicaldemand_kyushu: hst_demands_data_list[i]['kyushu'],
    });
}

var chart_coal2 = AmCharts.makeChart("chartdiv_hst_demands", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM-DD JJ:NN",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500  // 2016/03/11
    },
    dataSets: [{
        fieldMappings: [
        {
            fromField: "historicaldemand_all",
            toField: "historicaldemand_all"
        },
        {
            fromField: "historicaldemand_east",
            toField: "historicaldemand_east"
        },
        {
            fromField: "historicaldemand_west",
            toField: "historicaldemand_west"
        },
        {   // 2017/02/19
            fromField: "historicaldemand_hokkaido",
            toField: "historicaldemand_hokkaido"
        },
        {
            fromField: "historicaldemand_kyushu",
            toField: "historicaldemand_kyushu"
        },
        ],
        dataProvider: chartData2,
        categoryField: "date"
    } ],
    panels: [{
        precision: 0,   // 2016/04/15
        title: "Load(MW)",
        showCategoryAxis: true,
        percentHeight: 70,
        stockGraphs: [
        // All
        {
            id: "g1",
            title: "All",
            valueField: "historicaldemand_all",
            // type: "column",
            // lineColor: "#00479d",
            // fillAlphas: 0.8,
            // lineAlpha: 0.2,
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
        // East
        {
            id: "g2",
            title: "East",
            valueField: "historicaldemand_east",
            // type: "column",
            // lineColor: "#22ac38",
            // fillAlphas: 0.8,
            // lineAlpha: 0.2,
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
            hidden: true,   // 2017/2/24, 2016/07/08
        },
        // West
        {
            id: "g3",
            title: "West",
            valueField: "historicaldemand_west",
            // type: "column",
            // lineColor: "#a4005b",
            // fillAlphas: 0.8,
            // lineAlpha: 0.2,
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
            hidden: true,   // 2017/2/24, 2016/07/08
        },
        // 北海道 2017/02/19
        {
            id: "g4",
            title: "Hokkaido",
            valueField: "historicaldemand_hokkaido",
            // type: "column",
            // lineColor: "#1d66eb",
            // fillAlphas: 0.8,
            // lineAlpha: 0.2,
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
            hidden: true,   // 2017/2/24, 2016/07/08
        },
        // 九州
        {
            id: "g5",
            title: "Kyushu",
            valueField: "historicaldemand_kyushu",
            // type: "column",
            // lineColor: "#df65b0",
            // fillAlphas: 0.8,
            // lineAlpha: 0.2,
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
            hidden: true,   // 2017/2/24, 2016/07/08
        },
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
                        "format": "MMM YYYY"
                    },
                    {
                        period: "WW",
                        format: "MMM DD, YYYY"
                    },
                    {
                        period: "DD",
                        format: "MMM DD, YYYY"
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
        // dateFormat: "YYYY-MM-DD",
        dateFormat: "MMM DD, YYYY",
        position: "top",
        toText: "To:",
        selectFromStart: false,
        inputFieldWidth: 120,   // 2016/06/28
        periods: [{
                period: "DD",
                count: 1,
                label: "1 day"
            },
            {
                selected: true,
                period: "MM",
                count: 1,
                label: "1 month"
            }, {
                period: "YYYY",
                count: 1,
                label: "1 year"
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
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "HistoricalDemand"
            }]
    }
});
