function round4(raw) {
    var n = new Number(raw);
    return n.toFixed(4);
}

function roundAny(raw, dig) {
    var n = new Number(raw);
    return n.toFixed(dig);
}

function priceValueLabelFormat(value,valueText,valueAxis) {
    return roundAny(value, 4);
}

function priceCategoryLabelFormat(valueText, serialDataItem, categoryAxis) {
    return roundAny(valueText,0);
}

function priceBalloonFormat(item,graph) {
    return graph.title + "<br /><b style='font-size: 130%'>" + roundAny(item.values.value,4) + "</b>";
}

function priceLegendFormat(item, valueText) {
    return roundAny(valueText, 4);
}

function balanceBalloonFormat(item,graph) {
    return "<span style='font-size:9px;'>" + graph.title + " " + roundAny(item.values.value,0) + "MW</span>"
}

function balanceLegendFormat(item, valueText) {
    return valueText;
    // return roundAny(valueText, 0) + 'MW';
}

var amount_of_ds_data_list = Object.keys(ds_data_list).length;
var amount_of_price_data_list = Object.keys(price_data_list).length;

var chartDataDS = [];
var chartDataPrice = [];

for (var i = 0; i < amount_of_ds_data_list; i++) {
    var format_date = new Date(ds_data_list[i]['fc_datetime']);
    chartDataDS[i] = ({
        date: format_date,
        d_min: ds_data_list[i]['d_min'],
        d_max: ds_data_list[i]['d_max'],
        d_mean: ds_data_list[i]['d_mean'],
        s_nuclear: ds_data_list[i]['s_nuclear'],
        s_coal_usc: ds_data_list[i]['s_coal_usc'],
        s_coal_sc: ds_data_list[i]['s_coal_sc'],
        s_coal_misc: ds_data_list[i]['s_coal_misc'],
        s_lng_macc2: ds_data_list[i]['s_lng_macc2'],
        s_lng_macc: ds_data_list[i]['s_lng_macc'],
        s_lng_acc: ds_data_list[i]['s_lng_acc'],
        s_lng_cc: ds_data_list[i]['s_lng_cc'],
        s_lng_misc: ds_data_list[i]['s_lng_misc'],
        s_oil: ds_data_list[i]['s_oil'],
    });
}

for (var i = 0; i < amount_of_price_data_list; i++) {
    chartDataPrice[i] = ({
        price: price_data_list[i]['price'],
        w1_24h: price_data_list[i]['w1_24h'],
        w1_0818: price_data_list[i]['w1_0818'],
        w1_0820: price_data_list[i]['w1_0820'],
        w1_0822: price_data_list[i]['w1_0822'],
        w2_24h: price_data_list[i]['w2_24h'],
        w2_0818: price_data_list[i]['w2_0818'],
        w2_0820: price_data_list[i]['w2_0820'],
        w2_0822: price_data_list[i]['w2_0822'],
        w3_24h: price_data_list[i]['w3_24h'],
        w3_0818: price_data_list[i]['w3_0818'],
        w3_0820: price_data_list[i]['w3_0820'],
        w3_0822: price_data_list[i]['w3_0822'],
    });
}

var chart2 = AmCharts.makeChart("chartdiv_price", {
    "type": "serial",
    "theme": "none",
    "legend": {
        "position": "top",
        "equalWidths": true,
        "useGraphSettings": true,
        "valueAlign": "left",
        "valueWidth": 120,
        valueFunction: priceLegendFormat,
    },
    "valueAxes": [
        {
            "id": "v1",
            "title": dict["確率密度"],
            "position": "left",
            labelFunction: priceValueLabelFormat,
        },
    ],
    graphs: [
        {
            "id": "w1_24h",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "navy",
            "title": week_dates[0]+"~"+week_dates[1]+" " + dict["24時間平均"], 
            // "useLineColorForBulletBorder": true,
            "valueField": "w1_24h",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w1_24h_percents]]%</b>",
            // "legendValueText": "[[w1_24h_percents]]",
        }, 
        {
            "id": "w1_0818",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "dodgerblue",
            "title": week_dates[0]+"~"+week_dates[1]+" "+dict["平日8-18時平均"],
            // "useLineColorForBulletBorder": true,
            "valueField": "w1_0818",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w1_0818_percents]]%</b>",
            // "legendValueText": "[[w1_0818_percents]]",
        },
        {
            "id": "w2_24h",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "darkgreen",
            "title": week_dates[2]+"~"+week_dates[3]+" " + dict["24時間平均"], 
            // "useLineColorForBulletBorder": true,
            "valueField": "w2_24h",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w2_24h_percents]]%</b>",
            // "legendValueText": "[[w2_24h_percents]]",
        }, 
        {
            "id": "w2_0818",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "mediumseagreen",
            "title": week_dates[2]+"~"+week_dates[3]+" "+dict["平日8-18時平均"],
            // "useLineColorForBulletBorder": true,
            "valueField": "w2_0818",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w2_0818_percents]]%</b>",
            // "legendValueText": "[[w2_0818_percents]]",
        }, 
        {
            "id": "w3_24h",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "darkorange",
            "title": week_dates[4]+"~"+week_dates[5]+" " + dict["24時間平均"], 
            // "useLineColorForBulletBorder": true,
            "valueField": "w3_24h",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w3_24h_percents]]%</b>",
            // "legendValueText": "[[w3_24h_percents]]",
        }, 
        {
            "id": "w3_0818",
            "valueAxis": "v1",
            "bullet": "round",
            // "bulletBorderAlpha": 1,
            // "bulletColor": "#20acd4",
            "bulletSize": 10,
            "hideBulletsCount": 50,
            "lineThickness": 2,
            "lineColor": "gold",
            "title": week_dates[4]+"~"+week_dates[5]+" "+dict["平日8-18時平均"],
            // "useLineColorForBulletBorder": true,
            "valueField": "w3_0818",
            balloonFunction: priceBalloonFormat,
            // "balloonText": "[[title]]<br /><b style='font-size: 130%'>[[w3_0818_percents]]%</b>",
            // "legendValueText": "[[w3_0818_percents]]",
        }, 
    ],

    "chartCursor": {
        "pan": true,
        "valueLineEnabled": true,
        "valueLineBalloonEnabled": true,
        "cursorAlpha": 0,
        "valueLineAlpha": 0.2
      },
   
    "dataProvider": chartDataPrice,
    "categoryField": "price",
    
    "categoryAxis": {
        // "parseDates": true,
        // "dashLength": 1,
        // "minorGridEnabled": true
        "title": dict["価格（円/kWh）"],
        "autoGridCount": false,
        "gridCount": price_high - price_low,
        labelFunction: priceCategoryLabelFormat,
    },
    
    "balloon": {
        "borderThickness": 1,
        "shadowAlpha": 0
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
                // "fileName": "DemandSupplyPrice_" + export_date + filename_area
                "fileName": "OneMonthForecast_" + export_date + filename_area
            }]
    },
});

var chart = AmCharts.makeChart("chartdiv_ds", {
    type: "stock",
    theme: "none",
    dataDateFormat: "YYYY-MM-DD JJ:NN",
    
    categoryAxesSettings: {
        minPeriod: "mm",
        maxSeries: 1500  // 2016/03/11
    },
    valueAxesSettings: {
        inside: false,
        // showLastLabel: true
    },
    
    dataSets: [{
        fieldMappings: [
            {
                fromField: "s_nuclear",
                toField: "s_nuclear"
            },
            {
                fromField: "s_coal_usc",
                toField: "s_coal_usc"
            },
            {
                fromField: "s_coal_sc",
                toField: "s_coal_sc"
            },
            {
                fromField: "s_coal_misc",
                toField: "s_coal_misc"
            },
            {
                fromField: "s_lng_macc2",
                toField: "s_lng_macc2"
            },
            {
                fromField: "s_lng_macc",
                toField: "s_lng_macc"
            },
            {
                fromField: "s_lng_acc",
                toField: "s_lng_acc"
            },
            {
                fromField: "s_lng_cc",
                toField: "s_lng_cc"
            },
            {
                fromField: "s_lng_misc",
                toField: "s_lng_misc"
            },
            {
                fromField: "s_oil",
                toField: "s_oil"
            },
            {
                fromField: "d_min",
                toField: "d_min"
            },
            {
                fromField: "d_max",
                toField: "d_max"
            },
            {
                fromField: "d_mean",
                toField: "d_mean"
            },
        ],
        dataProvider: chartDataDS,
        categoryField: "date"
    }],

    panels: [{
        precision: 2,
        title: dict["需要・供給(MW)"],
        showCategoryAxis: true,
        percentHeight: 70,
        // percentHeight: 100,
        
        "valueAxes": [
            {
                "id": "v1",
                // "title": "供給",
                // "gridAlpha": 0,
                minimum: 0,
                maximum: ds_max,
                "position": "left",
                "stackType": "regular",
            },
            {
                "id": "v2",
                // "title": "需要",
                "gridAlpha": 0,
                minimum: 0,
                maximum: ds_max,
                "position": "right",
                "autoGridCount": false,
                labelsEnabled: false,
            },
        ],
        
        stockGraphs: [            
            {
                id: "s1",
                valueAxis: "v1",
                title: dict["原子力"],
                valueField: "s_nuclear",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#e6b8b7",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["原子力"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#e6b8b7",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s2",
                valueAxis: "v1",
                title: dict["石炭_USC"],
                valueField: "s_coal_usc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#60497a",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["石炭_USC"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s3",
                valueAxis: "v1",
                title: dict["石炭_SC"],
                valueField: "s_coal_sc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#b1a0c7",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["石炭_SC"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s4",
                valueAxis: "v1",
                title: dict["石炭_その他"],
                valueField: "s_coal_misc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#ccc0da",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["石炭_その他"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s5",
                valueAxis: "v1",
                title: "LNG_MACCⅡ",
                valueField: "s_lng_macc2",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#16365c",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>LNG_MACCⅡ [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s6",
                valueAxis: "v1",
                title: "LNG_MACC",
                valueField: "s_lng_macc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#366092",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>LNG_MACC [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s7",
                valueAxis: "v1",
                title: "LNG_ACC",
                valueField: "s_lng_acc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#538dd5",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>LNG_ACC [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s8",
                valueAxis: "v1",
                title: "LNG_CC",
                valueField: "s_lng_cc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#8db4e2",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>LNG_CC [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s9",
                valueAxis: "v1",
                title: dict["LNG_その他"],
                valueField: "s_lng_misc",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#c5d9f1",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["LNG_その他"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            {
                id: "s10",
                valueAxis: "v1",
                title: dict["石油"],
                valueField: "s_oil",
                useDataSetColors: false,
                fillAlphas: 0.8,
                lineColor: "#808080",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["石油"]+" [[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 1,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            }, 
            
            {
                id: "d1",
                valueAxis: "v2",
                title: dict["残余需要（最大）"],
                valueField: "d_max",
                useDataSetColors: false,
                lineColor: "#c00000",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["残余需要（最大）"]+"[[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 5,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            },
            {
                id: "d2",
                valueAxis: "v2",
                title: dict["残余需要（最小）"],
                valueField: "d_min",
                useDataSetColors: false,
                lineColor: "#0000c0",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["残余需要（最小）"]+"[[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 5,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            },
            {
                id: "d3",
                valueAxis: "v2",
                title: dict["残余需要（平均）"],
                valueField: "d_mean",
                useDataSetColors: false,
                lineColor: "#00c000",
                // balloonFunction: balanceBalloonFormat,
                balloonText: "<span style='font-size:9px;'>"+dict["残余需要（平均）"]+"[[value]]MW</span>",
                bullet: "round",
                bulletBorderAlpha: 1,
                // bulletColor: "#FFFFFF",
                bulletSize: 5,
                hideBulletsCount: 5,
                lineThickness: 2,
                useLineColorForBulletBorder: true,
                periodValue: "Average"
            },
        ],
        // 上のグラフのタイトル
        stockLegend: {
            // periodValueTextComparing: "[[percents.value.close]]%",
            periodValueTextRegular: "[[value.close]]",
            // valueFunction: balanceLegendFormat,
        }
    } ],
    
    panelsSettings: {
        "plotAreaFillAlphas": 1,
        "marginLeft": 80,
        "marginTop": 5,
        "marginBottom": 5,
        precision: 0,
    },
    
    // 下のカーソル
    chartScrollbarSettings: {
        graph: "d1"
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
            // format: "YYYY-MM-DD"
            format: "MM/DD"
        },
        {
            period: "DD",
            // format: "YYYY-MM-DD"
            format: "MM/DD"
        },
        {
            period: "mm",
            // format: "YYYY-MM-DD JJ:NN"
            format: "MM/DD JJ:NN"
        },
        {
            period: "ss",
            // format: "YYYY-MM-DD JJ:NN"
            format: "MM/DD JJ:NN"
        },
        {
            period: "fff",
            // format: "YYYY-MM-DD JJ:NN"
            format: "MM/DD JJ:NN"
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
        {
            period: "WW",
            count: 1,
            label: "1 week"
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
});
