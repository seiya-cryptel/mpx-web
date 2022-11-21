// 小数点第2以下切り捨て
function sd_format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var sd_chartData = [];

var amount_of_daily_data_list = Object.keys(daily_sample_data).length;

// カウンタ変数
var sd_j = 0;
for (var i = 0; i < amount_of_daily_data_list; i++) {
    var format_date = new Date(daily_sample_data[i]['fc_datetime']);
    var price = sd_format_value(daily_sample_data[i]['price']);
    sd_chartData[sd_j] = ({
        date: format_date,
        value1: price
    });
    sd_j++;
}

var sd_chart = AmCharts.makeChart( "chartdiv", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD",
    categoryAxesSettings: {
        minPeriod: "DD",
        maxSeries: 1500  // 2016/03/11
    },
    dataSets: [ {
        fieldMappings: [ {
            fromField: "value1",
            toField: "value1"
        } ],
        dataProvider: sd_chartData,
        categoryField: "date"
    } ],
    panels: [ {
        title: "Daily (円/kWh)",
        showCategoryAxis: true,
        percentHeight: 70,

        stockGraphs: [ 
            // daily
            {
                id: "g1",
                title: "Daily",
                valueField: "value1",
                useDataSetColors: false,
                lineColor: "#67b7dc", 	
                // balloonColor: "#67b7dc",
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
        dateFormat: "YYYY-MM-DD",
        position: "top",
        toText: "To:",
        selectFromStart: true,  // 2016/03/11
        periods: [
            {
                period: "MM",
                // selected: true,
                count: 1,
                label: "1 month"
            }, 
            {
                period: "YYYY",
                count: 1,
                label: "1 year"
            },
            {
                period: "MAX",
                label: "MAX"
            } 
        ]
    },
} );

// sd_chart.invalidateSize();
