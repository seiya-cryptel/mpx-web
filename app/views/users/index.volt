<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <!--<link rel="icon" href="../../favicon.ico">-->

        <title>MPX</title>
        
        <!-- jQuery -->
        {# javascript_include('js/jquery.min.js') 2019/02/13 #}
        {{ javascript_include('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}

        <!-- Bootstrap core CSS -->
        {{ stylesheet_link('css/bootstrap.min.css') }}
        <!-- Bootstrap datatables CSS -->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.0.1/css/responsive.bootstrap.min.css">
        <style type="text/css">
            .edit_user{
                color: white;
                background-color: #5192ED;
                padding: 4px 20px;
                display: inline-block;
                border-radius: 7px;
            } 
            
        </style>
        
        <!-- Bootstrap datatables JS -->
        <script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.10/js/dataTables.bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.0.1/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.0.1/js/responsive.bootstrap.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "searching": false,
                "lengthChange": false
            });
        } );
        </script>

        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        {{ stylesheet_link('css/ie10-viewport-bug-workaround.css') }}

        
        <!-- Custom styles for this template -->
        {{ stylesheet_link('css/top.css') }}<!-- ????????? -->
        {{ stylesheet_link('css/terms_of_use.css') }}<!-- ???????????? -->

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        {{ javascript_include('js/ie-emulation-modes-warning.js') }}
        
        {{ assets.outputCss() }}

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

        <!-- ??????????????? -->
        
        {{ javascript_include('js/jquery-ui.js') }}
        {{ javascript_include('js/jquery.ui.datepicker-ja.js') }}
        <script>
        // ????????????????????????
        // 1???????????????0?????????2????????????
        var toDoubleDigits = function(num) {
                num += "";
            if (num.length === 1) {
                num = "0" + num;
            }
            return num;     
        }
        
        {% if calender_date_list is defined %}
        {% set calender_date_list = calender_date_list | json_encode %}
        var calender_date_list = {{ calender_date_list }}; 
        // var half_hourly_upload_date_2 = {{ half_hourly_upload_date_2 }};
        $(function() {
            // var hoge_list = half_hourly_upload_date_2;
            var hoge_list = calender_date_list;
            
            $('#date').datepicker({
                beforeShowDay:function(date){
                    for (var i = 0; i < hoge_list.length; i++) {
                        var year  = date.getFullYear();
                        var month = toDoubleDigits(date.getMonth() + 1);
                        var day   = toDoubleDigits(date.getDate());
                        var date_calender = year + "-" + month + "-" + day;
                        if(hoge_list.indexOf(date_calender) >= 0){
                            return [true,'true'];
                        } else {
                            return [false,'true'];
                        }
                    }
                }
            }),
            $("#date").datepicker("setDate", "<?php echo $_POST['day']; ?>");
        });
        {% endif %}
        
        {% if calender_date_list2 is defined %}
        {% set calender_date_list = calender_date_list2 | json_encode %}
        {% set spot_upload_date_2 = spot_upload_date_2 | json_encode %}
        var calender_date_list = {{ calender_date_list }};

        var half_hourly_upload_date_2 = {{ spot_upload_date_2 }};
        $(function() {
            var hoge_list = half_hourly_upload_date_2;
            
            $('#date').datepicker({
                beforeShowDay:function(date){
                    for (var i = 0; i < hoge_list.length; i++) {
                        var year  = date.getFullYear();
                        var month = toDoubleDigits(date.getMonth() + 1);
                        var day   = toDoubleDigits(date.getDate());
                        var date_calender = year + "-" + month + "-" + day;
                        if(hoge_list.indexOf(date_calender) >= 0){
                            return [true,'true'];
                        } else {
                            return [false,'true'];
                        }
                    }
                }
            }),
            $("#date").datepicker("setDate", "<?php echo $_POST['day']; ?>");
        });
        {% endif %}
        
        
        {% if subs_calender_date_list is defined %}
        // ???????????????????????????????????????
        $(function() {
            {% set calender_date_list = subs_calender_date_list | json_encode %}
            var calender_date_list = {{ calender_date_list }};
            console.log("hihifafa");
            console.log(calender_date_list);
            $('#subs_date').datepicker({
                beforeShowDay:function(date){
                    for (var i = 0; i < calender_date_list.length; i++) {
                        var year  = date.getFullYear();
                        var month = toDoubleDigits(date.getMonth() + 1);
                        var day   = toDoubleDigits(date.getDate());
                        var date_calender = year + "-" + month + "-" + day;
                        if(calender_date_list.indexOf(date_calender) >= 0){
                            return [true,'true'];
                        } else {
                            return [false,'true'];
                        }
                    }
                }
            }),
            $("#subs_date").datepicker("setDate", "<?php echo $_POST['day']; ?>");
        });
        {% endif %}
        
        
        
        
        
        {% if oil_lng_coal_calender_date_list is defined %}
        // ???????????????????????????????????????
        $(function() {
            {% set oil_lng_coal_exist_upload_date = oil_lng_coal_exist_upload_date | json_encode %}
            var oil_lng_coal_exist_upload_date = {{ oil_lng_coal_exist_upload_date }};
            console.log('fa');
            console.log(oil_lng_coal_exist_upload_date);
            
            {% set oil_lng_coal_calender_date_list = oil_lng_coal_calender_date_list | json_encode %}
            var oil_lng_coal_calender_date_list = {{ oil_lng_coal_calender_date_list }};
            $('#oil_lng_coal_date').datepicker({
                beforeShowDay:function(date){
                    for (var i = 0; i < oil_lng_coal_calender_date_list.length; i++) {
                        var year  = date.getFullYear();
                        var month = toDoubleDigits(date.getMonth() + 1);
                        var day   = toDoubleDigits(date.getDate());
                        var date_calender = year + "-" + month + "-" + day;
                        if(oil_lng_coal_exist_upload_date.indexOf(date_calender) >= 0){
                            return [true,'true'];
                        } else {
                            return [false,'true'];
                        }
                    }
                }
            }),
            $("#oil_lng_coal_date").datepicker("setDate", "<?php echo $_POST['selected_date_oil_lng_coal']; ?>");
        });
        {% endif %}
        
        
        </script>
        
        {{ stylesheet_link('css/jquery-ui-1.10.0.custom.min.css') }}
        <style>
            #ui-datepicker-div{
                background: white;
            }
        </style>
                
        <!-- flex slider -->
        {{ stylesheet_link('css/flexslider.css') }}
        {{ javascript_include('js/jquery.flexslider-min.js') }}
        {{ javascript_include('js/flexslider-option.js') }}

        {{ stylesheet_link('css/login.css') }}
        {{ stylesheet_link('css/footer.css') }}
        
        {{ stylesheet_link('css/background.css') }}
        {{ stylesheet_link('css/aboutforwardcurve.css') }}
        {{ stylesheet_link('css/methodology.css') }}
        {{ stylesheet_link('css/service.css') }}
        
        <script type="text/javascript">
            // ???????????????????????????
            {% if spot_data_list is defined %}
                {% set spot_data_list = spot_data_list | json_encode %}
            {% endif %}
            {% if spot_all_data_list is defined %}
                {% set spot_all_data_list = spot_all_data_list | json_encode %}
            {% endif %}
            {% if index_data_list is defined %}
                {% set index_data_list = index_data_list | json_encode %}
            {% endif %}
            {% if subs_data_list is defined %}
                {% set subs_data_list = subs_data_list | json_encode %}
            {% endif %}
            
            {% if coal_data_list is defined %}
                {% set coal_data_list = coal_data_list | json_encode %}
            {% endif %}
            {% if oil_data_list is defined %}
                {% set oil_data_list = oil_data_list | json_encode %}
            {% endif %}
            {% if exchange_data_list is defined %}
                {% set exchange_data_list = exchange_data_list | json_encode %}
            {% endif %}
            
            // ??????(??????,??????,?????????)
            {% if demand_forecast_data_list is defined %}
                {% set demand_forecast_data_list = demand_forecast_data_list | json_encode %}
            {% endif %}

            // ??????????????????(??????????????????, LNG????????????, ??????????????????)
            {% if sub_oil_data_list is defined %}
                {% set sub_oil_data_list = sub_oil_data_list | json_encode %}
            {% endif %}
            {% if sub_lng_data_list is defined %}
                {% set sub_lng_data_list = sub_lng_data_list | json_encode %}
            {% endif %}
            {% if sub_coal_data_list is defined %}
                {% set sub_coal_data_list = sub_coal_data_list | json_encode %}
            {% endif %}



            // ???????????????????????????
            {% if half_hourly_data_list is defined %}
            var half_hourly_data_list = {{ half_hourly_data_list }};
            {% endif %}
            {% if daily_data_list is defined %}
            var daily_data_list = {{ daily_data_list }};
            {% endif %}
            {% if monthly_data_list is defined %}
            var monthly_data_list = {{ monthly_data_list }}
            {% endif %}
            
            // ???????????????????????????
            {% if spot_data_list is defined %}
            var spot_data_list = {{ spot_data_list }};
            {% endif %}
            {% if spot_all_data_list is defined %}
            var spot_all_data_list = {{ spot_all_data_list }};
            {% endif %}            
            {% if index_data_list is defined %}
            var index_data_list = {{ index_data_list }};
            {% endif %}
            
            {% if subs_data_list is defined %}
            var subs_data_list = {{ subs_data_list }};
            {% endif %}
            {% if coal_data_list is defined %}
            var coal_data_list = {{ coal_data_list }};
            {% endif %}
            {% if oil_data_list is defined %}
            var oil_data_list = {{ oil_data_list }};
            {% endif %}
            {% if exchange_data_list is defined %}
            var exchange_data_list = {{ exchange_data_list }};
            {% endif %}

            
            // ??????(??????,??????,?????????)
            {% if demand_forecast_data_list is defined %}
            var demand_forecast_data_list = {{ demand_forecast_data_list }};
            {% endif %}
            
            // ??????????????????(??????????????????, LNG????????????, ??????????????????)
            {% if sub_oil_data_list is defined %}
            var sub_oil_data_list = {{ sub_oil_data_list }};
            {% endif %}
            {% if sub_lng_data_list is defined %}
            var sub_lng_data_list = {{ sub_lng_data_list }};
            {% endif %}
            {% if sub_coal_data_list is defined %}
            var sub_coal_data_list = {{ sub_coal_data_list }};
            {% endif %}

        </script>

        <!-- amchart????????????js-->
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
        <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
        <!-- csv???????????????????????????js -->
        {{ javascript_include('js/ac/plugins/export/export.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/pdfmake/pdfmake.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/jszip/jszip.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/fabric.js/fabric.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/FileSaver.js/FileSaver.js') }}


        <!-- JavaScript -->

        <!-- ????????????????????????(Harl hourly,Daily,Monthly) -->
        {% if half_hourly_data_list is defined %}
            {{ javascript_include('js/chart_half_hourly.js') }}
        {% endif %}
        {% if daily_data_list is defined %}
            {{ javascript_include('js/chart_daily.js') }}
        {% endif %}
        {% if monthly_data_list is defined %}
            {{ javascript_include('js/chart_monthly.js') }}
        {% endif %}

        <!-- ???????????????????????????(????????????,?????????????????????,JEPX??????????????????,????????????,????????????,??????) -->
        {% if spot_data_list is defined %}
            {{ javascript_include('js/chart_spot.js') }}<!-- ???????????? -->
        {% endif %}
        {% if spot_all_data_list is defined %}
            {{ javascript_include('js/chart_spot_all.js') }}<!-- ????????? -->
        {% endif %}
        {% if index_data_list is defined %}
            {{ javascript_include('js/chart_index.js') }}<!-- JEPX?????????????????? -->
        {% endif %}
        {% if oil_data_list is defined %}
            {{ javascript_include('js/chart_hst_oil.js') }}<!-- ???????????? -->
        {% endif %}
        {% if coal_data_list is defined %}
            {{ javascript_include('js/chart_hst_coal.js') }}<!-- ???????????? -->
        {% endif %}
        {% if exchange_data_list is defined %}
            {{ javascript_include('js/chart_hst_exchange.js') }}<!-- ?????? -->
        {% endif %}
       
        <!-- ??????(??????,??????,?????????) -->
        {% if demand_forecast_data_list is defined %}
            {{ javascript_include('js/chart_demand_forecast.js') }}<!-- ?????? -->
            {{ javascript_include('js/chart_solar.js') }}<!-- ????????? -->
            {{ javascript_include('js/chart_wind.js') }}<!-- ?????? -->
        {% endif %}
        
        <!-- ??????????????????(??????????????????, LNG????????????, ??????????????????) -->
        {% if sub_oil_data_list is defined %}
            {{ javascript_include('js/chart_sub_oil.js') }}<!-- ?????? -->
        {% endif %}
        {% if sub_lng_data_list is defined %}
            {{ javascript_include('js/chart_sub_lng.js') }}<!-- ?????? -->
        {% endif %}
        {% if sub_coal_data_list is defined %}
            {{ javascript_include('js/chart_sub_coal.js') }}<!-- ?????? -->
        {% endif %}

        
        
        

        <!-- CSS -->
        
        <!-- ????????????????????????(Harl hourly,Daily,Monthly) -->
        {% if half_hourly_data_list is defined %}
            {{ stylesheet_link('css/chart_half_hourly.css') }}
            {{ stylesheet_link('css/chart_daily.css') }}
            {{ stylesheet_link('css/chart_monthly.css') }}
        {% endif %}
        
        <!-- ???????????????????????????(????????????,????????????????????????) -->
        {% if spot_data_list is defined %}
            {{ stylesheet_link('css/chart_spot.css') }}
            {{ stylesheet_link('css/chart_index.css') }}
            {{ stylesheet_link('css/chart_hst_cme.css') }}
        {% endif %}
        
        <!-- ????????????(??????,??????,?????????) -->
        {% if demand_forecast_data_list is defined %}
            {{ stylesheet_link('css/chart_demand_forecast.css') }}
            {{ stylesheet_link('css/chart_solar.css') }}
            {{ stylesheet_link('css/chart_wind.css') }}
        {% endif %}
        
        <!-- ??????????????????(??????????????????, LNG????????????, ??????????????????) -->
        {% if sub_oil_data_list is defined %}
            {{ stylesheet_link('css/chart_sub_oil.css') }}
        {% endif %}
        {% if sub_lng_data_list is defined %}
            {{ stylesheet_link('css/chart_sub_lng.css') }}
        {% endif %}
        {% if sub_coal_data_list is defined %}
            {{ stylesheet_link('css/chart_sub_coal.css') }}
        {% endif %}


        <style type="text/css">
            
            a.source {
                display: inline-block;
            }
            #left_content {
                padding:0 1%;
                padding-top:30px;
                margin-bottom:200px;
                min-width: 400px;
                width:100%;
                min-height:600px;
            }

        </style>
        <style type="text/css">
            li {
                list-style: none;
            }
            strong {
                display: block;
            }
            a {
                display: block;
            }
            img {
                display: block;
            }
            .logic_img {
                width: 90%;
                max-width: 800px;
                margin-bottom: 50px;
            }
            #navbar a {
                color: black;
            }
            #navbar a:hover {
                border-bottom: dotted 1px #004a92!important;
                color: #004a92;
            }
            #navbar li.active a{
                color: #999999;;
                background:white;
            }

        </style>

        <style>
            img.about_forwardcurve_img{
                width: 100%;
                max-width:900px;
                margin: 0 auto;
            }
        </style>
    </head>
    <body class="top_body">
        <nav class="navbar navbar-default navbar-fixed-top" style="background:white;border: none;">
            
            <div style="width:100%;hight:30px;padding:10px;">
                {% set my_image = image('img/header_logo.png') %}
                <a href="https://mpx.co.jp/" target="_blank">{{ my_image }}</a>
            </div>
            <div class="container">
                
                <div class="navbar-header">
                    <!--
                      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                      </button>
                      
                      {% set my_image = image('img/logo.png', 'class':'navbar-brand', 'alt':"MRI") %}
                        {{ link_to('', my_image) }}
                    -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        {{ link_to('/', 'MPX', 'class': 'navbar-brand', 'style': 'color:steelblue;font-weight:bold;') }}
                    </div>

                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">

                        {% if role > 0 %}
                            <li class="{{ active_forwardcurve }}">{{ link_to('forwardcurve', '????????????????????????') }}</li>
                            {% if role > 1 %}
                                <li class="{{ active_historicaldata }}">{{ link_to('prerequisite', '????????????') }}</li>
                            {% endif %}
                            <li class="{{ active_computationallogic }}">{{ link_to('computationallogic', '???????????????') }}</li>
                            <li>{{ link_to('inquiry', '???????????????') }}</li>
                        {% else %}
                            <li class="active">{{ link_to('sample', '????????????') }}</li>
                            <li class="active">{{ link_to('termsofuse', '????????????') }}</li>
                        {% endif %}

                        {% if role > 0 %}
                            {% if role == 9 %}
                                <li class="{{ active_appload }}" class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">??????????????????<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>{{ link_to('upload/forwardPower',   '?????????????????????') }}</li>
                                        <li>{{ link_to('upload/forwardFuel',    '????????????????????????') }}{# 2019/02/08 #}</li>
                                        <li>{{ link_to('upload/forwardFuelCif',    '??????CIF????????????') }}{# 2019/02/08 #}</li>
                                        <li>{{ link_to('upload/jepx',           'JEPX') }}</li>
                                        <li>{{ link_to('upload/cme',            'CME') }}</li>
                                        <li>{{ link_to('upload/prerequisite',   '??????????????????') }}</li>
                                    </ul>
                                </li>
                            {% endif %}
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ email }}<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li>{{ link_to('users/profile',     '??????????????????') }}</li>
                                    <li>{{ link_to('users/setpwd',      '?????????????????????') }}</li>
                                    <li>{{ link_to('session/logout',    '???????????????') }}</li>
                                </ul>
                            </li>
                        {% else %}
                            <li class="active">{{ link_to('login', '????????????') }}</li>
                        {% endif %}

                    </ul>
                </div>
            </div>
        </nav>
        <div style="padding-top:46px;">
        {{ content() }}
        </div>
        
        <!-- ??????footer -->
        <footer style="">
            <div style="position: relative;height: 20px;padding: 10px 0;">
                <p style="position: absolute;left: 10px;height: 20px;font-size:13px;">Copyright (c) 2016 <a href="http://www.mri.co.jp" target="_blank" style="font-size:13px;">????????????MPX</a></p>
                <p style="position: absolute;right: 10px;"><a href="https://mpx.co.jp/privacy_policy/" target="_blank" style="font-size:13px;">???????????????????????????????????????</a></p>
            </div>
        </footer>
        <!-- ??????footer -->

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->

        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        {{ javascript_include('js/bootstrap.min.js') }}
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        {{ javascript_include('js/ie10-viewport-bug-workaround.js') }}
        
        {{ assets.outputJs() }}
        
    </body>
</html>
