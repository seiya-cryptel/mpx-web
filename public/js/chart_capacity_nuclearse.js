var amount_of_capacity_nuclears_data_list = Object.keys(capacity_nuclears_data_list).length;
var amount_of_event_data_list_for_nuclear = Object.keys(event_data_list_for_nuclear).length;


var chartData = [];

for (var i = 0; i < amount_of_capacity_nuclears_data_list; i++) {
    var format_date = new Date(capacity_nuclears_data_list[i]['dt']);
    chartData[i] = ({
        "date": format_date,
        "assumption_nuclear": capacity_nuclears_data_list[i]['nuclear']
    });
}

var eventData = [];
for (var i = 0; i < amount_of_event_data_list_for_nuclear; i++) {
    var format_date = new Date(event_data_list_for_nuclear[i]['dt']);
    var display_date = '' + format_date.getFullYear() + '/' + ('0' + (format_date.getMonth() + 1)).slice(-2) + '/' + ('0' + format_date.getDate()).slice(-2);
    eventData[i] = ({
        date: format_date,
        type: "sign",
        backgroundColor: "#85CDE6",
        graph: "g1",
        text: event_data_list_for_nuclear[i]['event'],
        description: display_date + ' ' + event_data_list_for_nuclear[i]['description']
    });
}

var chart = AmCharts.makeChart("chartdiv_capacity_nuclears", {
    "type": "stock",
    "theme": "light",
    // dataDateFormat: "YYYY-MM",
    dataDateFormat: "YYYY/MM/DD",
    "categoryAxesSettings": {
        minPeriod: "MM"
    },
    "dataSets": [{
            "fieldMappings": [
                {
                    "fromField": "assumption_nuclear",
                    "toField": "assumption_nuclear"
                }
            ],
            "dataProvider": chartData,
            "categoryField": "date",
            // EVENTS
            stockEvents: eventData
        }
    ],
    "panels": [{
            "title": "Capacity(MW)",
            "showCategoryAxis": true,
            "percentHeight": 70,
            "stockGraphs": [
                // Nuclear
                {
                    "id": "g1",
                    "title": "Nuclear",
                    "valueField": "assumption_nuclear",
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
                        "format": "MMM DD, YYYY"
                    },
                    {
                        "period": "ss",
                        "format": "MMM DD, YYYY"
                    },
                    {
                        "period": "fff",
                        "format": "MMM DD, YYYY"
                    }
                ],
        "valueLineEnabled": true,
        "valueLineAlpha": 0.5
    },
    "periodSelector": {
        // dateFormat: "YYYY-MM",
        dateFormat: "MMM YYYY",
        "position": "top",
        "toText": "To:",
        "selectFromStart": true,
        "periods": [
            {
                "period": "YYYY",
                "count": 1,
                "label": "1 year"
            },
            {
                "count": 1,
                "period": "MAX",
                "label": "MAX"
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
                "fileName": "NuclearCapacity_" + export_date + filename_area
            }]
    }
});
