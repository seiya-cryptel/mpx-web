{# views/index/index.volt #}
<!-- main_img -->
<div id="top_main_img">
{{ image('img/top_slider_1.jpg',  'srcset': '/img/top_slider_1.jpg 1x,/img/top_slider_1@2x.jpg 2x','class': 'topImg', 'alt': 'MPXは、卸電力取引のための、オンライン情報サービスです。卸電力取引に必要なあらゆるデータを反映し、独自のモデルで導いたフォワードカーブをご提供します。') }}
</div>
<!-- /main_img -->

<div class="row">
<div class="col-xs-12 col-sm-4 col-sm-offset-4">
      {{ flash.output() }}
</div>
</div>

<!-- contents_start -->
<div class="row">
<div class="col-xs-12 col-md-3">
<!-- twitte
<div class="explain_box" id="top_tweet_box">
<h1 class="top_news">Twitter</h1>
<a class="twitter-timeline"  href="https://twitter.com/MPXweb" data-widget-id="740140732653019138" width="100%" height="200" data-chrome="noheader nofooter noborders">@MPXwebさんのツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>              
 /twitter -->

<!-- news -->
<div class="explain_box" id="top_news_box">
<h1 class="top_news">お知らせ</h1>

<!-- news_list -->
            <dl id="news_list">
            {% for new in news %}
                <dt>
                    {{ new.date_notice_disp }}
                    <span class="label label_new">{{ new.newMark }}</span>
                    {% if new.category == 'NEWS' %}
                        <span class="label label_news">ニュース</span>
                    {% elseif new.category == 'REPORT_M' %}
                        <span class="label label_report">レポート</span>
                    {% elseif new.category == 'REPORT_W' %}
                        <span class="label label_report">レポート</span>
                    {# 2017/07/27 #}
                    {% elseif new.category == 'REPORT_LFC' %}
                        <span class="label label_report">レポート</span>
                    {# 2017/11/16 #}
                    {% elseif new.category == 'REPORT_GS' %}
                        <span class="label label_report">レポート</span>
                    {# 2018/05/04 #}
                    {% elseif new.category == 'REPORT_VA' %}
                        <span class="label label_report">レポート</span>
                    {% elseif new.category == 'REPORT_RP' %}
                        <span class="label label_report">レポート</span>
                    {% elseif new.category == 'MODEL' %}
                        <span class="label label_model">モデル</span>
                    {% endif %}
                </dt>
                <dd>
                {% if new.category == 'NEWS' %}
                    {% if new.url is not empty %}
                        {{ link_to(new.url, new.title, 'target': '_blank', new.relativeFlag) }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% elseif new.category == 'REPORT_M' %}
                    {# if role > 0 2018/10/19 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_monthly %}
                        {{ link_to('/report/m/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% elseif new.category == 'REPORT_W' %}
                    {# if role > 0 2018/10/19 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_weekly %}
                        {{ link_to('/report/w/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {# 2017/07/27 #}
                {% elseif new.category == 'REPORT_LFC' %}
                    {# if role > 0 2018/10/19 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_fc %}
                        {{ link_to('/report/fc/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {# 2017/11/16 #}
                {% elseif new.category == 'REPORT_GS' %}
                    {# if role > 0 2018/10/19 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_gs %}
                        {{ link_to('/report/gs/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {# 2018/05/04 #}
                {% elseif new.category == 'REPORT_VA' %}
                    {# if report_va #} {# 2018/05/16 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_va %}
                        {{ link_to('/report/va/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% elseif new.category == 'REPORT_RP' %}
                    {# if report_rp #} {# 2018/06/04 #}
                    {# if enable_pay_user_menu #}
                    {% if enable_report_rp %}
                        {{ link_to('/report/rp/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% elseif new.category == 'REPORT_O' %}
                    {# 2019/06/20 #}
                    {% if enable_report_misc %}
                        {{ link_to('/report/o/' ~ new.url, new.title, 'target': '_blank') }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% elseif new.category == 'MODEL' %}
                    {% if new.url is not empty %}
                        {{ link_to(new.url, new.title, 'target': '_blank', new.relativeFlag) }}
                    {% else %}
                        {{ new.title }}
                    {% endif %}
                {% endif %}
                </dd>
            {% endfor %}
            </dl>
            
<div class="link_news">{{ link_to('/news/', 'お知らせ一覧をみる<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>') }}</div>
</div>
</div>


<!--main -->
<div class="col-xs-12 col-md-9">
<!-- row_in -->
<div class="row">

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>MPX Renewablesのご紹介</h1>
	<div class="label_new_area">
{{ image('img/top_box_1.jpg', 'srcset': '/img/top_box_1.jpg 1x,/img/top_box_1@2x.jpg 2x') }}
	<span class="label_image label_new">NEW</span>
	</div>
	<div class="explain_txt_area box_tile"><span class="label_box label_service">サービス</span>
	<p>再エネの投資判断、収益・リスク評価、売電方法検討向けのサービスを配信します。</p>
	</div>
<p class="top_btn_area">{{ link_to('pdf/renewables-notice_221003.pdf', '詳しくみる', 'class': "btn btn-success", 'target': '_blank') }}</p>
</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>電力フォワードカーブとは</h1>
{{ image('img/top_box_2.jpg', 'srcset': '/img/top_box_2.jpg 1x,/img/top_box_2@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile">
	<span class="label_box label_basic">基礎知識</span>
	<p>電力フォワードカーブの概要、一般的な作成方法、利用用途などをご紹介します。</p>
	</div>
<p class="top_btn_area">{{ link_to('aboutforwardcurve', '詳しくみる', 'class': "btn btn-success") }}</p>
</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>ログイン</h1>
{{ image('img/top_box_login.jpg', 'srcset': '/img/top_box_login.jpg 1x,/img/top_box_login@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile">　</div>
<p class="top_btn_area">{{ link_to('login', '<span class="glyphicon glyphicon-lock" aria-hidden="true"></span>ログイン', 'class': "btn btn-success") }}</p>
</div>
</div>

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>MPXの特徴</h1>
{{ image('img/top_box_1_e.png') }}
	<div class="explain_txt_area box_tile"><span class="label_box label_service">サービス</span>
	<p>MPXのモデルの特徴、プラットフォームの機能などをご紹介します。</p>
    </div> 
<p class="top_btn_area">{{ link_to('mpx', '詳しくみる', 'class': "btn btn-success") }}</p>
</div>
</div>

<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>サービスメニュー</h1>
{{ image('img/top_box_4.jpg', 'srcset': '/img/top_box_4.jpg 1x,/img/top_box_4@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile"><span class="label_box label_service">サービス</span>
	<p>MPXでは、お客様の利用用途に応じて、複数のサービスメニューをご用意しています。</p> 
    </div>
<p class="top_btn_area">{{ link_to('service', '詳しくみる', 'class': "btn btn-success") }}</p>
</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>サンプル</h1>
 {{ image('img/top_box_sample.png', 'srcset': '/img/top_box_sample.png 1x,/img/top_box_sample@2x.png 2x') }}
	<div class="explain_txt_area box_tile">
    <span class="label_box label_service">サービス</span>
	<p>MPXの機能、サービスを体験できます。</p>
    </div>
<p class="top_btn_area">{{ link_to('sample', '詳しくみる', 'class': "btn btn-success") }}</p>
</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>フォワードカーブSIMツール{# 2021/12/29 ウィークリーレビュー #}</h1> 
{{ image('img/top_box_5.jpg', 'srcset': '/img/top_box_5.jpg 1x,/img/top_box_5@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile">
    {# 2021/12/29 <span class="label_box label_report">レポート</span><br> #}
    <span class="label_box label_basic">モデル</span><br>
	<p>お客様独自の燃料シナリオを前提としたフォワードカーブを概算することができます。{# 2021/12/29 電力フォワードカーブや背景にあるファンダメンタルの動きを週次で解説しています。#}</p>
    </div>

    {# if role > 0 2018/10/19 #}
    {% if enable_pay_user_menu %}
        {# 2021/12/29 <p class="top_btn_area">{{ link_to('news/w', '詳しくみる', 'class': "btn btn-success") }}</p> #}
        <p class="top_btn_area">{{ link_to('https://simulation.mpx-web.jp', 'リンク', false, 'class': "btn btn-success", 'target': '_blank') }}</p>{# 2022/01/13 #}
    {% else %}
        {# 2021/12/29 <p class="top_btn_area">{{ link_to('news/w', '詳しくみる', 'class': "btn btn-success", 'target': '_blank') }}</p> #}
        <p class="top_btn_area">{{ link_to('https://simulation.mpx-web.jp', 'リンク', false, 'class': "btn btn-success", 'target': '_blank') }}</p>
    {% endif %}

</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>マンスリーレポート</h1> 
{{ image('img/top_box_6.jpg', 'srcset': '/img/top_box_6.jpg 1x,/img/top_box_6@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile">
    <span class="label_box label_report">レポート</span><br>
	<p>毎月、様々なテーマを設定し、将来の卸電力価格に関するシナリオ分析を行っています。</p>
    </div>

    {% if role > 0 %}
        <p class="top_btn_area">{{ link_to('news/m', '詳しくみる', 'class': "btn btn-success") }}</p>
    {% else %}
        <p class="top_btn_area">{{ link_to('news/m', '詳しくみる', 'class': "btn btn-success", 'target': '_blank') }}</p>
    {% endif %}

</div>
</div>


<div class="col-xs-12 col-sm-4 topmenu_box">
<div class="explain_box">
<h1>お問い合わせ</h1>
{{ image('img/top_box_7.jpg', 'srcset': '/img/top_box_7.jpg 1x,/img/top_box_7@2x.jpg 2x') }}
	<div class="explain_txt_area box_tile">　</div>
<p class="top_btn_area">{{ link_to('inquiry/guest', 'お問い合わせ', 'class': "btn btn-success") }}</p>
</div>
</div>

</div>
<!-- /row_in -->


</div>
<!--/main -->

</div>
<!-- /row -->
<!-- contents_end -->
