var chartData = [];

var amount_of_half_hourly_data_list = Object.keys(half_hourly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in half_hourly_data_list) {
    var hoge = half_hourly_data_list[i][0] + " " + half_hourly_data_list[i][1];
    chartData[j] = ({
        date: hoge,
        value: half_hourly_data_list[i][2],
    });
    j++;
}
// chartData = [
//     {
//         "date": "2015-10-17 00:00",
//         "value": 10000
//     }, {
//         "date": "2015-10-17 00:30",
//         "value": 10030
//     }, {
//         "date": "2015-10-17 01:00",
//         "value": 10030
//     }, {
//         "date": "2015-10-17 01:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 02:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 02:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 03:00",
//         "value": 13
//     }, {
//         "date": "2015-10-17 03:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 04:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 04:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 05:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 05:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 06:00",
//         "value": 13
//     }, {
//         "date": "2015-10-17 06:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 07:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 07:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 08:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 08:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 09:00",
//         "value": 13
//     }, {
//         "date": "2015-10-17 09:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 10:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 10:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 11:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 11:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 12:00",
//         "value": 12000
//     }, {
//         "date": "2015-10-17 12:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 13:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 13:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 14:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 14:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 15:00",
//         "value": 13
//     }, {
//         "date": "2015-10-17 15:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 16:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 16:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 17:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 17:30",
//         "value": 15
//     }, {
//         "date": "2015-10-17 18:00",
//         "value": 13
//     }, {
//         "date": "2015-10-17 18:30",
//         "value": 11
//     }, {
//         "date": "2015-10-17 19:00",
//         "value": 15
//     }, {
//         "date": "2015-10-17 19:30",
//         "value": 13
//     }, {
//         "date": "2015-10-17 20:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 20:30",
//         "value": 15
//     },  {
//         "date": "2015-10-17 21:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 21:30",
//         "value": 15
//     },  {
//         "date": "2015-10-17 22:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 22:30",
//         "value": 15
//     },  {
//         "date": "2015-10-17 23:00",
//         "value": 11
//     }, {
//         "date": "2015-10-17 23:30",
//         "value": 15
//     },



//     {
//         "date": "2015-10-18 00:00",
//         "value": 10000
//     }, {
//         "date": "2015-10-18 00:30",
//         "value": 10030
//     }, {
//         "date": "2015-10-18 01:00",
//         "value": 10030
//     }, {
//         "date": "2015-10-18 01:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 02:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 02:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 03:00",
//         "value": 13
//     }, {
//         "date": "2015-10-18 03:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 04:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 04:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 05:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 05:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 06:00",
//         "value": 13
//     }, {
//         "date": "2015-10-18 06:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 07:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 07:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 08:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 08:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 09:00",
//         "value": 13
//     }, {
//         "date": "2015-10-18 09:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 10:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 10:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 11:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 11:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 12:00",
//         "value": 12000
//     }, {
//         "date": "2015-10-18 12:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 13:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 13:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 14:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 14:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 15:00",
//         "value": 13
//     }, {
//         "date": "2015-10-18 15:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 16:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 16:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 17:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 17:30",
//         "value": 15
//     }, {
//         "date": "2015-10-18 18:00",
//         "value": 13
//     }, {
//         "date": "2015-10-18 18:30",
//         "value": 11
//     }, {
//         "date": "2015-10-18 19:00",
//         "value": 15
//     }, {
//         "date": "2015-10-18 19:30",
//         "value": 13
//     }, {
//         "date": "2015-10-18 20:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 20:30",
//         "value": 15
//     },  {
//         "date": "2015-10-18 21:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 21:30",
//         "value": 15
//     },  {
//         "date": "2015-10-18 22:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 22:30",
//         "value": 15
//     },  {
//         "date": "2015-10-18 23:00",
//         "value": 11
//     }, {
//         "date": "2015-10-18 23:30",
//         "value": 15
//     },




//     ];
// json key取得

// 30分ごとのデータを扱う
// 1日48のデータ(24h*2)
// 3年分のデータ(48 * 365日 * 3年)
// j = 1;
// // for (var i = 0; i < 48*365*3; i++) {
// for (var i = 0; i < amount_of_half_hourly_data_list; i++) {
//     var hoge = half_hourly_data_list[j][0] + " " + half_hourly_data_list[j][1];
//     chartData[i] = ({
//         date: hoge,
//         price: half_hourly_data_list[j][2],
//     });
//     j++;
// }


var chart2 = AmCharts.makeChart("chartdiv2", {
    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "dataDateFormat": "YYYY-MM-DD JJ:NN",
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "title": "Half hourly", // タイトル
        "duration": "mm",
        "durationUnits": {
            "mm": "円/kWh"
        },
    }],
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
    },
    "graphs": [{
        "id": "g1",
        "bullet": "round",
        "bulletBorderAlpha": 1,
        "bulletColor": "#FFFFFF",
        "bulletSize": 5,
        "hideBulletsCount": 50,
        "lineThickness": 2,
        "title": "red line",
        "useLineColorForBulletBorder": true,
        "valueField": "value",
        "balloonText": "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>"
    }],
    "chartScrollbar": {
        "graph": "g1",
        "oppositeAxis":false,
        "offset":30,
        "scrollbarHeight": 80,
        "backgroundAlpha": 0,
        "selectedBackgroundAlpha": 0.1,
        "selectedBackgroundColor": "#888888",
        "graphFillAlpha": 0,
        "graphLineAlpha": 0.5,
        "selectedGraphFillAlpha": 0,
        "selectedGraphLineAlpha": 1,
        "autoGridCount":true,
        "color":"#AAAAAA"
    },
    "chartCursor": {
        // 左のツールチップ
        "pan": false,
        "valueLineEnabled": false,
        "valueLineBalloonEnabled": false,
        "cursorAlpha":0,
        "valueLineAlpha":0.2
    },
    "categoryField": "date",
    "categoryAxis": {
        "minPeriod": "mm", // 最低のメモリ
        "parseDates": true,
        "dashLength": 1,
        "minorGridEnabled": false // 細かい線
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
            "fileName": "フォワードカーブ(Half-hourly)"
          },]
    },
    "dataProvider": chartData
});

chart.addListener("rendered", zoomChart);

zoomChart();

function zoomChart() {
    chart2.zoomToIndexes(chartData.length - 250, chartData.length - 100);
}
