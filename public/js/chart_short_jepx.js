var amount_of_short_data_list = Object.keys(short_data_list).length;

var chartData2 = [];

for (var i = 0; i < amount_of_short_data_list; i++) {
    var format_date = new Date(short_data_list[i]['dt']);
    chartData2[i] = ({
        date: format_date,
        // system_price: short_data_list[i]['spot'],
        price: short_data_list[i]['spot'],
    });
}

var chart_short = AmCharts.makeChart("chartdiv_shortjepx", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500  // 2016/03/11
    },
    dataSets: [{
        fieldMappings: [
        {
            // fromField: "system_price",
            // toField: "system_price"
            fromField: "price",
            toField: "price"
        },
        ],
        dataProvider: chartData2,
        categoryField: "date"
    } ],
    panels: [{
        precision: 2,
        title: dict["Spot Price (円/kWh)"],
        showCategoryAxis: true,
        percentHeight: 70,
        stockGraphs: [
        // Short
        {
            id: "g1",
            // title: "System_price",
            // valueField: "system_price",
            // title: "Price",
            title: series_name,
            valueField: "price",
            useDataSetColors: false,
            balloonText: "<div style='margin:5px; font-size:19px;'><span style='font-size:13px;'>[[category]]</span><br>[[value]]</div>",
            bullet: "round",
            bulletBorderAlpha: 1,
            bulletColor: "#FFFFFF",
            bulletSize: 5,
            hideBulletsCount: 50,
            lineThickness: 2,
            useLineColorForBulletBorder: true,
            periodValue: "Average"
        },
        ],
        // 上のグラフのタイトル
        stockLegend: {
            backgroundColor: "red",
            periodValueTextComparing: "[[percents.value.close]]%",
            periodValueTextRegular: "[[value.close]]"
        }
    } ],

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
        categoryBalloonDateFormats: [
        {
            period: "YYYY",
            format: "YYYY"
        },
        {
            period: "MM",
            format: "YYYY-MM"
        },
        {
            period: "WW",
            format: "YYYY-MM-DD"
        },
        {
            period: "DD",
            format: "YYYY-MM-DD"
        },
        {
            period: "mm",
            format: "YYYY-MM-DD JJ:NN"
        },
        {
            period: "ss",
            format: "YYYY-MM-DD JJ:NN"
        },
        {
            period: "fff",
            format: "YYYY-MM-DD JJ:NN"
        }
        ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM-DD JJ:NN", // 2016/06/28
        position: "top",
        toText: "To:",
        selectFromStart: true,  // 2016/10/16
        inputFieldWidth: 160,   // 2016/06/28
        periods: [{
            period: "DD",
            count: 1,
            label: "1 day"
        },
        /*
        {
            period: "MM",
            count: 1,
            label: "1 month"
        }, {
            period: "YYYY",
            count: 1,
            label: "1 year"
        },
        */
        {
            selected: true,
            period: "MAX",
            label: "MAX"
        }]
    },
    
    "export": {
        "enabled": true,
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": dict["ダウンロード"],
                "title": "Export chart to CSV",
                "fileName": "JEPX_forecast_" + export_date + filename_area
            }]
    }
});
