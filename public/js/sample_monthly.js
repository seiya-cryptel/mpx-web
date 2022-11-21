
// 小数点第2以下切り捨て
function sm_format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var sm_chartData = [];

var amount_of_monthly_data_list = Object.keys(monthly_sample_data).length;

// カウンタ変数
var sm_j = 0;
for (var i = 0; i < amount_of_monthly_data_list; i++) {
    var format_date = new Date(monthly_sample_data[i]['fc_datetime']);
    var price_base = sm_format_value(monthly_sample_data[i]['price_base']);
    var price_offpeak = sm_format_value(monthly_sample_data[i]['price_offpeak']);
    var price_peak = sm_format_value(monthly_sample_data[i]['price_peak']);
    sm_chartData[sm_j] = ({
        date: format_date,
        value1: price_base,
        value2: price_offpeak,
        value3: price_peak
    });
    sm_j++;
}

var sm_chart = AmCharts.makeChart( "monthly_chart", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [ {
        fieldMappings: [
            {
              fromField: "value1",
              toField: "value1"
            },
            {
              fromField: "value2",
              toField: "value2"
            },
            {
              fromField: "value3",
              toField: "value3"
            }
        ],
        dataProvider: sm_chartData,
        categoryField: "date"
    } ],

    panels: [ {
        title: "Monthly (円/kWh)",
        showCategoryAxis: true,
        percentHeight: 70,

        stockGraphs: [ 
            // price base
            {
                id: "g1",
                title: "ベースロード",
                valueField: "value1",
                useDataSetColors: false,
                lineColor: "blue", 	
                balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 50,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"  // 2016/03/11
            },
            // price_peak
            {
                id: "g3",
                title: "日中ロード",
                valueField: "value3",
                useDataSetColors: false,
                lineColor: "gray", 	
                balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
                bullet: "round",
                bulletBorderAlpha: 1,
                bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 50,
                lineThickness: 2,
                useLineColorForBulletBorder: true
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
                period: "YYYY",
                // selected: true,
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

// sm_chart.invalidateSize();
