var amount_of_capacity_thermals_data_list = Object.keys(capacity_thermals_data_list).length;
var amount_of_event_data_list_for_thermal = Object.keys(event_data_list_for_thermal).length;

var chartData = [];
for (var i = 0; i < amount_of_capacity_thermals_data_list; i++) {
    var format_date = new Date(capacity_thermals_data_list[i]['dt']);
    chartData[i] = ({
        date: format_date,
        assumption_coal: capacity_thermals_data_list[i]['coal'],
        assumption_lng: capacity_thermals_data_list[i]['lng'],
        assumption_oil: capacity_thermals_data_list[i]['oil'],
    });
}

var eventDataThermal = [];
for (var i = 0; i < amount_of_event_data_list_for_thermal; i++) {
    var format_date = new Date(event_data_list_for_thermal[i]['dt']);
    var display_date = '' + format_date.getFullYear() + '/' + ('0' + (format_date.getMonth() + 1)).slice(-2) + '/' + ('0' + format_date.getDate()).slice(-2);
    var graph_name;
    switch(event_data_list_for_thermal[i]['category']) {
    case 'coal':
        graph_name = 'g1';
        break;
    case 'oil':
        graph_name = 'g3';
        break;
    default:
        graph_name = 'g2';
        break;
    }
    eventDataThermal[i] = ({
        date: format_date,
        type: "text",
        graph: graph_name,
        text: event_data_list_for_thermal[i]['event'],
        description: display_date + ' ' + event_data_list_for_thermal[i]['description']
    });
}

// console.log("eventData");
// ocnsole.log(eventData);

var chart = AmCharts.makeChart("chartdiv_capacity_thermals", {
    type: "stock",
    theme: "light",
    // dataDateFormat: "YYYY-MM",
    dataDateFormat: "YYYY/MM/DD",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "assumption_coal",
                    toField: "assumption_coal"
                },
                {
                    fromField: "assumption_lng",
                    toField: "assumption_lng"
                },
                {
                    fromField: "assumption_oil",
                    toField: "assumption_oil"
                }
            ],
            dataProvider: chartData,
            categoryField: "date",
            // EVENTS
            stockEvents: eventDataThermal
        }
    ],
    panels: [{
            title: "Capacity(MW)",
            showCategoryAxis: false,
            percentHeight: 70,
            valueAxes: [{
                    id: "v1",
                    dashLength: 5,
                    stackType: "regular"
                }],
            categoryAxis: {
                dashLength: 5
            },
            stockGraphs: [
                {
                    // coal
                    type: "line",
                    id: "g1",
                    valueField: "assumption_coal",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletSize: 5,
                    lineThickness: 2,
                    fillAlphas: 0.3,
                    useDataSetColors: false,
                    title: "Coal",
                    periodValue: "Average"
                }, {
                    // lng
                    type: "line",
                    id: "g2",
                    valueField: "assumption_lng",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletSize: 5,
                    lineThickness: 2,
                    fillAlphas: 0.3,
                    useDataSetColors: false,
                    title: "LNG",
                    periodValue: "Average"
                }, {
                    // oil
                    type: "line",
                    id: "g3",
                    valueField: "assumption_oil",
                    balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletSize: 5,
                    fillAlphas: 0.3,
                    lineThickness: 2,
                    useDataSetColors: false,
                    title: "Oil",
                    periodValue: "Average"
                }],
            stockLegend: {
                valueTextRegular: undefined,
                periodValueTextComparing: "[[percents.value.close]]%"
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
                        format: "MMM YYYY",
                    },
                    {
                        period: "WW",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "DD",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "mm",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "ss",
                        format: "MMM DD, YYYY",
                    },
                    {
                        period: "fff",
                        format: "MMM DD, YYYY",
                    },
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        // dateFormat: "YYYY-MM",
        dateFormat: "MMM YYYY",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        periods: [
            {
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
        "enabled": true, // TODO CSV の　ダウンロード
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "Download",
                "title": "Export chart to CSV",
                "fileName": "ThermalCapacity_" + export_date + filename_area
            }]
    }
});
