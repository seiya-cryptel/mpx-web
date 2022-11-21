// カウンタ変数
var chartData = [];
var j = 0;
for (var i in delivery_monthly_data_list) {
//    var format_date = new Date(delivery_monthly_data_list[i]['fc_datetime']);
    chartData[j] = ({
//        country: delivery_monthly_data_list[i]['price_base'],
        country: delivery_monthly_data_list[i]['country'],
        visits: delivery_monthly_data_list[i]['visits'],
    });
    j++;
}

var chart = AmCharts.makeChart("chartdiv_delivery_monthly_distribution", {
    "type": "serial",
    "theme": "light",
    "dataProvider": chartData,
    "valueAxes": [{
        "gridColor": "#FFFFFF",
        "gridAlpha": 0.2,
        "dashLength": 0
    }],
    "gridAboveGraphs": true,
    "startDuration": 1,
    "graphs": [{
            "balloonText": "[[category]]: <b>[[value]]</b>",
            "fillAlphas": 0.8,
            "lineAlpha": 0.2,
            "type": "column",
            "valueField": "visits"
        }],
    "chartCursor": {
        "categoryBalloonEnabled": false,
        "cursorAlpha": 0,
        "zoomable": false
    },
    "categoryField": "country",
    "categoryAxis": {
        "gridPosition": "start",
        "gridAlpha": 0,
        "tickPosition": "start",
        "tickLength": 20,
        "title": "Forward Price (円/kWh)"   // 2016/07/22
    },

});