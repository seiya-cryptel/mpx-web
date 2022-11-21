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
        <!-- 共通スタイル -->
        {{ stylesheet_link('css/common.css') }}         
        {{ assets.outputCss() }}
        <!-- jQuery -->
        {# javascript_include('js/jquery.min.js') 2019/02/13 #}
        {{ javascript_include('https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js') }}
    </head>
    
    <body class="top_body sample_body">
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
                            <li>{{ link_to('background', 'はじめに') }}</li>
                            <li>{{ link_to('aboutforwardcurve', '基礎知識') }}</li>
                            <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">サービス</a>
                                    <ul class="dropdown-menu" role="menu">
                                    <li>{{ link_to('mpx', 'MPXの特徴') }}</li>
                                    <li>{{ link_to('service', 'サービスメニュー') }}</li>
                                    <li>{{ link_to('sample', 'サンプル') }}</li>
                                    <li>{{ link_to('clause', 'サービス利用約款') }}</li>
                                    </ul>
                            </li>
                            <li>{{ link_to('inquiry/guest', 'お問い合わせ') }}</li>
                            <li>{{ link_to('login', '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>ログイン') }}</li>
                        </ul>
                    </div>
                </nav>
                <!-- /globalnav -->
            </header>
        
            {{ content() }}

        </div> <!-- container -->
        
        <footer>
            <div class="container-fluid">
                <p id="footer_copy">Copyright MPX, Inc.</p>
                <ul id="footer_pp">
                    <li>{{ link_to('https://mpx.co.jp/', '運営会社', 'target': '_blank', false) }}</li>
                    <li>{{ link_to('https://mpx.co.jp/privacy_policy/', '個人情報のお取り扱いについて', 'target': '_blank', false) }}</li>
                    <li>{{ link_to('termsofuse', 'サイト利用条件') }}</li>
                </ul>
                <p id="footer_add">株式会社MPX<br>TEL 03-6386-8327　〒103-0027 東京都中央区日本橋2-10-5 GRANBIZ東京日本橋 5F</p>
            </div>
        </footer>

        <!-- JS -->
        {{ javascript_include('js/ac/amcharts.js') }}
        {{ javascript_include('js/ac/serial.js') }}
        {{ javascript_include('js/ac/themes/light.js') }}
        {{ javascript_include('js/ac/amstock.js') }}
        
        <!-- JavaScript -->
        {{ assets.outputJs() }}
        
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
