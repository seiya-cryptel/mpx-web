{# views/index.volt #}
<!DOCTYPE html>
{# ログイン後のメイン ビュー #}
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>MPX</title>
       
        <!-- CSS -->
        <!-- ie10-viewport-bug-workaround CSS -->
        {{ stylesheet_link('css/ie10-viewport-bug-workaround.css') }}
        
        <!-- Bootstrap core CSS -->
        {{ stylesheet_link('css/bootstrap.min.css') }}
                
        {{ stylesheet_link('css/jquery-ui-1.10.0.custom.min.css') }}
        <!-- datePicker -->
        {{ stylesheet_link('css/datePicker/style.css') }}

        
        <!-- 共通スタイル -->
        {{ stylesheet_link('css/common.css') }}         
        
        {{ assets.outputCss() }}
        
        {# 2018/10/03 #}
        {# javascript_include('js/jquery.min.js') #}
        {{ javascript_include('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}

        <script type="text/javascript">
            {% if subs_data_list is defined %}
                {% set subs_data_list = subs_data_list | json_encode %}
            {% endif %}
                        
            {% if subs_data_list is defined %}
            var subs_data_list = {{ subs_data_list }};
            {% endif %}
        </script>

        {#
        <!-- amchartに必要なjs 
        <script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
        <script src="https://www.amcharts.com/lib/3/serial.js"></script>
        <script src="https://www.amcharts.com/lib/3/themes/light.js"></script>
        <script src="https://www.amcharts.com/lib/3/amstock.js"></script>
        -->
        #}

        {# 2018/10/03 #}
        {{ javascript_include('js/ac/amcharts.js') }}
        {{ javascript_include('js/ac/serial.js') }}
        {{ javascript_include('js/ac/themes/light.js') }}
        {{ javascript_include('js/ac/amstock.js') }}
        
    </head>
    
    <body class="top_body">
        <div class="container-fluid">
            <header>
                <div id="logo_area">
                    <h1 id="logo_mpx">
                        {{ link_to('/', image('img/logo_mpx_corp.png', 'alt': '株式会社MPX')) }}
                    </h1>
                </div>
                
                <!-- globalnav -->
                <nav class="navbar navbar-default navbar-fixed-top">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        </button>
                    </div>
                
                    <div id="navbar" class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                            {# Admin + User #}
                            {# if role > 0 2018/09/28 #}
                            {% if enable_forwardcurve_menu %}
                                <li {% if active_forwardcurve is defined %}class="{{ active_forwardcurve }}"{% endif %}>
                                    {{ link_to('forwardcurve', 'フォワードカーブ') }}
                                </li>
                            {% endif %}
                            {# 2016/10/07 PlanB 以上 #}
                            {# if role > 2  2018/09/28
                                or email=='seiya@officeu.com'
                                or email=='yuh@sukagawagas.co.jp'
                                or email=='motohisa.miura_a@eneserve.co.jp'
                                or email=='eiko.fujii@toshiba.co.jp' #}
                            {# 2019/10/31
                            {% if enable_jepx_menu %}
                                <li {% if active_jepxfc is defined %}class="{{ active_jepxfc }}"{% endif %}>{{ link_to('jepxfc', 'JEPXスポット価格予測') }}</li>
                            {% endif %}
                            #}
                            {% if enable_jepx_menu or enable_ds_price_menu %}{# 2019/10/31 #}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">JEPXスポット価格予測<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        {% if enable_jepx_menu %}
                                            <li {% if active_jepxfc is defined %}class="{{ active_jepxfc }}"{% endif %}>{{ link_to('jepxfc', 'JEPXスポット価格予測（12日間）') }}</li>
                                        {% endif %}
                                        {% if enable_ds_price_menu %}
                                            <li {% if active_ds_price is defined %}class="{{ active_ds_price }}"{% endif %}>{{ link_to('dsprice', 'JEPXスポット価格予測（1か月）') }}</li>
                                        {% endif %}
                                    </ul>
                                </li>
                            {% endif %}
                            {# PlanB 以上 #}
                            {# if role > 2 2018/09/28 #}
                            {% if enable_prerequisite_menu %}
                                <li {% if active_historicaldata is defined %}class="{{ active_historicaldata }}"{% endif %}>{{ link_to('prerequisite/fuelandexchange', '前提条件／関連情報') }}</li>
                            {% else %}
                                <li {% if active_historicaldata is defined %}class="{{ active_historicaldata }}"{% endif %}>{{ link_to('prerequisite/deliverymonthly', '関連情報') }}</li>
                            {% endif %}
                            {# if role >= 0 2018/09/28 #}
                                <li class="dropdown">
                                    {# if dl_tool #}
                                    {% if enable_tool_menu %}
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">レポート/ツール<span class="caret"></span></a>
                                    {# else 2018/09/28 #}
                                    {% elseif enable_profile_menu %}
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">レポート<span class="caret"></span></a>
                                    {% endif %}
                                    <ul class="dropdown-menu">
                                        {# if role > 0 #}
                                        {% if enable_monthly_report_menu %}
                                            <li>{{ link_to('news/m',   'マンスリーレポート') }}</li>
                                            {# <li>{{ link_to('news/w',   'ウィークリーレビュー') }}</li> 2021/12/29 #}
                                            {# <li>{{ link_to('https://simulation.mpx-web.jp', 'フォワードカーブSIMツール', false) }}</li> 2022/01/06 #}
                                        {% endif %}
                                        {# if role > 2 #}
                                        {% if enable_fc_report_menu %}
                                            <li>{{ link_to('news/fc',  '長期電力フォワードカーブ') }}{# 2017/07/12 #}</li>
                                        {% endif %}
                                        {# if role > 6 #}
                                        {% if enable_gs_report_menu %}
                                            <li>{{ link_to('news/gs',  'ジェネレーション・スタック') }}{# 2017/11/15 #}</li>
                                        {% endif %}
                                        {# if report_va #}
                                        {% if enable_va_report_menu %}
                                            <li>{{ link_to('news/va',  '検証データ') }}{# 2018/05/16 #}</li>
                                        {% endif %}
                                        {# if report_rp #}{# 2018/06/04 #}
                                        {% if enable_rp_report_menu %}
                                            <li>{{ link_to('news/rp',  'MPXマーケットリスクプレミアム') }}{# 2018/04/27 #}</li>
                                        {% endif %}
                                        {% if enable_misc_report_menu %}
                                            <li>{{ link_to('news/o',   'エリア間値差カーブ') }}</li>
                                        {% endif %}
                                        {# if dl_tool #}
                                        {% if enable_tool_menu %}
                                            <li>{{ link_to('https://simulation.mpx-web.jp', 'フォワードカーブSIMツール', false, 'target': '_blank') }}</li>{# 2022/01/13 #}
                                            <li>{{ link_to('tool', '分析ツール') }}</li>
                                        {% endif %}
                                        {% if enable_pay_user_menu %}
                                            <li>{{ link_to('download/dlzip', 'データ一括ダウンロード', 'target': '_blank') }}</li>
                                            {# <li>{{ link_to('tool/flist', '分析データ') }}</li> #}
                                        {% endif %}
                                        {# if role > 8 or asp_flag #}
                                        {% if enable_asp_menu %}
                                            <li>{{ link_to('asp', 'ASP用ファイル一覧') }}</li>
                                        {% endif %}
                                    </ul>
                                </li>
                                {% if enable_profile_menu %}
                                    <li>{{ link_to('inquiry', 'お問い合せ') }}</li>
                                {% endif %}
                                {# if role > 8 #}
                                {% if enable_admin_menu %}
                                    <li>{{ link_to('management', '管理') }}</li>
                                {% endif %}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ shortEmail }}<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>{{ link_to('users/profile',     'プロファイル') }}</li>
                                        <li>{{ link_to('users/setpwd',      'パスワード変更') }}</li>
                                        <li>{{ link_to('session/logout',    'ログアウト') }}</li>
                                    </ul>
                                </li>
                            {# endif #}
                            {% if en is defined %}{# 2020/01/28 #}
                                <li>{{ link_to(en, 'English&nbsp;/&nbsp;Japanese') }}{# 2020/02/08 #}</li>
                            {% endif %}
                        </ul>
                    </div>
                </nav>
                <!-- /globalnav -->
            </header>
        <!--/header-->
        
        {{ content() }}

        </div> <!-- container -->
        
        <!-- footer -->
        <footer>
        <div class="container">
	<p id="footer_copy">Copyright MPX, Inc.</p>
	<ul id="footer_pp">
	</li>
	<li>{{ link_to('https://mpx.co.jp/', '運営会社', 'target': '_blank', false) }}</li>
	<li>{{ link_to('https://mpx.co.jp/privacy_policy/', '個人情報のお取り扱いについて', 'target': '_blank', false) }}</li>
	<li>{{ link_to('termsofuse', 'サイト利用条件') }}</li>
	<li>
            {# if role > 0 #}
            {% if enable_pay_user_menu %}
                {{ link_to('/clause', 'MPXサービス利用約款') }}
            {% endif %}
	</li>
	<li>
            {# if role > 0 #}
            {% if enable_pay_user_menu %}
                {{ link_to('/report/o/pricelist', '料金メニュー', 'target': '_blank') }}
            {% endif %}
            <span style="color: white">[{{ auth_string }}]</span>
	</li>
	</ul>
	<p id="footer_add">株式会社MPX<br>TEL 03-6386-8327　〒103-0027 東京都中央区日本橋2-10-5 GRANBIZ東京日本橋 5F</p>
        </div>
        </footer>
        <!-- /footer -->

        <!-- JS -->
                
        <!-- JavaScript -->
        {{ assets.outputJs() }}
        <script>
        // カレンダーの機能
        // 1桁の数字を0埋めで2桁にする
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
        $(function() {
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
            $("#date").datepicker("setDate", "<?php echo (empty($_POST['day']) ? '' : $_POST['day']); // 2018/10/22 ?>");
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
            $("#date").datepicker("setDate", "<?php echo (empty($_POST['day']) ? '' : $_POST['day']); // 2018/10/22 ?>");
        });
        {% endif %}
        
        {% if subs_calender_date_list is defined %}
        // 燃料・為替先物のカレンダー
        $(function() {
            {% set calender_date_list = subs_calender_date_list | json_encode %}
            var calender_date_list = {{ calender_date_list }};
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
            $("#subs_date").datepicker("setDate", "<?php echo (empty($_POST['day']) ? '' : $_POST['day']); // 2018/10/22 ?>");
        });
        {% endif %}  
        
        {% if oil_lng_coal_calender_date_list is defined %}
        // 燃料・為替先物のカレンダー
        $(function() {
            {% set oil_lng_coal_exist_upload_date = oil_lng_coal_exist_upload_date | json_encode %}
            var oil_lng_coal_exist_upload_date = {{ oil_lng_coal_exist_upload_date }};
            
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
            $("#oil_lng_coal_date").datepicker("setDate", "<?php echo (empty($_POST['selected_date_oil_lng_coal']) ? '' : $_POST['selected_date_oil_lng_coal']); 2018/10/22 ?>");
        });
        {% endif %}
        </script>
        
        
        <!-- csvダウンロードに使うjs -->
        {{ javascript_include('js/ac/plugins/export/export.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/pdfmake/pdfmake.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/jszip/jszip.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/fabric.js/fabric.js') }}
        {{ javascript_include('js/ac/plugins/export/libs/FileSaver.js/FileSaver.js') }}
        
        
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        {{ javascript_include('js/bootstrap.min.js') }}

        {# 2020/01/28 クッキー確認 #}
        <script>var cookieconf = {{ cookieconf }};</script>
        {{ javascript_include('js/cookieconf.js') }}
        
        <!-- ie10-viewport-bug-workaround JS -->
        {{ javascript_include('js/ie10-viewport-bug-workaround.js') }}
        
        <!-- ie-emulation-modes-warning JS -->
        {{ javascript_include('js/ie-emulation-modes-warning.js') }}
        
        {{ javascript_include('js/retina.min.js') }}
    </body>
</html>
