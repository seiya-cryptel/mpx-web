<!DOCTYPE html>
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
    </head>
    
    <body class="top_body">
        <div class="container-fluid">
            <header>
                <div id="logo_area">
                    <h1 id="logo_mpx">
                        {{ link_to('/index/e', image('img/logo_mpx_corp.png', 'alt': '株式会社MPX')) }}
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
                            {# if role > 0  2018/09/28 #}
                            {% if enable_forwardcurve_menu %}
                                <li {% if active_forwardcurve is defined %}class="{{ active_forwardcurve }}"{% endif %}>
                                    {{ link_to('forwardcurve/e', 'Forward Curve') }}
                                </li>
                            {% endif %}
                            {# 2016/10/07 PlanB 以上 #}
                            {# if role > 2
                                or email=='seiya@officeu.com'
                                or email=='yuh@sukagawagas.co.jp'
                                or email=='motohisa.miura_a@eneserve.co.jp'
                                or email=='eiko.fujii@toshiba.co.jp' #}
                            {% if enable_jepx_menu %}
                                <li {% if active_jepxfc is defined %}class="{{ active_jepxfc }}"{% endif %}>
                                    {{ link_to('jepxfc/e', 'JEPX Spot Price Forecast') }}
                                </li>
                            {% elseif enable_ds_price_menu %}{# 2019/11/25 #}
                                <li {% if active_jepxfc is defined %}class="{{ active_jepxfc }}"{% endif %}>
                                    {{ link_to('dsprice/e', 'JEPX Spot Price Forecast') }}
                                </li>
                            {% endif %}
                            <li>{{ link_to('background/e', 'Introduction') }}</li>
                            {#
                            <li>{{ link_to('aboutforwardcurve', '基礎知識') }}</li>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">サービス</a>
                                <ul class="dropdown-menu" role="menu">
                                <li>{{ link_to('mpx', 'MPXの特徴') }}</li>
                                <li>{{ link_to('service', 'サービスメニュー') }}</li>
                                <li>{{ link_to('sample', 'サンプル') }}</li>
                                <li>{{ link_to('clause', 'MPX Terms and Conditions of Use') }}</li>
                                </ul>
                            </li>
                            #}
                            {% if enable_pay_user_menu %}
                                <li>{{ link_to('inquiry/e', 'Inquiries') }}</li>
                            {% else %}
                                <li>{{ link_to('inquiry/gueste', 'Inquiries') }}</li>
                            {% endif %}
                            {# if role != null and role == 0 #}
                            {% if (not enable_pay_user_menu) and enable_asp_menu %}
                                <li>{{ link_to('asp/e', 'CSV Data Download for ASP User') }}</li>
                            {% endif %}
                            {# if role != null and role >= 0 #}
                            {% if enable_profile_menu %}
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{ email }}<span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li>{{ link_to('users/profilee',     'Profile') }}</li>
                                        <li>{{ link_to('users/setpwde',      'Change Password') }}</li>{# 2020/02/15 #}
                                        <li>{{ link_to('session/logout',    'Logout') }}</li>
                                    </ul>
                                </li>
                            {% else %}
                                <li>{{ link_to('login/e', '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>Log in', 'target': '_blank')}}</li>
                            {% endif %}
                            {% if ja is defined %}{# 2020/01/28 #}
                                <li>{{ link_to(ja, 'English&nbsp;/&nbsp;Japanese') }}{# 2020/02/08 #}</li>
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
        <div class="container-fluid">
	<p id="footer_copy">Copyright MPX, Inc.</p>
	<ul id="footer_pp">
	</li>
	<li>{{ link_to('https://mpx.co.jp', 'Operating Company', 'target': '_blank', false) }}</li>
	<li>{{ link_to('https://mpx.co.jp/privacy_policy/', 'Privacy Policy', 'target': '_blank', false) }}</li>
	<li>{{ link_to('termsofuse', 'Terms and Conditions') }}</li>
	<li>
            {# if role > 0  2018/09/28 #}
            {% if enable_pay_user_menu %}
                {{ link_to('/clause', 'MPX Terms and Conditions of Use') }}
            {% endif %}
	</li>
	<li>
            {# if role > 0  2018/09/28 #}
            {% if enable_pay_user_menu %}
                {{ link_to('/report/o/pricelist', 'Services Plans', 'target': '_blank') }}
            {% endif %}
            <span style="color: white">{{ auth_string }}</span>
	</li>
	</ul>
	<p id="footer_add">MPX, Inc.<br>GRANBIZ Tokyo Nihonbashi 5F, 10-5, Nihonbashi 2-chome, Chuo-ku, Tokyo 103-0027, Japan<br>TEL：+81-3-6386-8327</p>
        </div>
        </footer>
        <!-- /footer -->

        <!-- JS -->
        <!-- jQuery -->
        {# javascript_include('js/jquery.min.js') 2019/02/13 #}
        {{ javascript_include('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}
        
        <!-- JavaScript -->
        {{ assets.outputJs() }}
        
        <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
        {{ javascript_include('js/bootstrap.min.js') }}

        {# 2020/01/28 クッキー確認 #}
        <script>var cookieconf = {{ cookieconf }};</script>
        {{ javascript_include('js/cookieconfe.js') }}
        
        <!-- ie10-viewport-bug-workaround JS -->
        {{ javascript_include('js/ie10-viewport-bug-workaround.js') }}
        
        <!-- ie-emulation-modes-warning JS -->
        {{ javascript_include('js/ie-emulation-modes-warning.js') }}
        
        {{ javascript_include('js/retina.min.js') }}
    </body>
</html>
