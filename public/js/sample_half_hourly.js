// 小数点第2以下切り捨て
function shh_format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var shh_chartData = [];

var amount_of_half_hourly_data_list = Object.keys(half_hourly_sample_data).length;

// カウンタ変数
var shh_j = 0;
for (var i in half_hourly_sample_data) {
    shh_chartData[shh_j] = ({
        date: half_hourly_sample_data[i]['fc_datetime'],
        value1: shh_format_value(half_hourly_sample_data[i]['price']),
    });
    shh_j++;
}

var shh_chart = AmCharts.makeChart( "chartdiv2", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1200  // 2016/03/11
    },
    dataSets: [ {
        fieldMappings: [
        {
            fromField: "value1",
            toField: "value1"
        }
        ],
        dataProvider: shh_chartData,
        categoryField: "date"
    } ],

    panels: [ {
        title: "Half hourly (円/kWh)",
        showCategoryAxis: true,
        percentHeight: 70,

        stockGraphs: [ 
        // Half hourly
        {
            id: "g1",
            title: "Half hourly",
            valueField: "value1",
            useDataSetColors: false,
            lineColor: "#67b7dc", 	
            balloonColor: "#67b7dc",
            balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
            bullet: "round",
            bulletBorderAlpha: 1,
            bulletColor: "#FFFFFF",
            bulletSize: 5,
            hideBulletsCount: 50,
            lineThickness: 2,
            useLineColorForBulletBorder: true,
            periodValue: "Average"  // 2016/03/11
        }
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
        categoryBalloonDateFormats: MPX_DateFormat,
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },

    periodSelector: {
        dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        position: "top",
        toText: "To:",
        selectFromStart: true,  // 2016/03/11
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
            period: "DD",
            selected: true,
            count: 1,
            label: "1 day"
        }, {
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
        } ]
    },
} );

// shh_chart.invalidateSize();
