var amount_of_demand_forecast_data_list = Object.keys(demand_forecast_data_list).length;

var chartData = [];

for (var i = 0; i < amount_of_demand_forecast_data_list; i++) {
    var format_date = new Date(demand_forecast_data_list[i]['fc_datetime']);
    chartData[i] = ({
        "date": format_date,
        "biomass": demand_forecast_data_list[i]['biomass']
    });
}


var chart = AmCharts.makeChart("chartdiv_biomass", {
    "type": "stock",
    "theme": "light",
    // dataDateFormat: "YYYY-MM-DD JJ:NN",
    dataDateFormat: "YYYY/MM/DD JJ:NN",
    "categoryAxesSettings": {
        // minPeriod: "MM"
        minPeriod: "mm",
        maxSeries: 150
    },
    "dataSets": [{
            "fieldMappings": [
                {
                    "fromField": "biomass",
                    "toField": "biomass"
                }
            ],
            "dataProvider": chartData,
            "categoryField": "date"
        }
    ],
    "panels": [{
            "title": "Production(MW)",
            "showCategoryAxis": true,
            "percentHeight": 70,
            "stockGraphs": [
                // Biomass
                {
                    "id": "g1",
                    "title": "Biomass",
                    "valueField": "biomass",
                    "useDataSetColors": false,
                    "balloonText": "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    "bullet": "round",
                    "bulletBorderAlpha": 1,
                    "bulletColor": "#FFFFFF",
                    "bulletSize": 5,
                    "hideBulletsCount": 50,
                    "lineThickness": 2,
                    "useLineColorForBulletBorder": true,
                    "periodValue": "Average"
                }
            ],
            // 上のグラフのタイトル
            "stockLegend": {
                "periodValueTextComparing": "[[percents.value.close]]%",
                "periodValueTextRegular": "[[value.close]]"
            }
        }

    ],
    "valueAxesSettings": {
        "inside": false,
        "showLastLabel": true,
        "minimum": 0      // 2016/04/18
    },
    "panelsSettings": {
        "plotAreaFillAlphas": 1,
        "marginLeft": 80,
        "marginTop": 5,
        "marginBottom": 5
    },
    // 下のカーソル
    "chartScrollbarSettings": {
        "graph": "g1"
    },
    // 左と下に表示される値
    "chartCursorSettings": {
        "valueBalloonsEnabled": true,
        "fullWidth": true,
        "cursorAlpha": 0.1,
        "valueLineBalloonEnabled": true,
        "categoryBalloonDateFormats":
                [
                    {
                        "period": "YYYY",
                        "format": "YYYY"
                    },
                    {
                        "period": "MM",
                        "format": "MMM YYYY"
                    },
                    {
                        "period": "WW",
                        "format": "MMM DD, YYYY"
                    },
                    {
                        "period": "DD",
                        "format": "MMM DD, YYYY"
                    },
                    {
                        "period": "mm",
                        "format": "MMM DD, YYYY JJ:NN"
                    },
                    {
                        "period": "ss",
                        "format": "MMM DD, YYYY JJ:NN"
                    },
                    {
                        "period": "fff",
                        "format": "MMM DD, YYYY JJ:NN"
                    }
                ],
        "valueLineEnabled": true,
        "valueLineAlpha": 0.5
    },
    "periodSelector": {
        // dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        dateFormat: "MMM DD, YYYY JJ:NN",
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
                period: "YTD",
                label: "YTD"
            }, 
            {
                // selected: true,
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
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "Biomass_" + export_date + filename_area
            }]
    }
});
