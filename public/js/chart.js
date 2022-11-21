// console.log(dairy_data_list[0][0]);

var amount_of_dairy_data_list = Object.keys(dairy_data_list).length;
var chartData = [];

j = 1;
for (var i = 0; i < amount_of_dairy_data_list; i++) {
    chartData[i] = ({
        date: dairy_data_list[j][0],
        value: dairy_data_list[j][1]
    });
    j++;
}

var chart = AmCharts.makeChart("chartdiv", {
    "type": "serial",
    "theme": "light",
    "marginRight": 80,
    "autoMarginOffset": 20,
    "dataDateFormat": "YYYY-MM-DD", // フォーマット
    "valueAxes": [{
        "id": "v1",
        "axisAlpha": 0,
        "position": "left",
        "title": "Daily", // タイトル
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
        "oppositeAxis":false, // スライダー位置
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
            "fileName": "フォワードカーブ(Daily)"
          },]
    },
    "dataProvider": chartData
});

chart.addListener("rendered", zoomChart);

zoomChart();

function zoomChart() {
        chart.zoomToIndexes(0, chart.dataProvider.length - 1);

    // chart.zoomToIndexes(chart.dataProvider.length - 40, chart.dataProvider.length - 1);
}
