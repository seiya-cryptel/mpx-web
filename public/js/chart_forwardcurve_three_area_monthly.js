// 小数点第2以下切り捨て
function format_value(value) {
    var formatted_value = Math.round(value * 100) / 100;
    formatted_value = String(formatted_value);
    return formatted_value;
}
var chartData = [];

var amount_of_monthly_data_list = Object.keys(monthly_data_list).length;

// カウンタ変数
var j = 0;
for (var i in monthly_data_list) {
    var format_date = new Date(monthly_data_list[i]['fc_datetime']);
    chartData[j] = ({
        date: format_date,
        monthly_base: format_value(monthly_data_list[i]['price_base']),
        monthly_peak: format_value(monthly_data_list[i]['price_offpeak']),
        monthly_daytime: format_value(monthly_data_list[i]['price_peak']),
        east_monthly_base: format_value(monthly_data_list[i]['east_price_base']),
        east_monthly_peak: format_value(monthly_data_list[i]['east_price_offpeak']),
        east_monthly_daytime: format_value(monthly_data_list[i]['east_price_peak']),
        west_monthly_base: format_value(monthly_data_list[i]['west_price_base']),
        west_monthly_peak: format_value(monthly_data_list[i]['west_price_offpeak']),
        west_monthly_daytime: format_value(monthly_data_list[i]['west_price_peak']),
    });
    j++;
}

var chart = AmCharts.makeChart("monthly_chart", {
    type: "stock",
    theme: "light",
    dataDateFormat: "YYYY-MM",
    categoryAxesSettings: {
        minPeriod: "MM"
    },
    dataSets: [{
            fieldMappings: [
                {
                    fromField: "monthly_base",
                    toField: "monthly_base"
                },
                {
                    fromField: "monthly_peak",
                    toField: "monthly_peak"
                },
                {
                    fromField: "monthly_daytime",
                    toField: "monthly_daytime"
                },
                {
                    fromField: "east_monthly_base",
                    toField: "east_monthly_base"
                },
                {
                    fromField: "east_monthly_peak",
                    toField: "east_monthly_peak"
                },
                {
                    fromField: "east_monthly_daytime",
                    toField: "east_monthly_daytime"
                },
                {
                    fromField: "west_monthly_base",
                    toField: "west_monthly_base"
                },
                {
                    fromField: "west_monthly_peak",
                    toField: "west_monthly_peak"
                },
                {
                    fromField: "west_monthly_daytime",
                    toField: "west_monthly_daytime"
                },
            ],
            dataProvider: chartData,
            categoryField: "date"
        }
    ],
    panels: [{
            title: "Forward_Price (円/kWh)",
            showCategoryAxis: true,
            percentHeight: 70,
            stockGraphs: [
                // price_base
                {
                    id: "g1",
                    title: "システムプライス・ベースロード",
                    valueField: "monthly_base",
                    useDataSetColors: false,
                    // lineColor: "blue",
                    lineColor: "#00479d",
                    balloonText: "<span style='font-size:12px;'>システムプライス・ベースロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    periodValue: "Average"
                },
                // price_offpeak
                {
                    id: "g2",
                    title: "システムプライス・ピークロード",
                    valueField: "monthly_peak",
                    useDataSetColors: false,
                    // lineColor: "orange",
                    lineColor: "#1d66eb",
                    balloonText: "<span style='font-size:12px;'>システムプライス・ピークロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // price_peak
                {
                    id: "g3",
                    title: "システムプライス・日中ロード",
                    valueField: "monthly_daytime",
                    useDataSetColors: false,
                    // lineColor: "gray",
                    lineColor: "#00a0e9",
                    balloonText: "<span style='font-size:12px;'>システムプライス・日中ロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // east_price_base
                {
                    id: "g4",
                    title: "東エリア・ベースロード",
                    valueField: "east_monthly_base",
                    useDataSetColors: false,
                    // lineColor: "dodgerblue",
                    lineColor: "#22ac38",
                    balloonText: "<span style='font-size:12px;'>東エリア・ベースロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    // hidden: true,
                    periodValue: "Average"
                },
                // east_price_offpeak
                {
                    id: "g5",
                    title: "東エリア・ピークロード",
                    valueField: "east_monthly_peak",
                    useDataSetColors: false,
                    lineColor: "#31a354",
                    balloonText: "<span style='font-size:12px;'>東エリア・ピークロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // east_price_peak
                {
                    id: "g6",
                    title: "東エリア・日中ロード",
                    valueField: "east_monthly_daytime",
                    useDataSetColors: false,
                    // lineColor: "black",
                    lineColor: "#b3d465",
                    balloonText: "<span style='font-size:12px;'>東エリア・日中ロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // west_price_base
                {
                    id: "g7",
                    title: "西エリア・ベースロード",
                    valueField: "west_monthly_base",
                    useDataSetColors: false,
                    // lineColor: "cornflowerblue",
                    lineColor: "#a4005b",
                    balloonText: "<span style='font-size:12px;'>西エリア・ベースロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    // hidden: true,
                    periodValue: "Average"
                },
                // west_price_offpeak
                {
                    id: "g8",
                    title: "西エリア・ピークロード",
                    valueField: "west_monthly_peak",
                    useDataSetColors: false,
                    // lineColor: "gold",
                    lineColor: "#df65b0",
                    balloonText: "<span style='font-size:12px;'>西エリア・ピークロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
                // west_price_peak
                {
                    id: "g9",
                    title: "西エリア・日中ロード",
                    valueField: "west_monthly_daytime",
                    useDataSetColors: false,
                    // lineColor: "lightgrey",
                    lineColor: "#d7b5d8",
                    balloonText: "<span style='font-size:12px;'>西エリア・日中ロード [[value]]</div>",
                    bullet: "round",
                    bulletBorderAlpha: 1,
                    bulletColor: "#FFFFFF",
                    bulletSize: 5,
                    hideBulletsCount: 50,
                    lineThickness: 2,
                    useLineColorForBulletBorder: true,
                    hidden: true,
                    periodValue: "Average"
                },
            ],
            // 上のグラフのタイトル
            stockLegend: {
                periodValueTextComparing: "[[percents.value.close]]%",
                periodValueTextRegular: "[[value.close]]"
            }
        }
    ],
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
                        format: "YYYY-MM-DD"
                    },
                    {
                        period: "ss",
                        format: "YYYY-MM-DD"
                    },
                    {
                        period: "fff",
                        format: "YYYY-MM-DD"
                    }
                ],
        valueLineEnabled: true,
        valueLineAlpha: 0.5
    },
    periodSelector: {
        dateFormat: "YYYY-MM",
        position: "top",
        toText: "To:",
        selectFromStart: true,
        periods: [
            {
                selected: true,
                period: "YYYY",
                count: 1,
                label: "1 year"
            },
            {
                period: "MAX",
                label: "MAX"
            }]
    },
    "export": {
        "enabled": true, // TODO CSV の　ダウンロード
        "libs": {
            "path":
                    "/js/ac/plugins/export/libs/"
        },
        "menu": [{
                "format": "CSV",
                "label": "ダウンロード",
                "title": "Export chart to CSV",
                "fileName": "ForwardCurve_Monthly_" + export_date + filename_area
            }]
    }
});
