var chartData = [];
generateChartData();

function generateChartData() {
    var firstDate = new Date(2012, 0, 1);
    firstDate.setDate(firstDate.getDate() - 500);
    firstDate.setHours(0, 0, 0, 0);

    for (var i = 0; i < 500; i++) {
        var newDate = new Date(firstDate);
        newDate.setDate(newDate.getDate() + i);

        var a = Math.round(Math.random() * (40 + i)) + 100 + i;
        var b = Math.round(Math.random() * 100000000);

        chartData.push({
            date: newDate,
            value: a,
            volume: b
        });
    }
}

var chart = AmCharts.makeChart("chartdiv_nuclearsupply", {
    type: "stock",
    "theme": "light",
    dataSets: [{
            color: "#b0de09",
            fieldMappings: [{
                    fromField: "value",
                    toField: "value"
                }, {
                    fromField: "volume",
                    toField: "volume"
                }],
            dataProvider: chartData,
            categoryField: "date",
            // EVENTS
            stockEvents: [{
                    date: new Date(2010, 8, 19),
                    type: "sign",
                    backgroundColor: "#85CDE6",
                    graph: "g1",
                    text: "S",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2010, 10, 19),
                    type: "flag",
                    backgroundColor: "#FFFFFF",
                    backgroundAlpha: 0.5,
                    graph: "g1",
                    text: "F",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2010, 11, 10),
                    showOnAxis: true,
                    backgroundColor: "#85CDE6",
                    type: "pin",
                    text: "X",
                    graph: "g1",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2010, 11, 26),
                    showOnAxis: true,
                    backgroundColor: "#85CDE6",
                    type: "pin",
                    text: "Z",
                    graph: "g1",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 0, 3),
                    type: "sign",
                    backgroundColor: "#85CDE6",
                    graph: "g1",
                    text: "U",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 1, 6),
                    type: "sign",
                    graph: "g1",
                    text: "D",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 3, 5),
                    type: "sign",
                    graph: "g1",
                    text: "L",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 3, 5),
                    type: "sign",
                    graph: "g1",
                    text: "R",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 5, 15),
                    type: "arrowUp",
                    backgroundColor: "#00CC00",
                    graph: "g1",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 6, 25),
                    type: "arrowDown",
                    backgroundColor: "#CC0000",
                    graph: "g1",
                    description: "説明"
//                    description: "This is description of an event"
                }, {
                    date: new Date(2011, 8, 1),
                    type: "text",
                    graph: "g1",
                    text: "女川原発1号機停止",
                    description: "説明"
//                    description: "This is description of an event"
                }]
        }],
    panels: [{
            title: "Value",
            percentHeight: 70,
            stockGraphs: [{
                    id: "g1",
                    valueField: "value"
                }],
            stockLegend: {
                valueTextRegular: " ",
                markerType: "none"
            }
        }],
    chartScrollbarSettings: {
        graph: "g1"
    },
    chartCursorSettings: {
        valueBalloonsEnabled: true,
        graphBulletSize: 1,
        valueLineBalloonEnabled: true,
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM-DD",
        position: "top",
        toText: "To:",
        periods: [{
                period: "DD",
                count: 10,
                label: "10 days"
            }, {
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
            }, {
                period: "MAX",
                label: "MAX"
            }]
    },
    panelsSettings: {
        usePrefixes: true
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