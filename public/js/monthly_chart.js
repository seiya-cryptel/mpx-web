var chartData = [];

var amount_of_monthly_baseload_data_list = Object.keys(monthly_baseload_data_list).length;

var chartData = [];

j = 1;
for (var i = 0; i < amount_of_monthly_baseload_data_list; i++) {
    chartData[i] = ({
        date: monthly_baseload_data_list[j][0],
        monthry_baseload: monthly_baseload_data_list[j][1],
        monthry_offpeak: monthly_offpeak_data_list[j][1],
        monthry_peakload: monthly_peakload_data_list[j][1]
    });
    j++;
}


// chartData.push({
//     date: "2015-10-17",
//     monthry_baseload: 10.3451,
//     monthry_offpeak: 9.7311,
//     monthry_peakload: 11.3099
// });

// chartData.push({
//     date: "2015-11-01",
//     monthry_baseload: 10.3451,
//     monthry_offpeak: 9.7403,
//     monthry_peakload: 11.2215
// });

// chartData.push({
//     date: "2015-12-01",
//     monthry_baseload: 10.7651,
//     monthry_offpeak: 10.0135,
//     monthry_peakload: 11.7502
// });




var chart3 = AmCharts.makeChart("monthly_chart", {
    "type": "serial",
    "theme": "light",
    "legend": {
        "useGraphSettings": true
    },
    "dataProvider": chartData,
    "valueAxes": [{
        "id":"v1",
        "axisColor": "#FF6600",
        "axisThickness": 2,
        "gridAlpha": 0,
        "axisAlpha": 1,
        "position": "left",
        "duration": "mm",
        "durationUnits": {
            "mm": "円/kWh"
        },
    }, {
        "id":"v2",
        "axisColor": "#FCD202",
        "axisThickness": 2,
        "gridAlpha": 0,
        "axisAlpha": 1,
        "position": "right",
        "duration": "mm",
        "durationUnits": {
            "mm": "円/kWh"
        },
    }, {
        "id":"v3",
        "axisColor": "#B0DE09",
        "axisThickness": 2,
        "gridAlpha": 0,
        "offset": 50,
        "axisAlpha": 1,
        "position": "left",
        "title": "Monthly", // タイトル
        "duration": "mm",
        "durationUnits": {
            "mm": "円/kWh"
        },
    }],
    "graphs": [

    {
        "valueAxis": "v1",
        "lineColor": "#FF6600",
        "bullet": "round",
        "bulletBorderThickness": 1,
        "hideBulletsCount": 30,
        "title": "monthry_baseload",
        "valueField": "monthry_baseload",
        "fillAlphas": 0
    }, 

    {
        "valueAxis": "v2",
        "lineColor": "#FCD202",
        "bullet": "square",
        "bulletBorderThickness": 1,
        "hideBulletsCount": 30,
        "title": "monthry_offpeak",
        "valueField": "monthry_offpeak",
        "fillAlphas": 0
    }, 

    {
        "valueAxis": "v3",
        "lineColor": "#B0DE09",
        "bullet": "triangleUp",
        "bulletBorderThickness": 1,
        "hideBulletsCount": 30,
        "title": "monthry_peakload",
        "valueField": "monthry_peakload",
        "fillAlphas": 0
    }

    ],
    "chartScrollbar": {
        "oppositeAxis":false,
    },
    "chartCursor": {
        "cursorPosition": "mouse"
    },
    "categoryField": "date",
    "categoryAxis": {
        "parseDates": true,
        "axisColor": "#DADADA",
        "minPeriod" : "MM",         /* X軸の単位 */
        "minorGridEnabled": true
    },
    "export": {
        "enabled": true, // TODO CSV の　ダウンロード
        "libs": {
            "path":
            "http://www.amcharts.com/lib/3/plugins/export/libs/"
        },
        "menu": [{
            "format": "CSV",
            "label": "ダウンロード",
            "title": "Export chart to CSV",
            "fileName": "フォワードカーブ(Monthly)"
          },]
    },
});

chart.addListener("dataUpdated", zoomChart);
zoomChart();

function zoomChart(){
    chart3.zoomToIndexes(chart3.dataProvider.length - 20, chart3.dataProvider.length - 1);
}
