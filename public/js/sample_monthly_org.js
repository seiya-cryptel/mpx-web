
// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.floor(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_monthly_data_list = Object.keys(monthly_sample_data).length;

// カウンタ変数
var j = 0;
for (var i = 0; i < amount_of_monthly_data_list; i++) {
    var format_date = new Date(monthly_sample_data[i]['fc_datetime']);
    var price_base = format_value(monthly_sample_data[i]['price_base']);
    var price_offpeak = format_value(monthly_sample_data[i]['price_offpeak']);
    var price_peak = format_value(monthly_sample_data[i]['price_peak']);
    chartData[j] = ({
        date: format_date,
        value1: price_base,
        value2: price_offpeak,
        value3: price_peak
    });
    j++;
}

var chart = AmCharts.makeChart( "monthly_chart", {
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
      dataProvider: chartData,
      categoryField: "date"
    }
  ],

  panels: [ {
        title: "Monthly (円/kWh)",
      showCategoryAxis: true,
      percentHeight: 70,

      stockGraphs: [ 
      // price_base
      {
        id: "g1",
//         title: "price_base",
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
    /*
      // price_offpeak
      {
        id: "g2",
        title: "price_offpeak",
        valueField: "value2",
        useDataSetColors: false,
      	lineColor: "orange", 	
        balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
        bullet: "round",
        bulletBorderAlpha: 1,
        bulletColor: "#FFFFFF",
        bulletSize: 5,
        hideBulletsCount: 50,
        lineThickness: 2,
        useLineColorForBulletBorder: true
      },
      */
      // price_peak
      {
        id: "g3",
//        title: "price_peak",
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
    }

],

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
    categoryBalloonDateFormats: 
            [
                {
                    period:"YYYY", 
                    format:"YYYY",
                },
                {
                    period:"MM", 
                    format:"YYYY-MM",
                },
                {
                    period:"WW", 
                    format:"YYYY-MM-DD",
                },
                {
                    period:"DD", 
                    format:"YYYY-MM-DD",
                },
                {
                    period:"mm", 
                    format:"YYYY-MM-DD",
                },
                {
                    period:"ss", 
                    format:"YYYY-MM-DD",
                },
                {
                    period:"fff", 
                    format:"YYYY-MM-DD",
                },
            ],
    valueLineEnabled: true,
    valueLineAlpha: 0.5
  },

  periodSelector: {
    dateFormat: "YYYY-MM-DD",
    position: "top",
    toText: "To:",
    selectFromStart: true,  // 2016/03/11
    periods: [ 
//    {
//      period: "MM",
//      selected: false,
//      count: 1,
//      label: "1 month"
//    }, 
    {
      period: "YYYY",
      selected: true,
      count: 1,
      label: "1 year"
    }, 
//    {
//      period: "YTD",
//      label: "YTD"
//    }, 
    {
      period: "MAX",
      label: "MAX"
    } ]
  },
//   "export": {
//        "enabled": true, // TODO CSV の　ダウンロード
//        "libs": {
//            "path":
//            "/js/ac/plugins/export/libs/"
//        },
//        "menu": [{
//            "format": "CSV",
//            "label": "ダウンロード",
//            "title": "Export chart to CSV",
//            "fileName": "フォワードカーブ(Daily)"
//          }]
//    }
} );
